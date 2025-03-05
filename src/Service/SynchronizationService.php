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
     * @param int $offset
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
        int $offset,
        int $limit,
        int $startTime,
        string $dateNow
    ) {
        $response = [];

        $serviceName = str_replace('_', '', ucwords($shopContent, '_'));
        $serviceId = 'PrestaShop\Module\PsEventbus\Service\ShopContent\\' . $serviceName . 'Service'; // faire un mapping entre le service et le nom du shopcontent

        /** @var \Ps_eventbus */
        $module = \Module::getInstanceByName('ps_eventbus');

        try {
            /** @var ShopContentServiceInterface $shopContentApiService */
            $shopContentApiService = $module->getService($serviceId);
        } catch (ServiceNotFoundException $e) {
            throw new ServiceNotFoundException($serviceId);
        }

        $data = $shopContentApiService->getContentsForFull($offset, $limit, $langIso);

        CommonService::convertDateFormat($data);

        if (!empty($data)) {
            $response = $this->cloudSyncClient->upload($jobId, $data, $startTime, true);

            if ($response['httpCode'] == 201) {
                $offset += $limit;
            }
        }

        $remainingObjects = (int) $shopContentApiService->getFullSyncContentLeft($offset, $limit, $langIso);

        if ($remainingObjects <= 0) {
            $remainingObjects = 0;
            $offset = 0;
        }

        $this->syncRepository->upsertTypeSync($shopContent, $offset, $dateNow, $remainingObjects === 0, $langIso);

        return $this->returnSyncResponse($data, $response, $remainingObjects);
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
         * randomly check if outbox for this shop-content contain more of 100k entries.
         * When random number == 10, we count number of entry exist in database for this specific shop content
         * If count > 100 000, we removed all entry corresponding to this shop content, and we enable full sync for this
         */
        if (mt_rand() % Config::INCREMENTAL_SYNC_TABLE_SIZE_CHECK_MOD == 0) {
            foreach ($contentTypesWithIds as $contentType => $contentIds) {
                $count = $this->incrementalSyncRepository->getIncrementalSyncObjectCountByType($contentType);

                if ($count > Config::INCREMENTAL_SYNC_MAX_TABLE_SIZE) {
                    $hasDeleted = $this->incrementalSyncRepository->removeIncrementaSyncObjectByType($contentType);

                    if ($hasDeleted) {
                        $this->syncRepository->upsertTypeSync(
                            $contentType,
                            0,
                            $createdAt,
                            false,
                            $this->languagesService->getDefaultLanguageIsoCode()
                        );
                    }
                }

                return;
            }
        }

        $contentToInsert = [];

        if ($hasMultiLang) {
            $allIsoCodes = $this->languagesService->getLanguagesIsoCodes();

            foreach ($allIsoCodes as $langIso) {
                foreach ($contentTypesWithIds as $contentType => $contentIds) {
                    if ($this->isFullSyncDone($contentType, $langIso)) {
                        if (!is_array($contentIds)) {
                            $contentIds = [$contentIds];
                        }

                        $finalContent = array_map(function ($contentId) use ($contentType, $shopId, $langIso, $actionType, $createdAt) {
                            // transform id_product to unique_product_id
                            if ($contentType == Config::COLLECTION_PRODUCTS) {
                                $contentId = is_int($contentId) ? $contentId . '-0' : $contentId;
                            }

                            return [
                                'type' => $contentType,
                                'id_object' => $contentId,
                                'id_shop' => $shopId,
                                'lang_iso' => $langIso,
                                'action' => $actionType,
                                'created_at' => $createdAt,
                            ];
                        }, $contentIds);

                        $contentToInsert = array_merge($contentToInsert, $finalContent);
                    }
                }
            }
        } else {
            $defaultIsoCode = $this->languagesService->getDefaultLanguageIsoCode();

            foreach ($contentTypesWithIds as $contentType => $contentIds) {
                if ($this->isFullSyncDone($contentType, $defaultIsoCode)) {
                    if (!is_array($contentIds)) {
                        $contentIds = [$contentIds];
                    }

                    $finalContent = array_map(function ($contentId) use ($contentType, $shopId, $defaultIsoCode, $actionType, $createdAt) {
                        return [
                            'type' => $contentType,
                            'id_object' => $contentId,
                            'id_shop' => $shopId,
                            'lang_iso' => $defaultIsoCode,
                            'action' => $actionType,
                            'created_at' => $createdAt,
                        ];
                    }, $contentIds);
                    $contentToInsert = array_merge($contentToInsert, $finalContent);
                }
            }
        }

        if (!empty($contentToInsert)) {
            $this->incrementalSyncRepository->insertIncrementalObject($contentToInsert);
        }
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
