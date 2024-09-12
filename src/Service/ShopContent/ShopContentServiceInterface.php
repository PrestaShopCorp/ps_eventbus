<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

interface ShopContentServiceInterface
{
    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $debug);

    /**
     * @param int $limit
     * @param mixed $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug);

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return int
     */
    public function countFullSyncContentLeft($offset, $limit, $langIso);
}
