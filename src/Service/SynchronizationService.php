<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Api\LiveSyncApiClient;
use PrestaShop\Module\PsEventbus\Decorator\PayloadDecorator;
use PrestaShop\Module\PsEventbus\Provider\PaginatedApiDataProviderInterface;
use PrestaShop\Module\PsEventbus\Repository\DeletedObjectsRepository;
use PrestaShop\Module\PsEventbus\Repository\EventbusSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;
use PrestaShop\Module\PsEventbus\Repository\LiveSyncRepository;

class SynchronizationService
{
    /**
     * @var \Ps_eventbus
     */
    private $module;

    /**
     * @var EventbusSyncRepository
     */
    private $eventbusSyncRepository;

    /**
     * @var IncrementalSyncRepository
     */
    private $incrementalSyncRepository;

    /**
     * @var LiveSyncRepository
     */
    private $liveSyncRepository;

    /**
     * @var DeletedObjectsRepository
     */
    private $deletedObjectsRepository;

    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * @var PayloadDecorator
     */
    private $payloadDecorator;

    /**
     * @var int
     */
    const RANDOM_SYNC_CHECK_MAX = 20;

    /**
     * @var int
     */
    const INCREMENTAL_SYNC_MAX_ITEMS_PER_SHOP_CONTENT = 100000;

    public function __construct(
        \Ps_eventbus $module,
        EventbusSyncRepository $eventbusSyncRepository,
        IncrementalSyncRepository $incrementalSyncRepository,
        LiveSyncRepository $liveSyncRepository,
        DeletedObjectsRepository $deletedObjectsRepository,
        LanguageRepository $languageRepository,
        PayloadDecorator $payloadDecorator
    ) {
        $this->module = $module;
        $this->eventbusSyncRepository = $eventbusSyncRepository;
        $this->incrementalSyncRepository = $incrementalSyncRepository;
        $this->liveSyncRepository = $liveSyncRepository;
        $this->deletedObjectsRepository = $deletedObjectsRepository;
        $this->languageRepository = $languageRepository;
        $this->payloadDecorator = $payloadDecorator;
    }

    /**
     * @param PaginatedApiDataProviderInterface $dataProvider
     * @param string $type
     * @param string $jobId
     * @param string $langIso
     * @param int $offset
     * @param int $limit
     * @param string $dateNow
     * @param int $scriptStartTime
     * @param bool $isFull
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException|EnvVarException|ApiException
     */
    public function handleFullSync(
        PaginatedApiDataProviderInterface $dataProvider,
        $type,
        $jobId,
        $langIso,
        $offset,
        $limit,
        $dateNow,
        $scriptStartTime,
        $isFull
    ) {
        $response = [];

        $data = $dataProvider->getFormattedData($offset, $limit, $langIso);

        $this->payloadDecorator->convertDateFormat($data);

        if (!empty($data)) {
            /** @var ProxyService */
            $proxyService = $this->module->getService('PrestaShop\Module\PsEventbus\Service\ProxyService');

            $response = $proxyService->upload($jobId, $data, $scriptStartTime, $isFull);

            if ($response['httpCode'] == 201) {
                $offset += $limit;
            }
        }

        $remainingObjects = (int) $dataProvider->getRemainingObjectsCount($offset, $langIso);

        if ($remainingObjects <= 0) {
            $remainingObjects = 0;
            $offset = 0;
        }

        $this->eventbusSyncRepository->updateTypeSync($type, $offset, $dateNow, $remainingObjects === 0, $langIso);

        return $this->returnSyncResponse($data, $response, $remainingObjects);
    }

    /**
     * @param PaginatedApiDataProviderInterface $dataProvider
     * @param string $type
     * @param string $jobId
     * @param int $limit
     * @param string $langIso
     * @param int $scriptStartTime
     * @param bool $isFull
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException|EnvVarException
     */
    public function handleIncrementalSync(
        PaginatedApiDataProviderInterface $dataProvider,
        $type,
        $jobId,
        $limit,
        $langIso,
        $scriptStartTime,
        $isFull
    ) {
        $response = [];

        $objectIds = $this->incrementalSyncRepository->getIncrementalSyncObjectIds($type, $langIso, $limit);

        if (empty($objectIds)) {
            return [
                'total_objects' => 0,
                'has_remaining_objects' => false,
                'remaining_objects' => 0,
            ];
        }

        $data = $dataProvider->getFormattedDataIncremental($limit, $langIso, $objectIds);

        $this->payloadDecorator->convertDateFormat($data);

        if (!empty($data)) {
            /** @var ProxyService */
            $proxyService = $this->module->getService('PrestaShop\Module\PsEventbus\Service\ProxyService');

            $response = $proxyService->upload($jobId, $data, $scriptStartTime, $isFull);

            if ($response['httpCode'] == 201) {
                $this->incrementalSyncRepository->removeIncrementalSyncObjects($type, $objectIds, $langIso);
            }
        } else {
            $this->incrementalSyncRepository->removeIncrementalSyncObjects($type, $objectIds, $langIso);
        }

        $remainingObjects = $this->incrementalSyncRepository->getRemainingIncrementalObjects($type, $langIso);

        return $this->returnSyncResponse($data, $response, $remainingObjects);
    }

