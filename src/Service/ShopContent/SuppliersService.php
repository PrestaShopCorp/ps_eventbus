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
use PrestaShop\Module\PsEventbus\Repository\SupplierRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class SuppliersService implements ShopContentServiceInterface
{
    /** @var SupplierRepository */
    private $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $explainSql
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $explainSql)
    {
        $result = $this->supplierRepository->retrieveContentsForFull($offset, $limit, $langIso, $explainSql);

        if (empty($result)) {
            return [];
        }

        $this->castSuppliers($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_supplier'],
                'collection' => Config::COLLECTION_SUPPLIERS,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<string, int> $contentIds
     * @param string $langIso
     * @param bool $explainSql
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $explainSql)
    {
        $result = $this->supplierRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $explainSql);

        if (empty($result)) {
            return [];
        }

        $this->castSuppliers($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_supplier'],
                'collection' => Config::COLLECTION_SUPPLIERS,
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
        return $this->supplierRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $suppliers
     *
     * @return void
     */
    private function castSuppliers(&$suppliers)
    {
        foreach ($suppliers as &$supplier) {
            $supplier['id_supplier'] = (int) $supplier['id_supplier'];
            $supplier['active'] = (bool) $supplier['active'];
            $supplier['id_lang'] = (int) $supplier['id_lang'];
            $supplier['id_shop'] = (int) $supplier['id_shop'];
            $supplier['created_at'] = (string) $supplier['created_at'];
            $supplier['updated_at'] = (string) $supplier['updated_at'];
        }
    }
}
