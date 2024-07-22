<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\ProductCarrierRepository;

class CustomProductCarrierDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var ProductCarrierRepository
     */
    private $productCarrierRepository;

    public function __construct(
        ProductCarrierRepository $productCarrierRepository
    ) {
        $this->productCarrierRepository = $productCarrierRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        $productCarriers = $this->productCarrierRepository->getProductCarriers($offset, $limit);
        $productCarriers = array_map(function ($productCarrier) {
            return [
                'id' => $productCarrier['id_product'] . '-' . $productCarrier['id_carrier_reference'],
                'collection' => Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS,
                'properties' => $productCarrier,
            ];
        }, $productCarriers);

        return $productCarriers;
    }

    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        /** @var array $productCarrierIncremental */
        $productCarrierIncremental = $this->productCarrierRepository->getProductCarrierIncremental(Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS, $langIso);

        if (!$productCarrierIncremental) {
            return [];
        }

        $productIds = array_column($productCarrierIncremental, 'id_object');

        /** @var array $productCarriers */
        $productCarriers = $this->productCarrierRepository->getProductCarriersProperties($productIds);

        return array_map(function ($productCarrier) {
            return [
                'id' => "{$productCarrier['id_product']}-{$productCarrier['id_carrier_reference']}",
                'collection' => Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS,
                'properties' => $productCarrier,
            ];
        }, $productCarriers);
    }

    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->productCarrierRepository->getRemainingProductCarriersCount($offset);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        return $this->productCarrierRepository->getQueryForDebug($offset, $limit);
    }
}
