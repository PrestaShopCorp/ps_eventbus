<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\ProductCarrierRepository;

class ProductCarriersService implements ShopContentServiceInterface
{
    /** @var ProductCarrierRepository */
    private $productCarrierRepository;

    public function __construct(ProductCarrierRepository $productCarrierRepository)
    {
        $this->productCarrierRepository = $productCarrierRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $debug)
    {
        $result = $this->productCarrierRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        return array_map(function ($item) {
            return [
                'id' => $item['id_carrier_reference'],
                'collection' => Config::COLLECTION_PRODUCT_CARRIERS,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<string, int> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $result = $this->productCarrierRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        return array_map(function ($item) {
            return [
                'id' => $item['id_product'] . '-' . $item['id_carrier_reference'],
                'collection' => Config::COLLECTION_PRODUCT_CARRIERS,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return int
     */
    public function getFullSyncContentLeft($offset, $limit, $langIso)
    {
        return $this->productCarrierRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }
}
