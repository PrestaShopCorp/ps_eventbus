<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\StoreDecorator;
use PrestaShop\Module\PsEventbus\Repository\StoreRepository;

class StoreDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var StoreRepository
     */
    private $storeRepository;
    /**
     * @var StoreDecorator
     */
    private $storeDecorator;

    public function __construct(StoreRepository $storeRepository, StoreDecorator $storeDecorator)
    {
        $this->storeRepository = $storeRepository;
        $this->storeDecorator = $storeDecorator;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        $stores = $this->storeRepository->getStores($offset, $limit, $langIso);

        if (!is_array($stores)) {
            return [];
        }

        $this->storeDecorator->decorateStores($stores);

        return array_map(function ($store) {
            return [
                'id' => $store['id_store'],
                'collection' => Config::COLLECTION_STORES,
                'properties' => $store,
            ];
        }, $stores);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->storeRepository->getRemainingStoreCount($offset, $langIso);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array<mixed> $objectIds
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        $stores = $this->storeRepository->getStoresIncremental($limit, $langIso, $objectIds);

        if (!is_array($stores)) {
            return [];
        }

        $this->storeDecorator->decorateStores($stores);

        return array_map(function ($store) {
            return [
                'id' => $store['id_store'],
                'collection' => Config::COLLECTION_STORES,
                'properties' => $store,
            ];
        }, $stores);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        return $this->storeRepository->getQueryForDebug($offset, $limit, $langIso);
    }
}
