<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\ProductDecorator;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;
use PrestaShop\Module\PsEventbus\Repository\ProductRepository;

class ProductDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var ProductDecorator
     */
    private $productDecorator;
    /**
     * @var ProductSupplierDataProvider
     */
    private $productSupplierDataProvider;
    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    public function __construct(
        ProductRepository $productRepository,
        ProductDecorator $productDecorator,
        ProductSupplierDataProvider $productSupplierDataProvider,
        LanguageRepository $languageRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productDecorator = $productDecorator;
        $this->productSupplierDataProvider = $productSupplierDataProvider;
        $this->languageRepository = $languageRepository;
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
        $langId = $this->languageRepository->getLanguageIdByIsoCode($langIso);

        $products = $this->productRepository->getProducts($offset, $limit, $langId);

        if (!$products) {
            return [];
        }

        $this->productDecorator->decorateProducts($products, $langIso, $langId);

        $bundles = $this->productDecorator->getBundles($products);

        $productSuppliers = $this->productSupplierDataProvider->getFormattedData($offset, $limit, $langIso);

        $products = array_map(function ($product) {
            return [
                'id' => $product['unique_product_id'],
                'collection' => Config::COLLECTION_PRODUCTS,
                'properties' => $product,
            ];
        }, $products);

        return array_merge($products, $bundles, $productSuppliers);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        $langId = $this->languageRepository->getLanguageIdByIsoCode($langIso);

        return (int) $this->productRepository->getRemainingProductsCount($offset, $langId);
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
        $langId = $this->languageRepository->getLanguageIdByIsoCode($langIso);

        $products = $this->productRepository->getProductsIncremental($limit, $langId, $objectIds);

        if (!empty($products)) {
            $this->productDecorator->decorateProducts($products, $langIso, $langId);
        } else {
            return [];
        }

        $bundles = $this->productDecorator->getBundles($products);

        $productSuppliers = $this->productSupplierDataProvider->getFormattedDataIncremental($limit, $langIso, $objectIds);

        $products = array_map(function ($product) {
            return [
                'id' => $product['unique_product_id'],
                'collection' => Config::COLLECTION_PRODUCTS,
                'properties' => $product,
            ];
        }, $products);

        return array_merge($products, $bundles, $productSuppliers);
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
        $langId = $this->languageRepository->getLanguageIdByIsoCode($langIso);

        return $this->productRepository->getQueryForDebug($offset, $limit, $langId);
    }
}
