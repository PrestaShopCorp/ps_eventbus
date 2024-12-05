<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Exception\QueryParamsException;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;
use PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\SyncRepository;
use PrestaShop\Module\PsEventbus\Service\ShopContent\LanguagesService;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ApiShopContentService
{
    /** @var int */
    public $startTime;

    /** @var ApiAuthorizationService */
    private $apiAuthorizationService;

    /** @var SyncRepository */
    private $syncRepository;

    /** @var SynchronizationService */
    private $synchronizationService;

    /** @var \Ps_eventbus */
    private $module;

    /** @var ErrorHandler */
    private $errorHandler;

    public function __construct(
        \Ps_eventbus $module,
        ApiAuthorizationService $apiAuthorizationService,
        SynchronizationService $synchronizationService,
        SyncRepository $syncRepository,
        ErrorHandler $errorHandler
    ) {
        $this->startTime = time();

        $this->module = $module;
        $this->errorHandler = $errorHandler;
        $this->apiAuthorizationService = $apiAuthorizationService;
        $this->synchronizationService = $synchronizationService;
        $this->syncRepository = $syncRepository;
    }

    /**
     * @param string $shopContent
     * @param string $jobId
     * @param string $langIso
     * @param int $limit
     * @param bool $fullSyncRequested
     *
     * @return void
     */
    public function handleDataSync($shopContent, $jobId, $langIso, $limit, $fullSyncRequested)
    {
        try {
            if (!in_array($shopContent, Config::SHOP_CONTENTS, true)) {
                CommonService::exitWithExceptionMessage(new QueryParamsException('404 - ShopContent not found', Config::INVALID_URL_QUERY));
            }

            if ($limit < 0) {
                CommonService::exitWithExceptionMessage(new QueryParamsException('Invalid URL Parameters', Config::INVALID_URL_QUERY));
            }

            $this->apiAuthorizationService->authorize($jobId, false);

            $response = [];

            /** @var LanguagesService $languagesService */
            $languagesService = $this->module->getService(LanguagesService::class);

            $timezone = (string) \Configuration::get('PS_TIMEZONE');
            $dateNow = (new \DateTime('now', new \DateTimeZone($timezone)))->format(Config::MYSQL_DATE_FORMAT);
            $langIso = $langIso ? $langIso : $languagesService->getDefaultLanguageIsoCode();

            $typeSync = $this->syncRepository->findTypeSync($shopContent, $langIso);

            // If no typesync exist, or if fullsync is requested by user
            if (!is_array($typeSync) || $fullSyncRequested) {
                $isFullSync = true;
                $fullSyncIsFinished = false;
                $offset = 0;

                if ($typeSync) {
                    /** @var IncrementalSyncRepository $incrementalSyncRepository */
                    $incrementalSyncRepository = $this->module->getService(IncrementalSyncRepository::class);
                    $incrementalSyncRepository->removeIncrementaSyncObjectByType($shopContent);
                }

                $this->syncRepository->upsertTypeSync(
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
                    $dateNow
                );
            } else {
                $response = $this->synchronizationService->sendIncrementalSync(
                    $shopContent,
                    $jobId,
                    $langIso,
                    $limit,
                    $this->startTime
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
        } catch (\Exception $exception) {
            $this->errorHandler->handle($exception);
        }
    }
}
