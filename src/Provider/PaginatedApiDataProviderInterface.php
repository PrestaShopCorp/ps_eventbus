<?php

namespace PrestaShop\Module\PsEventbus\Provider;

interface PaginatedApiDataProviderInterface
{
    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @throws PrestaShop\PrestaShop\Adapter\Entity\PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso);

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     *
     * @throws PrestaShop\PrestaShop\Adapter\Entity\PrestaShopDatabaseException
     */
    public function getRemainingObjectsCount($offset, $langIso);

    /**
     * @param int $limit
     * @param string $langIso
     * @param array $objectIds
     *
     * @return array
     *
     * @throws PrestaShop\PrestaShop\Adapter\Entity\PrestaShopDatabaseException
     */
    public function getFormattedDataIncremental($limit, $langIso, $objectIds);

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @throws PrestaShop\PrestaShop\Adapter\Entity\PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso);
}
