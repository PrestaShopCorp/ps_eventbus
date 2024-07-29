<?php

namespace PrestaShop\Module\PsEventbus\Interfaces;

use DbQuery;

interface RepositoryInterface
{
    /** @var DbQuery */
    public $query;

    public function generateBaseQuery();
    public function getContentsForFull($offset, $limit, $langIso = null, $debug = false);
    public function getContentsForIncremental($limit, $contentIds, $langIso = null, $debug = false);
    public function countFullSyncContentLeft($offset, $langIso = null);
}
