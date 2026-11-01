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

use PrestaShop\Module\PsEventbus\Api\CloudSyncClient;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;
use PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\LiveSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\SyncRepository;
use PrestaShop\Module\PsEventbus\Service\ShopContent\LanguagesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\ShopContentServiceInterface;
use PrestaShop\Module\PsEventbus\ServiceContainer\Exception\ServiceNotFoundException;

if (!defined('_PS_VERSION_')) {
    exit;
}

class SynchronizationService
{
    /**
     * @var CloudSyncClient
     */
    private $cloudSyncClient;

    /**
     * @var SyncRepository
     */
    private $syncRepository;

    /**
     * @var IncrementalSyncRepository
     */
    private $incrementalSyncRepository;

    /**
     * @var LiveSyncRepository
     */
    private $liveSyncRepository;

    /**
     * @var LanguagesService
     */
    private $languagesService;

    /**
     * @var ErrorHandler
     */
    private $errorHandler;

    public function __construct(
        CloudSyncClient $cloudSyncClient,
        SyncRepository $syncRepository,
        IncrementalSyncRepository $incrementalSyncRepository,
        LiveSyncRepository $liveSyncRepository,
        LanguagesService $languagesService,
        ErrorHandler $errorHandler
    ) {
        $this->cloudSyncClient = $cloudSyncClient;
        $this->syncRepository = $syncRepository;
        $this->incrementalSyncRepository = $incrementalSyncRepository;
        $this->liveSyncRepository = $liveSyncRepository;
        $this->languagesService = $languagesService;
        $this->errorHandler = $errorHandler;
    }

    /**
     * @param string $shopContent
     * @param string $jobId
     * @param string $langIso
     * @param int $limit
     * @param int $startTime
     * @param string $dateNow
     *
     * @return array<mixed>
     *
     * @@throws PrestaShopDatabaseException|EnvVarException|ApiException
     */
    public function sendFullSync(
        string $shopContent,
        string $jobId,
        string $langIso,
        int $limit,
        int $startTime,
        string $dateNow
    ) {
        $response = [];

        $shopContentApiService = $this->getShopContentService($shopContent);

        if ($shopContentApiService === null) {
            $serviceName = str_replace('_', '', ucwords($shopContent, '_'));

            throw new ServiceNotFoundException('PrestaShop\Module\PsEventbus\Service\ShopContent\\' . $serviceName . 'Service');
        }

        $lastSeekKey = $this->syncRepository->getLastSeekKey($shopContent, $langIso);

        $page = $shopContentApiService->getContentsForFull($lastSeekKey, $limit, $langIso);
        $data = $page['rows'];
        $newSeekKey = $page['lastSeekKey'] !== null ? $page['lastSeekKey'] : $lastSeekKey;
        $remainingObjects = (int) $shopContentApiService->getFullSyncContentLeft($newSeekKey, $langIso);

        CommonService::convertDateFormat($data);

        if (!empty($data)) {
            $response = $this->cloudSyncClient->upload($jobId, $data, $startTime, true);

            if ($response['httpCode'] != 201) {
                $newSeekKey = $lastSeekKey;
                $remainingObjects = max($remainingObjects, 1);
            }
        }

        $fullSyncFinished = $remainingObjects <= 0;

        $cursorMoved = $this->syncRepository->moveFullSyncCursor(
            $shopContent,
            $langIso,
            $lastSeekKey,
            $fullSyncFinished ? null : $newSeekKey,
            $fullSyncFinished,
            $dateNow
        );

        if (!$cursorMoved) {
            // the full sync was restarted meanwhile (outbox purged): the whole content is left again, and CloudSync
            // must ask for the next page even if this one looked like the last
            $fullSyncFinished = false;
            $remainingObjects = max((int) $shopContentApiService->getFullSyncContentLeft(null, $langIso), 1);
        }

        $reportedRemaining = $fullSyncFinished ? 0 : $remainingObjects;
        $reportedRemaining += $this->incrementalSyncRepository->getRemainingIncrementalObjects($shopContent, $langIso);

        return $this->returnSyncResponse($data, $response, $reportedRemaining);
    }

