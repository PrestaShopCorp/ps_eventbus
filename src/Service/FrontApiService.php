<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Exception\FirebaseException;
use PrestaShop\Module\PsEventbus\Exception\QueryParamsException;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;
use PrestaShop\Module\PsEventbus\Repository\EventbusSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository;
use PrestaShop\Module\PsEventbus\Service\ShopContent\LanguagesService;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

if (!defined('_PS_VERSION_')) {
    exit;
}

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
     * @param bool $explainSql
     * @param bool $verbose
     * @param bool $psLogEnabled
     * 
     * @return void
     */
    public function handleDataSync($shopContent, $jobId, $langIso, $limit, $fullSyncRequested, $explainSql, $verbose, $psLogEnabled)
    {
        try {
            if (!in_array($shopContent, array_merge(Config::SHOP_CONTENTS, [Config::COLLECTION_HEALTHCHECK]), true)) {
                CommonService::exitWithExceptionMessage(new QueryParamsException('404 - ShopContent not found', Config::INVALID_URL_QUERY));
            }

            if ($limit < 0) {
                CommonService::exitWithExceptionMessage(new QueryParamsException('Invalid URL Parameters', Config::INVALID_URL_QUERY));
            }

            $isHealthCheck = $shopContent == Config::COLLECTION_HEALTHCHECK;
            $isAuthentified = $this->authorize($jobId, $isHealthCheck);
            $response = [];

            // If is healthcheck, return healthcheck response
            if ($isHealthCheck) {
                /** @var HealthCheckService $healthCheckService */
                $healthCheckService = $this->module->getService('PrestaShop\Module\PsEventbus\Service\HealthCheckService');
                $response = $healthCheckService->getHealthCheck($isAuthentified);

                CommonService::exitWithResponse($response);
            }

            /** @var LanguagesService $languagesService */
            $languagesService = $this->module->getService('PrestaShop\Module\PsEventbus\Service\ShopContent\LanguagesService');

            $timezone = (string) \Configuration::get('PS_TIMEZONE');
            $dateNow = (new \DateTime('now', new \DateTimeZone($timezone)))->format(Config::MYSQL_DATE_FORMAT);
            $langIso = $langIso ? $langIso : $languagesService->getDefaultLanguageIsoCode();

            $typeSync = $this->eventbusSyncRepository->findTypeSync($shopContent, $langIso);

            // If no typesync exist, or if fullsync is requested by user
            if (!is_array($typeSync) || $fullSyncRequested) {
                $isFullSync = true;
                $fullSyncIsFinished = false;
                $offset = 0;

                if ($typeSync) {
                    /** @var IncrementalSyncRepository $incrementalSyncRepository */
                    $incrementalSyncRepository = $this->module->getService('PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository');
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
                    $explainSql
                );
            } else {
                $response = $this->synchronizationService->sendIncrementalSync(
                    $shopContent,
                    $jobId,
                    $langIso,
                    $limit,
                    $this->startTime,
                    $explainSql
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
            $this->errorHandler->handle($exception, $verbose, $psLogEnabled);
        } catch (EnvVarException $exception) {
            $this->errorHandler->handle($exception, $verbose, $psLogEnabled);
        } catch (FirebaseException $exception) {
            $this->errorHandler->handle($exception, $verbose, $psLogEnabled);
        } catch (ServiceNotFoundException $exception) {
            $this->errorHandler->handle($exception, $verbose, $psLogEnabled);
        } catch (\Exception $exception) {
            $this->errorHandler->handle($exception, $verbose, $psLogEnabled);
        }
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
                $this->errorHandler->handle($exception, false, false);
            } elseif ($exception instanceof EnvVarException) {
                $this->errorHandler->handle($exception, false, false);
            } elseif ($exception instanceof FirebaseException) {
                $this->errorHandler->handle($exception, false, false);
            }

            return false;
        }
    }
}
