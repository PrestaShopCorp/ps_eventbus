<?php
namespace PrestaShop\Module\PsEventbus\Services;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Exception\FirebaseException;
use PrestaShop\Module\PsEventbus\Exception\QueryParamsException;
use PrestaShop\Module\PsEventbus\Exception\UnauthorizedException;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;
use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;
use PrestaShop\Module\PsEventbus\Service\SynchronizationService;
use PrestaShop\Module\PsEventbus\Service\ApiAuthorizationService;

abstract class FrontApiService
{
    /**
     * Timestamp when script started
     *
     * @var int
     */
    public $startTime;

    /**
     * @var ApiAuthorizationService
     */
    private $authorizationService;
    /**
     * @var EventbusSyncRepository
     */
    private $eventbusSyncRepository;
    /**
     * @var PsAccountsAdapterService
     */
    private $psAccountsAdapterService;
    /**
     * @var SynchronizationService
     */
    private $synchronizationService;
    /**
     * @var \Ps_eventbus
     */
    private $module;
    /**
     * @var ErrorHandler
     */
    private $errorHandler;

    public function __construct()
    {
        $this->errorHandler = $this->module->getService(ErrorHandler::class);

        try {
            $this->startTime = time();

            $this->psAccountsAdapterService = $this->module->getService(PsAccountsAdapterService::class);
            $this->authorizationService = $this->module->getService(ApiAuthorizationService::class);
            $this->synchronizationService = $this->module->getService(SynchronizationService::class);

            $this->authorize();
        } catch (\Exception $exception) {
            // For ApiHealthCheck, handle the error, and throw UnauthorizedException directly, to catch-up at top level.
            if (strpos(get_class($this), 'apiHealthCheckController') !== false) {
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

    public function handleDataSync($shopContent, $jobId, $langIso, $limit, $isFull, $debug = false)
    {
        try {
            if (!in_array($shopContent, Config::SHOP_CONTENTS, true)) {
                 $this->exitWithExceptionMessage(new QueryParamsException('404 - ShopContent not found', Config::INVALID_URL_QUERY));
            }

            if ($limit < 0) {
                $this->exitWithExceptionMessage(new QueryParamsException('Invalid URL Parameters', Config::INVALID_URL_QUERY));
            }

            /** @var ConfigurationRepository $configurationRepository */
            $configurationRepository = $this->module->getService('\PrestaShop\Module\PsEventbusV4\Repository\ConfigurationRepository');

            $timezone = (string) $configurationRepository->get('PS_TIMEZONE');
            $dateNow = (new \DateTime('now', new \DateTimeZone($timezone)))->format(Config::MYSQL_DATE_FORMAT);
            
            $offset = 0;
            $incrementalSync = false;
            $response = [];

            $typeSync = $this->eventbusSyncRepository->findTypeSync($shopContent, $langIso);

            if ($typeSync == false) {
                $this->eventbusSyncRepository->insertTypeSync($shopContent, $offset, $dateNow, $langIso);
            }

            if ($isFull) {
                $response = $this->synchronizationService->sendFullSync(
                    $shopContent,
                    $jobId,
                    $langIso,
                    $offset,
                    $limit,
                    $this->startTime,
                    $dateNow,
                    $debug
                );
            } else {
                $response = $this->synchronizationService->sendIncrementalSync(
                    $shopContent,
                    $jobId,
                    $langIso,
                    $limit,
                    $this->startTime,
                    $debug
                );
            }

            $this->exitWithResponse(
                [
                    'job_id' => $jobId,
                    'object_type' => $shopContent,
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
     * @param array $response
     *
     * @return void
     */
    private function exitWithResponse(array $response)
    {
        $httpCode = isset($response['httpCode']) ? (int) $response['httpCode'] : 200;

        $this->dieWithResponse($response, $httpCode);
    }

    /**
     * @param \Exception $exception
     *
     * @return void
     */
    private function exitWithExceptionMessage(\Exception $exception)
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
            'object_type' => \Tools::getValue('shopContent'),
            'status' => false,
            'httpCode' => $code,
            'message' => $exception->getMessage(),
        ];

        $this->dieWithResponse($response, (int) $code);
    }

    /**
     * @param array $response
     * @param int $code
     *
     * @return void
     */
    private function dieWithResponse(array $response, $code)
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
