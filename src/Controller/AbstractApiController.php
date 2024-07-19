<?php

namespace PrestaShop\Module\PsEventbus\Controller;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Exception\FirebaseException;
use PrestaShop\Module\PsEventbus\Exception\QueryParamsException;
use PrestaShop\Module\PsEventbus\Exception\UnauthorizedException;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;
use PrestaShop\Module\PsEventbus\Provider\PaginatedApiDataProviderInterface;
use PrestaShop\Module\PsEventbus\Repository\EventbusSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;
use PrestaShop\Module\PsEventbus\Service\ApiAuthorizationService;
use PrestaShop\Module\PsEventbus\Service\ProxyService;
use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;
use PrestaShop\Module\PsEventbus\Service\SynchronizationService;

const MYSQL_DATE_FORMAT = 'Y-m-d H:i:s';

abstract class AbstractApiController extends \ModuleFrontController
{
    /**
     * Endpoint name
     *
     * @var string
     */
    public $type = '';
    /**
     * Timestamp when script started
     *
     * @var int
     */
    public $startTime;
    /**
     * @var ApiAuthorizationService
     */
    protected $authorizationService;
    /**
     * @var ProxyService
     */
    protected $proxyService;
    /**
     * @var EventbusSyncRepository
     */
    protected $eventbusSyncRepository;
    /**
     * @var LanguageRepository
     */
    private $languageRepository;
    /**
     * @var PsAccountsAdapterService
     */
    private $psAccountsAdapterService;
    /**
     * @var IncrementalSyncRepository
     */
    protected $incrementalSyncRepository;
    /**
     * @var SynchronizationService
     */
    private $synchronizationService;
    /**
     * @var \Ps_eventbus
     */
    public $module;
    /**
     * @var bool
     */
    public $psAccountsInstalled = true;

    /**
     * @var ErrorHandler
     */
    public $errorHandler;

    public function __construct()
    {
        parent::__construct();

        $this->ajax = true;
        $this->content_only = true;
        $this->controller_type = 'module';

        $this->errorHandler = $this->module->getService(ErrorHandler::class);
        try {
            $this->psAccountsAdapterService = $this->module->getService(PsAccountsAdapterService::class);
            $this->proxyService = $this->module->getService(ProxyService::class);
            $this->authorizationService = $this->module->getService(ApiAuthorizationService::class);
            $this->synchronizationService = $this->module->getService(SynchronizationService::class);
        } catch (\Exception $exception) {
            $this->errorHandler->handle($exception);
            $this->exitWithExceptionMessage($exception);
        }

        $this->eventbusSyncRepository = $this->module->getService(EventbusSyncRepository::class);
        $this->languageRepository = $this->module->getService(LanguageRepository::class);
        $this->incrementalSyncRepository = $this->module->getService(IncrementalSyncRepository::class);
    }

    /**
     * @return bool|void
     *
     * @throws UnauthorizedException
     */
    public function init()
    {
        $this->startTime = time();

        try {
            $this->authorize();
        } catch (\Exception $exception) {
            // For ApiHealthCheck, handle the error, and throw UnauthorizedException directly, to catch-up at top level.
            if (strpos($this->page_name, 'apiHealthCheck') !== false) {
                $this->errorHandler->handle($exception);
                throw new UnauthorizedException('You are not allowed to access to this resource');
            }

            if ($exception instanceof \PrestaShopDatabaseException) {
                $this->errorHandler->handle($exception);
                $this->exitWithExceptionMessage($exception);
            } elseif ($exception instanceof EnvVarException) {
                $this->errorHandler->handle($exception);
                $this->exitWithExceptionMessage($exception);
            } elseif ($exception instanceof FirebaseException) {
                $this->errorHandler->handle($exception);
                $this->exitWithExceptionMessage($exception);
            }
        }
    }

    /**
     * @return void
     *
     * @throws \PrestaShopDatabaseException|EnvVarException|FirebaseException
     */
    private function authorize()
    {
        /** @var string $jobId */
        $jobId = \Tools::getValue('job_id', 'empty_job_id');

        $authorizationResponse = $this->authorizationService->authorizeCall($jobId);

        if (is_array($authorizationResponse)) {
            $this->exitWithResponse($authorizationResponse);
        } elseif (!$authorizationResponse) {
            throw new \PrestaShopDatabaseException('Failed saving job id to database');
        }

        try {
            $token = $this->psAccountsAdapterService->getOrRefreshToken();
        } catch (\Exception $exception) {
            throw new FirebaseException($exception->getMessage());
        }

        if (!$token) {
            throw new FirebaseException('Invalid token');
        }
    }

