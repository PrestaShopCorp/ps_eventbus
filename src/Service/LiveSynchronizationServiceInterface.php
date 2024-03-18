<?php

namespace PrestaShop\Module\PsEventbus\Service;

interface LiveSynchronizationServiceInterface
{
    /**
     * @param string $shopContent
     * @param int $shopContentId
     * @param string $action
     *
     * @return void
     */
    public function liveSync(string $shopContent, int $shopContentId, string $action);
}
