<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\SupplierDecorator;
use PrestaShop\Module\PsEventbus\Repository\SupplierRepository;

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
     * @return array
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
     * @param array $objectIds
     *
     * @return array
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
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        return $this->supplierRepository->getQueryForDebug($offset, $limit, $langIso);
    }
}
