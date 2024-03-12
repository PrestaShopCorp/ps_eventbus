<?php

namespace PrestaShop\Module\PsEventbus\Service;

/**
 * Injected instead instead of regular LiveSynchronizationService to disable live sync
 */
class NoopLiveSynchronizationService
{
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
    }
}
