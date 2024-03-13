<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Api\LiveSyncApiClient;
use PrestaShop\Module\PsEventbus\Repository\LiveSyncRepository;

class LiveSynchronizationService implements LiveSynchronizationServiceInterface
{
    /**
     * @var LiveSyncApiClient
     */
    private $liveSyncApiClient;
    /**
     * @var LiveSyncRepository
     */
    private $liveSyncRepository;

    public function __construct(
        LiveSyncApiClient $liveSyncApiClient,
        LiveSyncRepository $liveSyncRepository
    ) {
        $this->liveSyncApiClient = $liveSyncApiClient;
        $this->liveSyncRepository = $liveSyncRepository;
    }

    /**
     * @param string $shopContentName
     *
     * @return bool
     *
     * @throws \PrestaShopDatabaseException
     */
    private function debounceLiveSync(string $shopContentName)
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
     * @param string $shopContent
     * @param int $shopContentId
     * @param string $action
     *
     * @return void
     *
     * @throws \PrestaShopDatabaseException
     */
    public function liveSync(string $shopContent, int $shopContentId, string $action)
    {
        if ($this->debounceLiveSync($shopContent)) {
            try {
                $this->liveSyncApiClient->liveSync($shopContent, (int) $shopContentId, $action);
            } catch (\Exception $e) {
                // FIXME : report this error somehow
            }
        }
    }
}
