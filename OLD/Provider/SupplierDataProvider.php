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

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\SupplierDecorator;
use PrestaShop\Module\PsEventbus\Repository\SupplierRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class SupplierDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var SupplierRepository
     */
    private $supplierRepository;

    /**
     * @var SupplierDecorator
     */
    private $supplierDecorator;

    public function __construct(SupplierRepository $supplierRepository, SupplierDecorator $supplierDecorator)
    {
        $this->supplierRepository = $supplierRepository;
        $this->supplierDecorator = $supplierDecorator;
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
        $suppliers = $this->supplierRepository->getSuppliers($offset, $limit, $langIso);

        if (!is_array($suppliers)) {
            return [];
        }
        $this->supplierDecorator->decorateSuppliers($suppliers);

        return array_map(function ($supplier) {
            return [
                'id' => $supplier['id_supplier'],
                'collection' => Config::COLLECTION_SUPPLIERS,
                'properties' => $supplier,
            ];
        }, $suppliers);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->supplierRepository->getRemainingSuppliersCount($offset, $langIso);
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
        $suppliers = $this->supplierRepository->getSuppliersIncremental($limit, $langIso, $objectIds);

        if (!is_array($suppliers)) {
            return [];
        }
        $this->supplierDecorator->decorateSuppliers($suppliers);

        return array_map(function ($supplier) {
            return [
                'id' => $supplier['id_supplier'],
                'collection' => Config::COLLECTION_SUPPLIERS,
                'properties' => $supplier,
            ];
        }, $suppliers);
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
        return $this->supplierRepository->getQueryForDebug($offset, $limit, $langIso);
    }
}
