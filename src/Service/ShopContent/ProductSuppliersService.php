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
use PrestaShop\Module\PsEventbus\Repository\ProductSupplierRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ProductSuppliersService implements ShopContentServiceInterface
{
    /** @var ProductSupplierRepository */
    private $productSupplierRepository;

    public function __construct(ProductSupplierRepository $productSupplierRepository)
    {
        $this->productSupplierRepository = $productSupplierRepository;
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
        $result = $this->productSupplierRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castProductsSuppliers($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_product_supplier'],
                'collection' => Config::COLLECTION_PRODUCT_SUPPLIERS,
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
        $result = $this->productSupplierRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castProductsSuppliers($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_product_supplier'],
                'collection' => Config::COLLECTION_PRODUCT_SUPPLIERS,
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
        return $this->productSupplierRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $productSuppliers
     *
     * @return void
     */
    private function castProductsSuppliers(&$productSuppliers)
    {
        foreach ($productSuppliers as &$productSupplier) {
            $productSupplier['id_product_supplier'] = (int) $productSupplier['id_product_supplier'];
            $productSupplier['id_product'] = (int) $productSupplier['id_product'];
            $productSupplier['id_product_attribute'] = (int) $productSupplier['id_product_attribute'];
            $productSupplier['id_supplier'] = (int) $productSupplier['id_supplier'];
            $productSupplier['product_supplier_price_te'] = (float) $productSupplier['product_supplier_price_te'];
            $productSupplier['id_currency'] = (int) $productSupplier['id_currency'];
        }
    }
}
