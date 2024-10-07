<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\ProductBundleRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

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
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso)
    {
        $result = $this->productBundleRepository->retrieveContentsForFull($offset, $limit, $langIso);

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
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso)
    {
        $result = $this->productBundleRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso);

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
            $productBundle['id_product'] = $productBundle['id_product_item'];
            $productBundle['unique_product_id'] = "{$productBundle['id_bundle']}-{$productBundle['product_id_attribute']}-{$langIso}";

            unset($productBundle['product_id_attribute']);
            unset($productBundle['id_product_item']);
            unset($productBundle['id_product_attribute_item']);
        }
    }
}
