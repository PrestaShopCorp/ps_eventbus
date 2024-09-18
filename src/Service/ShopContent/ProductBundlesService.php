<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\ProductBundleRepository;

class ProductBundlesService implements ShopContentServiceInterface
{
    /** @var ProductBundleRepository */
    private $productBundleRepository;

    public function __construct(ProductBundleRepository $productBundleRepository)
    {
        $this->productBundleRepository = $productBundleRepository;
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
        $result = $this->productBundleRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castProductsBundles($result, $langIso);

        return array_map(function ($item) {
            return [
                'id' => $item['id_bundle'],
                'collection' => Config::COLLECTION_PRODUCT_BUNDLES,
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
        $result = $this->productBundleRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castProductsBundles($result, $langIso);

        return array_map(function ($item) {
            return [
                'id' => $item['id_bundle'],
                'collection' => Config::COLLECTION_PRODUCT_BUNDLES,
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
        return $this->productBundleRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $productBundles
     * @param string $langIso
     *
     * @return void
     */
    private function castProductsBundles(&$productBundles, $langIso)
    {
        foreach ($productBundles as &$productBundle) {
            $productBundle['id_bundle'] = $productBundle['id_bundle'];
            $productBundle['id_product'] = $productBundle['id_product_item'];
            $productBundle['id_product_attribute'] = $productBundle['id_product_attribute'];
            $productBundle['unique_product_id'] = "{$productBundle['id_bundle']}-{$productBundle['product_id_attribute']}-{$langIso}";
            $productBundle['quantity'] = $productBundle['quantity'];

            unset($productBundle['product_id_attribute']);
            unset($productBundle['id_product_item']);
            unset($productBundle['id_product_attribute_item']);
        }
    }
}