    /**
     * @param PaginatedApiDataProviderInterface $dataProvider
     *
     * @return array<mixed>
     */
    protected function handleDataSync(PaginatedApiDataProviderInterface $dataProvider)
    {
        /** @var bool $debug */
        $debug = \Tools::getValue('debug') == 1;

        /** @var string $jobId */
        $jobId = \Tools::getValue('job_id');
        /** @var string $langIso */
        $langIso = \Tools::getValue('lang_iso', $this->languageRepository->getDefaultLanguageIsoCode());
        /** @var int $limit */
        $limit = \Tools::getValue('limit', 50);

        if ($limit < 0) {
            $this->exitWithExceptionMessage(new QueryParamsException('Invalid URL Parameters', Config::INVALID_URL_QUERY));
        }

        /** @var bool $initFullSync */
        $initFullSync = \Tools::getValue('full', 0) == 1;

        /** @var \PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository $configurationRepository */
        $configurationRepository = $this->module->getService(\PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository::class);
        $timezone = (string) $configurationRepository->get('PS_TIMEZONE');

        $dateNow = (new \DateTime('now', new \DateTimeZone($timezone)))->format(MYSQL_DATE_FORMAT);
        $offset = 0;
        $incrementalSync = false;
        $response = [];

        try {
            $typeSync = $this->eventbusSyncRepository->findTypeSync($this->type, $langIso);

            if ($debug) {
                $response = $dataProvider->getQueryForDebug($offset, $limit, $langIso);

                return array_merge(
                    [
                        'object_type' => $this->type,
                    ],
                    $response
                );
            }

            if ($typeSync !== false && is_array($typeSync)) {
                $offset = (int) $typeSync['offset'];

                if ((int) $typeSync['full_sync_finished'] === 1 && !$initFullSync) {
                    $incrementalSync = true;
                } elseif ($initFullSync) {
                    $offset = 0;
                    $this->eventbusSyncRepository->updateTypeSync(
                        $this->type,
                        $offset,
                        $dateNow,
                        false,
                        $langIso
                    );

                    $this->incrementalSyncRepository->removeIncrementaSyncObjectByType($this->type);
                }
            } else {
                $this->eventbusSyncRepository->insertTypeSync($this->type, $offset, $dateNow, $langIso);
            }

            if ($incrementalSync) {
                $response = $this->synchronizationService->handleIncrementalSync(
                    $dataProvider,
                    $this->type,
                    $jobId,
                    $limit,
                    $langIso,
                    $this->startTime,
                    $initFullSync
                );
            } else {
                $response = $this->synchronizationService->handleFullSync(
                    $dataProvider,
                    $this->type,
                    $jobId,
                    $langIso,
                    $offset,
                    $limit,
                    $dateNow,
                    $this->startTime,
                    $initFullSync
                );
            }

            return array_merge(
                [
                    'job_id' => $jobId,
                    'object_type' => $this->type,
                    'syncType' => $incrementalSync ? 'incremental' : 'full',
                ],
                $response
            );
        } catch (\PrestaShopDatabaseException $exception) {
            $this->errorHandler->handle($exception);
            $this->exitWithExceptionMessage($exception);
        } catch (EnvVarException $exception) {
            $this->errorHandler->handle($exception);
            $this->exitWithExceptionMessage($exception);
        } catch (FirebaseException $exception) {
            $this->errorHandler->handle($exception);
            $this->exitWithExceptionMessage($exception);
        } catch (\Exception $exception) {
            $this->errorHandler->handle($exception);
            $this->exitWithExceptionMessage($exception);
        }

        return $response;
    }

    /**
     * @param array<mixed>|null $value
     * @param string|null $controller
     * @param string|null $method
     *
     * @return void
     *
     * @throws \PrestaShopException
     */
    public function ajaxDie($value = null, $controller = null, $method = null)
    {
        parent::ajaxDie(json_encode($value) ?: null, $controller, $method);
    }

    /**
     * @param array<mixed> $response
     *
     * @return void
     */
    protected function exitWithResponse($response)
    {
        $httpCode = isset($response['httpCode']) ? (int) $response['httpCode'] : 200;

        $this->dieWithResponse($response, $httpCode);
    }

    /**
     * @param \Exception $exception
     *
     * @return void
     */
    protected function exitWithExceptionMessage(\Exception $exception)
    {
        $code = $exception->getCode() == 0 ? 500 : $exception->getCode();

        if ($exception instanceof \PrestaShopDatabaseException) {
            $code = Config::DATABASE_QUERY_ERROR_CODE;
        } elseif ($exception instanceof EnvVarException) {
            $code = Config::ENV_MISCONFIGURED_ERROR_CODE;
        } elseif ($exception instanceof FirebaseException) {
            $code = Config::REFRESH_TOKEN_ERROR_CODE;
        } elseif ($exception instanceof QueryParamsException) {
            $code = Config::INVALID_URL_QUERY;
        }

        $response = [
            'object_type' => $this->type,
            'status' => false,
            'httpCode' => $code,
            'message' => $exception->getMessage(),
        ];

        $this->dieWithResponse($response, (int) $code);
    }

    /**
     * @param array<mixed> $response
     * @param int $code
     *
     * @return void
     */
    private function dieWithResponse($response, $code)
    {
        $httpStatusText = "HTTP/1.1 $code";

        if (array_key_exists((int) $code, Config::HTTP_STATUS_MESSAGES)) {
            $httpStatusText .= ' ' . Config::HTTP_STATUS_MESSAGES[(int) $code];
        } elseif (isset($response['body']['statusText'])) {
            $httpStatusText .= ' ' . $response['body']['statusText'];
        }

        $response['httpCode'] = (int) $code;

        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Content-Type: application/json;charset=utf-8');
        header($httpStatusText);

        echo json_encode($response, JSON_UNESCAPED_SLASHES);

        exit;
    }
}
