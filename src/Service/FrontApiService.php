<?php
namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Exception\FirebaseException;
use PrestaShop\Module\PsEventbus\Exception\QueryParamsException;
use PrestaShop\Module\PsEventbus\Exception\UnauthorizedException;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;
use PrestaShop\Module\PsEventbus\Repository\EventbusSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;
use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;
use PrestaShop\Module\PsEventbus\Service\SynchronizationService;
use PrestaShop\Module\PsEventbus\Service\ApiAuthorizationService;

class FrontApiService
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

    public function __construct(\Ps_eventbus $module)
    {  
        $this->module = $module;

        $this->errorHandler = $this->module->getService(ErrorHandler::class);

        try {
            $this->startTime = time();

            $this->psAccountsAdapterService = $this->module->getService(PsAccountsAdapterService::class);
            $this->authorizationService = $this->module->getService(ApiAuthorizationService::class);
            $this->synchronizationService = $this->module->getService(SynchronizationService::class);
            $this->eventbusSyncRepository = $this->module->getService(EventbusSyncRepository::class);

            $this->authorize();
        } catch (\Exception $exception) {
            // For ApiHealthCheck, handle the error, and throw UnauthorizedException directly, to catch-up at top level.
            if (strpos(get_class($this), 'apiHealthCheckController') !== false) {
                $this->errorHandler->handle($exception);
                throw new UnauthorizedException('You are not allowed to access to this resource');
            }

            if ($exception instanceof \PrestaShopDatabaseException) {
                $this->errorHandler->handle($exception);
                CommonService::exitWithExceptionMessage($exception);
            } elseif ($exception instanceof EnvVarException) {
                $this->errorHandler->handle($exception);
                CommonService::exitWithExceptionMessage($exception);
            } elseif ($exception instanceof FirebaseException) {
                $this->errorHandler->handle($exception);
                CommonService::exitWithExceptionMessage($exception);
            }
        }
    }

    public function handleDataSync($shopContent, $jobId, $langIso, $limit, $isFull, $debug = false)
    {
        try {
            if (!in_array($shopContent, Config::SHOP_CONTENTS, true)) {
                CommonService::exitWithExceptionMessage(new QueryParamsException('404 - ShopContent not found', Config::INVALID_URL_QUERY));
            }

            if ($limit < 0) {
                CommonService::exitWithExceptionMessage(new QueryParamsException('Invalid URL Parameters', Config::INVALID_URL_QUERY));
            }

            /** @var ConfigurationRepository $configurationRepository */
            $configurationRepository = $this->module->getService('PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository');
            /** @var LanguageRepository $languageRepository */
            $languageRepository = $this->module->getService('PrestaShop\Module\PsEventbus\Repository\LanguageRepository');
            /** @var IncrementalSyncRepository $incrementalSyncRepository */
            $incrementalSyncRepository = $this->module->getService('PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository');

            $timezone = (string) $configurationRepository->get('PS_TIMEZONE');
            $dateNow = (new \DateTime('now', new \DateTimeZone($timezone)))->format(Config::MYSQL_DATE_FORMAT);
            
            $langIso = $langIso ? $langIso : $languageRepository->getDefaultLanguageIsoCode();

            $offset = 0;
            $response = [];

            $typeSync = $this->eventbusSyncRepository->findTypeSync($shopContent, $langIso);

            if (is_array($typeSync)) {
                if (!$isFull) {
                    $offset = (int) $typeSync['offset'];
                } else {
                    $this->eventbusSyncRepository->updateTypeSync(
                        $shopContent,
                        $offset,
                        $dateNow,
                        false,
                        $langIso
                    );

                    $incrementalSyncRepository->removeIncrementaSyncObjectByType($shopContent);
                }
            } else {
                $this->eventbusSyncRepository->insertTypeSync($shopContent, $offset, $dateNow, $langIso);

                $isFull = true;
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
            
            CommonService::exitWithResponse(
                array_merge(
                    [
                        'job_id' => $jobId,
                        'object_type' => $shopContent,
                        'syncType' => $isFull ? 'full' : 'incremental',
                    ],
                    $response
                )
            );
        } catch (\PrestaShopDatabaseException $exception) {
            $this->errorHandler->handle($exception);
            CommonService::exitWithExceptionMessage($exception);
        } catch (EnvVarException $exception) {
            $this->errorHandler->handle($exception);
            CommonService::exitWithExceptionMessage($exception);
        } catch (FirebaseException $exception) {
            $this->errorHandler->handle($exception);
            CommonService::exitWithExceptionMessage($exception);
        } catch (\Exception $exception) {
            $this->errorHandler->handle($exception);
            CommonService::exitWithExceptionMessage($exception);
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
            CommonService::exitWithResponse($authorizationResponse);
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
}