    /**
     * @param string $shopContent
     * @param string $jobId
     * @param string $langIso
     * @param int $limit
     * @param int $startTime
     *
     * @return array<mixed>
     *
     * @@throws PrestaShopDatabaseException|EnvVarException
     */
    public function sendIncrementalSync(
        string $shopContent,
        string $jobId,
        string $langIso,
        int $limit,
        int $startTime
    ) {
        $response = [];

        $serviceName = str_replace('_', '', ucwords($shopContent, '_'));
        $serviceId = 'PrestaShop\Module\PsEventbus\Service\ShopContent\\' . $serviceName . 'Service';

        /** @var \Ps_eventbus */
        $module = \Module::getInstanceByName('ps_eventbus');

        try {
            /** @var ShopContentServiceInterface $shopContentApiService */
            $shopContentApiService = $module->getService($serviceId);
        } catch (ServiceNotFoundException $e) {
            throw new ServiceNotFoundException($serviceId);
        }

        $contentsToSync = $this->incrementalSyncRepository->getIncrementalSyncObjects($shopContent, $langIso, $limit);

        $upsertedContents = array_filter($contentsToSync, function ($content) {
            return $content['action'] == Config::INCREMENTAL_TYPE_UPSERT;
        });

        $deletedContents = array_filter($contentsToSync, function ($content) {
            return $content['action'] == Config::INCREMENTAL_TYPE_DELETE;
        });

        $data = $shopContentApiService->getContentsForIncremental($limit, $upsertedContents, $deletedContents, $langIso);

        CommonService::convertDateFormat($data);

        if (!empty($data)) {
            $response = $this->cloudSyncClient->upload($jobId, $data, $startTime, false);

            if ($response['httpCode'] == 201) {
                $this->incrementalSyncRepository->removeIncrementalSyncObjects($shopContent, array_column($contentsToSync, 'id'), $langIso);
            }
        } else {
            $this->incrementalSyncRepository->removeIncrementalSyncObjects($shopContent, array_column($contentsToSync, 'id'), $langIso);
        }

        $remainingObjects = $this->incrementalSyncRepository->getRemainingIncrementalObjects($shopContent, $langIso);

        return $this->returnSyncResponse($data, $response, $remainingObjects);
    }

    /**
     * liveSync
     *
     * @param mixed $contents
     * @param string $actionType
     *
     * @return void
     */
    public function sendLiveSync($contents, $actionType)
    {
        if (!is_array($contents)) {
            $contents = [$contents];
        }

        $defaultIsoCode = $this->languagesService->getDefaultLanguageIsoCode();

        foreach ($contents as $content) {
            if ($this->isFullSyncDone($content, $defaultIsoCode) && $this->debounceLiveSync($content)) {
                try {
                    $this->cloudSyncClient->liveSync($content, $actionType);
                } catch (\Exception $exception) {
                    $this->errorHandler->handle($exception);
                }
            }
        }
    }

    /**
     * @param array<string, mixed> $contentTypesWithIds
     * @param string $actionType
     * @param string $createdAt
     * @param int $shopId
     * @param bool $hasMultiLang
     *
     * @return void
     */
    public function insertContentIntoIncremental($contentTypesWithIds, $actionType, $createdAt, $shopId, $hasMultiLang)
    {
        if (count($contentTypesWithIds) == 0) {
            return;
        }

        /*
         * Once in INCREMENTAL_SYNC_TABLE_SIZE_CHECK_MOD calls, check the outbox size of each shop content, per language
         * of the current shop: CloudSync reads it per (content, shop, language). The outbox of a pair above
         * INCREMENTAL_SYNC_MAX_TABLE_SIZE is purged, then its full sync restarts, which stops recording into it.
         * In that order, an event recorded in between is kept: at worst it is sent twice. The other pairs are left alone.
         */
        if ($this->shouldCheckOutboxSize()) {
            foreach (array_keys($contentTypesWithIds) as $contentType) {
                $oversizedLangIsos = $this->incrementalSyncRepository->getLangIsosOverSizeForCurrentShop(
                    $contentType,
                    Config::INCREMENTAL_SYNC_MAX_TABLE_SIZE
                );

                foreach ($oversizedLangIsos as $langIso) {
                    $this->incrementalSyncRepository->removeIncrementalSyncObjectsForCurrentShop($contentType, $langIso);
                    $this->syncRepository->upsertTypeSync($contentType, null, $createdAt, false, $langIso);
                }
            }
        }

        $isoCodes = $hasMultiLang
            ? $this->languagesService->getLanguagesIsoCodes()
            : [$this->languagesService->getDefaultLanguageIsoCode()];

        $contentToInsert = [];

        foreach ($isoCodes as $langIso) {
            foreach ($contentTypesWithIds as $contentType => $contentIds) {
                if (!is_array($contentIds)) {
                    $contentIds = [$contentIds];
                }

                foreach ($contentIds as $contentId) {
                    // transform id_product to unique_product_id (multi-lang path only, pre-existing behavior)
                    if ($hasMultiLang && $contentType == Config::COLLECTION_PRODUCTS && is_int($contentId)) {
                        $contentId = $contentId . '-0';
                    }

                    if (!$this->shouldRecordIntoOutbox($contentType, $langIso, (string) $contentId)) {
                        continue;
                    }

                    $contentToInsert[] = [
                        'type' => $contentType,
                        'id_object' => $contentId,
                        'id_shop' => $shopId,
                        'lang_iso' => $langIso,
                        'action' => $actionType,
                        'created_at' => $createdAt,
                    ];
                }
            }
        }

        if (!empty($contentToInsert)) {
            $this->incrementalSyncRepository->insertIncrementalObject($contentToInsert);
        }
    }

