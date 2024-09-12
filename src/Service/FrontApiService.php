<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Exception\FirebaseException;
use PrestaShop\Module\PsEventbus\Exception\QueryParamsException;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;
use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;
use PrestaShop\Module\PsEventbus\Repository\EventbusSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class FrontApiService
{
    /** @var int */
    public $startTime;

    /** @var ApiAuthorizationService */
    private $apiAuthorizationService;

    /** @var EventbusSyncRepository */
    private $eventbusSyncRepository;

    /** @var PsAccountsAdapterService */
    private $psAccountsAdapterService;

    /** @var SynchronizationService */
    private $synchronizationService;

    /** @var \Ps_eventbus */
    private $module;

    /** @var ErrorHandler */
    private $errorHandler;

    public function __construct(
        \Ps_eventbus $module,
        ErrorHandler $errorHandler,
        PsAccountsAdapterService $psAccountsAdapterService,
        ApiAuthorizationService $apiAuthorizationService,
        SynchronizationService $synchronizationService,
        EventbusSyncRepository $eventbusSyncRepository
    ) {
        $this->startTime = time();

        $this->module = $module;
        $this->errorHandler = $errorHandler;
        $this->psAccountsAdapterService = $psAccountsAdapterService;
        $this->apiAuthorizationService = $apiAuthorizationService;
        $this->synchronizationService = $synchronizationService;
        $this->eventbusSyncRepository = $eventbusSyncRepository;
    }

    /**
     * @param string $shopContent
     * @param string $jobId
     * @param string $langIso
     * @param int $limit
     * @param bool $fullSyncRequested
     * @param bool $debug
     * @param bool $ise2e
     *
     * @return void
     */
    public function handleDataSync($shopContent, $jobId, $langIso, $limit, $fullSyncRequested, $debug, $ise2e)
    {
        try {
            if (!in_array($shopContent, array_merge(Config::SHOP_CONTENTS, [Config::COLLECTION_HEALTHCHECK]), true)) {
                CommonService::exitWithExceptionMessage(new QueryParamsException('404 - ShopContent not found', Config::INVALID_URL_QUERY));
            }

            $isHealthCheck = $shopContent == Config::COLLECTION_HEALTHCHECK;
            $isAuthentified = $this->authorize($jobId, $isHealthCheck);

            if ($isHealthCheck) {
                /** @var HealthCheckService $healthCheckService */
                $healthCheckService = $this->module->getService('PrestaShop\Module\PsEventbus\Service\HealthCheckService');

                $healthCheckService->getHealthCheck($isAuthentified);

                return;
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

            $response = [];

            $typeSync = $this->eventbusSyncRepository->findTypeSync($shopContent, $langIso);

            // If no typesync exist, or if fullsync is requested by user
            if (!is_array($typeSync) || $fullSyncRequested) {
                $isFullSync = true;
                $fullSyncIsFinished = false;
                $offset = 0;

                if ($typeSync) {
                    $incrementalSyncRepository->removeIncrementaSyncObjectByType($shopContent);
                }

                $this->eventbusSyncRepository->upsertTypeSync(
                    $shopContent,
                    $offset,
                    $dateNow,
                    $fullSyncIsFinished,
                    $langIso
                );
            // Else if fullsync is not finished
            } elseif (!boolval($typeSync['full_sync_finished'])) {
                $isFullSync = true;
                $fullSyncIsFinished = false;
                $offset = (int) $typeSync['offset'];
            // Else, we are in incremental sync
            } else {
                $isFullSync = false;
                $fullSyncIsFinished = $typeSync['full_sync_finished'];
                $offset = (int) $typeSync['offset'];
            }

            if ($isFullSync) {
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
                        'syncType' => $isFullSync ? 'full' : 'incremental',
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
        } catch (ServiceNotFoundException $exception) {
            $this->catchGenericException($exception, $ise2e);
        } catch (\Exception $exception) {
            $this->catchGenericException($exception, $ise2e);
        }
    }

    /**
     * @param mixed $exception
     * @param mixed $ise2e
     *
     * @return void
     *
     * @throws \Exception
     */
    private function catchGenericException($exception, $ise2e)
    {
        $this->errorHandler->handle($exception);

        // if debug mode enabled, print error
        if (_PS_MODE_DEV_ == true && $ise2e == false) {
            throw $exception;
        }

        CommonService::dieWithResponse(['message' => 'An error occured. Please check shop logs for more information'], 500);
    }

    /**
     * @param string $jobId
     * @param bool $isHealthCheck
     *
     * @return bool
     *
     * @throws \PrestaShopDatabaseException|EnvVarException|FirebaseException
     */
    private function authorize($jobId, $isHealthCheck)
    {
        try {
            $authorizationResponse = $this->apiAuthorizationService->authorizeCall($jobId);

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

            return true;
        } catch (\Exception $exception) {
            // For ApiHealthCheck, handle the error, and return false
            if ($isHealthCheck) {
                return false;
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

            return false;
        }
    }
}
