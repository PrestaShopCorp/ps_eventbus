<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\ProductSupplierDecorator;
use PrestaShop\Module\PsEventbus\Repository\ProductSupplierRepository;

class ProductSupplierDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var ProductSupplierRepository
     */
    private $productSupplierRepository;
    /**
     * @var ProductSupplierDecorator
     */
    private $productSupplierDecorator;

    public function __construct(
        ProductSupplierRepository $productSupplierRepository,
        ProductSupplierDecorator $productSupplierDecorator
    ) {
        $this->productSupplierRepository = $productSupplierRepository;
        $this->productSupplierDecorator = $productSupplierDecorator;
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
        $productSuppliers = $this->productSupplierRepository->getProductSuppliers($offset, $limit);

        if (empty($productSuppliers)) {
            return [];
        }
        $this->productSupplierDecorator->decorateProductSuppliers($productSuppliers);

        return array_map(function ($productSupplier) {
            return [
                'id' => $productSupplier['id_product_supplier'],
                'collection' => Config::COLLECTION_PRODUCT_SUPPLIERS,
                'properties' => $productSupplier,
            ];
        }, $productSuppliers);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->productSupplierRepository->getRemainingProductSuppliersCount($offset);
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
        $productSuppliers = $this->productSupplierRepository->getProductSuppliersIncremental($limit, $objectIds);

        if (!is_array($productSuppliers) || empty($productSuppliers)) {
            return [];
        }

        $this->productSupplierDecorator->decorateProductSuppliers($productSuppliers);

        return array_map(function ($productSupplier) {
            return [
                'id' => $productSupplier['id_product_supplier'],
                'collection' => Config::COLLECTION_PRODUCT_SUPPLIERS,
                'properties' => $productSupplier,
            ];
        }, $productSuppliers);
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
        return $this->productSupplierRepository->getQueryForDebug($offset, $limit);
    }
}