    /**
     * Samples the calls that check the outbox size: counting it on every event would be too costly.
     * Not security-sensitive.
     *
     * @return bool
     */
    protected function shouldCheckOutboxSize()
    {
        return mt_rand() % Config::INCREMENTAL_SYNC_TABLE_SIZE_CHECK_MOD == 0;
    }

    /**
     * @param string $shopContentName
     *
     * @return bool
     *
     * @@throws PrestaShopDatabaseException
     */
    private function debounceLiveSync($shopContentName) // @phpstan-ignore method.unused
    {
        $dateNow = date('Y-m-d H:i:s');

        $shopContent = $this->liveSyncRepository->getShopContentInfo($shopContentName);

        $lastChangeAt = $shopContent != null ? (string) $shopContent['last_change_at'] : (string) $dateNow;
        $diff = strtotime((string) $dateNow) - strtotime((string) $lastChangeAt);

        if ($shopContent == null || $diff > 60 * 5) {
            $this->liveSyncRepository->upsertDebounce($shopContentName, $dateNow);

            return true;
        }

        return false;
    }

    /**
     * Return true if full sync is done for this shop content
     *
     * @param string $shopContent
     * @param string $langIso
     *
     * @return bool
     */
    private function isFullSyncDone($shopContent, $langIso)
    {
        return $this->syncRepository->isFullSyncDoneForThisTypeSync($shopContent, $langIso);
    }

    /**
     * Record a hook mutation into the outbox when full sync is done, or when
     * the row's encoded id sits behind the cursor of an in-progress full sync.
     * Rows ahead of the cursor are skipped: the moving full-sync window will
     * pick them up.
     *
     * @param string $contentType
     * @param string $langIso
     * @param string $contentId
     *
     * @return bool
     */
    private function shouldRecordIntoOutbox($contentType, $langIso, $contentId)
    {
        if ($this->isFullSyncDone($contentType, $langIso)) {
            return true;
        }

        $lastSeekKey = $this->syncRepository->getLastSeekKey($contentType, $langIso);
        if ($lastSeekKey === null) {
            return false;
        }

        $service = $this->getShopContentService($contentType);
        if ($service === null) {
            return false;
        }

        return $service->isAtOrBehindSeekKey($contentId, $lastSeekKey);
    }

    /**
     * @param string $contentType
     *
     * @return ShopContentServiceInterface|null
     */
    protected function getShopContentService($contentType)
    {
        $serviceName = str_replace('_', '', ucwords($contentType, '_'));
        $serviceId = 'PrestaShop\\Module\\PsEventbus\\Service\\ShopContent\\' . $serviceName . 'Service';

        /** @var \Ps_eventbus $module */
        $module = \Module::getInstanceByName('ps_eventbus');

        try {
            return $module->getService($serviceId);
        } catch (ServiceNotFoundException $e) {
            return null;
        }
    }

    /**
     * @param array<mixed> $data
     * @param array<mixed> $syncResponse
     * @param int $remainingObjects
     *
     * @return array<mixed>
     */
    private function returnSyncResponse($data, $syncResponse, $remainingObjects)
    {
        return array_merge([
            'total_objects' => count($data),
            'has_remaining_objects' => $remainingObjects > 0,
            'remaining_objects' => $remainingObjects,
            'md5' => md5(serialize($data)),
        ], $syncResponse);
    }
}
