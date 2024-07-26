<?php

namespace PrestaShop\Module\PsEventbus\Interfaces;

interface ShopContentServiceInterface
{
    public function getContentsForFull($offset, $limit, $langIso = null, $debug = false);
    public function getContentsForIncremental($limit, $contentIds, $langIso = null, $debug = false);
    public function countFullSyncContentLeft($offset, $langIso = null);
}
