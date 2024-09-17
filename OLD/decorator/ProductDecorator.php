<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Formatter\ArrayFormatter;
use PrestaShop\Module\PsEventbus\Repository\BundleRepository;
use PrestaShop\Module\PsEventbus\Repository\CategoryRepository;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;
use PrestaShop\Module\PsEventbus\Repository\ProductRepository;

class ProductDecorator
{
    /**
     * @var \Context
     */
    private $context;
    /**
     * @var LanguageRepository
     */
    private $languageRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var ArrayFormatter
     */
    private $arrayFormatter;
    /**
     * @var BundleRepository
     */
    private $bundleRepository;

    /**
     * @var int
     */
    private $shopId;

    public function __construct(
        \Context $context,
        LanguageRepository $languageRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        ArrayFormatter $arrayFormatter,
        BundleRepository $bundleRepository
    ) {
        $this->context = $context;
        $this->languageRepository = $languageRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->arrayFormatter = $arrayFormatter;
        $this->bundleRepository = $bundleRepository;

        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $this->shopId = (int) $this->context->shop->id;
    }

    /**
     * @param array<mixed> $products
     *
     * @return array<mixed>
     */
    public function getBundles($products)
    {
        $bundles = [];
        foreach ($products as $product) {
            if ($product['is_bundle']) {
                $bundles = array_merge($bundles, $this->getBundleCollection($product));
            }
        }

        return $bundles;
    }

    /**
     * @param array<mixed> $product
     *
     * @return array<mixed>
     */
    private function getBundleCollection($product)
    {
        $bundleProducts = $this->bundleRepository->getBundleProducts($product['id_product']);
        $uniqueProductId = $product['unique_product_id'];

        return array_map(function ($bundleProduct) use ($uniqueProductId) {
            return [
                'id' => $bundleProduct['id_bundle'],
                'collection' => Config::COLLECTION_PRODUCT_BUNDLES,
                'properties' => [
                    'id_bundle' => $bundleProduct['id_bundle'],
                    'id_product' => $bundleProduct['id_product'],
                    'id_product_attribute' => $bundleProduct['id_product_attribute'],
                    'unique_product_id' => $uniqueProductId,
                    'quantity' => $bundleProduct['quantity'],
                ],
            ];
        }, $bundleProducts);
    }
}