    /**
     * liveSync
     *
     * @param string $shopContent
     * @param int $shopContentId
     * @param string $action
     *
     * @return void
     */
    public function sendLiveSync($shopContent, $shopContentId, $action)
    {
        $defaultIsoCode = $this->languageRepository->getDefaultLanguageIsoCode();

        if ($this->isFullSyncDone($shopContent, $defaultIsoCode) && $this->debounceLiveSync($shopContent)) {
            try {
                /** @var LiveSyncApiClient $liveSyncApiClient */
                $liveSyncApiClient = $this->module->getService('PrestaShop\Module\PsEventbus\Api\LiveSyncApiClient');

                $liveSyncApiClient->liveSync($shopContent, (int) $shopContentId, $action);
            } catch (\Exception $e) {
                // FIXME : report this error somehow
            }
        }
    }

    /**
     * @param int $objectId
     * @param string $type
     * @param string $createdAt
     * @param int $shopId
     * @param bool $hasMultiLang
     *
     * @return void
     */
    public function insertIncrementalSyncObject($objectId, $type, $createdAt, $shopId, $hasMultiLang = null)
    {
        if ((int) $objectId === 0) {
            return;
        }

        /*
         * randomly check if outbox for this shop-content contain more of 100k entries.
         * When random number == 10, we count number of entry exist in database for this specific shop content
         * If count > 100 000, we removed all entry corresponding to this shop content, and we enable full sync for this
         */
        if (mt_rand() % $this::RANDOM_SYNC_CHECK_MAX == 0) {
            $count = $this->incrementalSyncRepository->getIncrementalSyncObjectCountByType($type);
            if ($count > $this::INCREMENTAL_SYNC_MAX_ITEMS_PER_SHOP_CONTENT) {
                $hasDeleted = $this->incrementalSyncRepository->removeIncrementaSyncObjectByType($type);

                if ($hasDeleted) {
                    $this->eventbusSyncRepository->updateTypeSync(
                        $type,
                        0,
                        $createdAt,
                        false,
                        $this->languageRepository->getDefaultLanguageIsoCode()
                    );
                }
            }

            return;
        }

        $objectsData = [];

        if ($hasMultiLang) {
            $allIsoCodes = $this->languageRepository->getLanguagesIsoCodes();

            foreach ($allIsoCodes as $langIso) {
                if ($this->isFullSyncDone($type, $langIso)) {
                    array_push($objectsData,
                        [
                            'type' => $type,
                            'id_object' => $objectId,
                            'id_shop' => $shopId,
                            'lang_iso' => $langIso,
                            'created_at' => $createdAt,
                        ]
                    );
                }
            }
        } else {
            $defaultIsoCode = $this->languageRepository->getDefaultLanguageIsoCode();

            if ($this->isFullSyncDone($type, $defaultIsoCode)) {
                array_push($objectsData,
                    [
                        'type' => $type,
                        'id_object' => $objectId,
                        'id_shop' => $shopId,
                        'lang_iso' => $defaultIsoCode,
                        'created_at' => $createdAt,
                    ]
                );
            }
        }

        if (empty($objectsData) == false) {
            $this->incrementalSyncRepository->insertIncrementalObject($objectsData);
        }
    }

    /**
     * @param int $objectId
     * @param string $type
     * @param string $date
     * @param int $shopId
     *
     * @return void
     */
    public function insertDeletedObject($objectId, $type, $date, $shopId)
    {
        if ((int) $objectId === 0) {
            return;
        }

        $this->deletedObjectsRepository->insertDeletedObject($objectId, $type, $date, $shopId);
        $this->incrementalSyncRepository->removeIncrementalSyncObject($type, $objectId);
    }

    /**
     * @param string $shopContentName
     *
     * @return bool
     *
     * @@throws \PrestaShopDatabaseException
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
     * @param string|null $langIso
     *
     * @return bool
     */
    private function isFullSyncDone($shopContent, $langIso = null)
    {
        return $this->eventbusSyncRepository->isFullSyncDoneForThisTypeSync($shopContent, $langIso);
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
            'md5' => $this->getPayloadMd5($data),
        ], $syncResponse);
    }

    /**
     * @param array<mixed> $payload
     *
     * @return string
     */
    private function getPayloadMd5($payload)
    {
        return md5(
            implode(' ', array_map(function ($payloadItem) {
                return $payloadItem['id'];
            }, $payload))
        );
    }
}
