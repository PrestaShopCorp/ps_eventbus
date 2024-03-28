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
     * @param array $products
     * @param string $langIso
     * @param int $langId
     *
     * @return void
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function decorateProducts(array &$products, $langIso, $langId)
    {
        $this->addFeatureValues($products, $langId);
        $this->addAttributeValues($products, $langId);
        $this->addImages($products);

        foreach ($products as &$product) {
            $this->addLanguageIsoCode($product, $langIso);
            $this->addUniqueId($product);
            $this->addAttributeId($product);
            $this->addLink($product);
            $this->addProductPrices($product);
            $this->formatDescriptions($product);
            $this->addCategoryTree($product);
            $this->castPropertyValues($product);
        }
    }

    /**
     * @param array $products
     *
     * @return array
     */
    public function getBundles(array $products)
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
     * @param array $product
     *
     * @return void
     */
    private function addLink(array &$product)
    {
        try {
            if ($this->context->link === null) {
                throw new \PrestaShopException('No link context');
            }

            $product['link'] = $this->context->link->getProductLink(
                $product,
                null,
                null,
                null,
                $this->languageRepository->getLanguageIdByIsoCode($product['iso_code']),
                $this->shopId,
                $product['id_attribute']
            );
        } catch (\PrestaShopException $e) {
            $product['link'] = '';
        }
    }

    /**
     * @param array $product
     *
     * @return void
     */
    private function addProductPrices(array &$product)
    {
        $product['price_tax_excl'] = (float) $product['price_tax_excl'];
        $product['price_tax_incl'] =
            (float) $this->productRepository->getPriceTaxIncluded($product['id_product'], $product['id_attribute']);
        $product['sale_price_tax_excl'] =
            (float) $this->productRepository->getSalePriceTaxExcluded($product['id_product'], $product['id_attribute']);
        $product['sale_price_tax_incl'] =
            (float) $this->productRepository->getSalePriceTaxIncluded($product['id_product'], $product['id_attribute']);

        $product['tax'] = $product['price_tax_incl'] - $product['price_tax_excl'];
        $product['sale_tax'] = $product['sale_price_tax_incl'] - $product['sale_price_tax_excl'];
    }

    private function getBundleCollection(array $product): array
    {
        $bundleProducts = $this->bundleRepository->getBundleProducts($product['id_product']);
        $uniqueProductId = $product['unique_product_id'];

        return array_map(function ($bundleProduct) use ($uniqueProductId) {
            return [
                'id' => $bundleProduct['id_bundle'],
                'collection' => Config::COLLECTION_BUNDLES,
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

    /**
     * @param array $product
     *
     * @return void
     */
    private function formatDescriptions(array &$product)
    {
        $product['description'] = base64_encode($product['description']);
        $product['description_short'] = base64_encode($product['description_short']);
    }

    /**
     * @param array $product
     *
     * @return void
     */
    private function addCategoryTree(array &$product)
    {
        $categoryPaths = $this->categoryRepository->getCategoryPaths(
            $product['id_category_default'],
            $this->languageRepository->getLanguageIdByIsoCode($product['iso_code']),
            $this->shopId
        );

        $product['category_path'] = $categoryPaths['category_path'];
        $product['category_id_path'] = $categoryPaths['category_id_path'];
    }

    /**
     * @param array $product
     *
     * @return void
     */
    private function castPropertyValues(array &$product)
    {
        $product['id_product'] = (int) $product['id_product'];
        $product['id_manufacturer'] = (int) $product['id_manufacturer'];
        $product['id_supplier'] = (int) $product['id_supplier'];
        $product['id_attribute'] = (int) $product['id_attribute'];
        $product['id_category_default'] = (int) $product['id_category_default'];
        $product['quantity'] = (int) $product['quantity'];
        $product['weight'] = (float) $product['weight'];
        $product['active'] = $product['active'] == '1';
        $product['manufacturer'] = (string) $product['manufacturer'];
        $product['default_category'] = (string) $product['default_category'];
        $product['isbn'] = isset($product['isbn']) ? (string) $product['isbn'] : '';
        $product['mpn'] = isset($product['mpn']) ? (string) $product['mpn'] : '';
        $product['ean'] = (string) $product['ean'];
        $product['upc'] = (string) $product['upc'];
        $product['is_default_attribute'] = $product['id_attribute'] === 0 ? true : $product['is_default_attribute'] == 1;
        $product['available_for_order'] = $product['available_for_order'] == '1';
        $product['available_date'] = (string) $product['available_date'];
        $product['is_bundle'] = $product['is_bundle'] == '1';
        $product['is_virtual'] = $product['is_virtual'] == '1';
        if ($product['unit_price_ratio'] == 0) {
            unset($product['unit_price_ratio']);
            unset($product['unity']);
        } else {
            $product['unit_price_ratio'] = (float) $product['unit_price_ratio'];
            $product['unity'] = (string) $product['unity'];
            $product['price_per_unit'] = (float) ($product['price_tax_excl'] / $product['unit_price_ratio']);
        }
    }

    /**
     * @param array $product
     *
     * @return void
     */
    private function addUniqueId(array &$product)
    {
        $product['unique_product_id'] = "{$product['id_product']}-{$product['id_attribute']}-{$product['iso_code']}";
    }

    /**
     * @param array $product
     *
     * @return void
     */
    private function addAttributeId(array &$product)
    {
        $product['id_product_attribute'] = "{$product['id_product']}-{$product['id_attribute']}";
    }

    /**
     * @param array $product
     * @param string $langiso
     *
     * @return void
     */
    private function addLanguageIsoCode(&$product, $langiso)
    {
        $product['iso_code'] = $langiso;
    }

    /**
     * @param array $products
     * @param int $langId
     *
     * @return void
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function addFeatureValues(array &$products, $langId)
    {
        $productIds = $this->arrayFormatter->formatValueArray($products, 'id_product', true);
        $features = $this->productRepository->getProductFeatures($productIds, $langId);

        foreach ($products as &$product) {
            $product['features'] = isset($features[$product['id_product']]) ? $features[$product['id_product']] : '';
        }
    }

    /**
     * @param array $products
     * @param int $langId
     *
     * @return void
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function addAttributeValues(array &$products, $langId)
    {
        $attributeIds = $this->arrayFormatter->formatValueArray($products, 'id_attribute', true);
        $attributes = $this->productRepository->getProductAttributeValues($attributeIds, $langId);

        foreach ($products as &$product) {
            $product['attributes'] = isset($attributes[$product['id_attribute']]) ? $attributes[$product['id_attribute']] : '';
        }
    }

    /**
     * @param array $products
     *
     * @return void
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function addImages(array &$products)
    {
        $productIds = $this->arrayFormatter->formatValueArray($products, 'id_product', true);
        $attributeIds = $this->arrayFormatter->formatValueArray($products, 'id_attribute', true);

        $images = $this->productRepository->getProductImages($productIds);
        $attributeImages = $this->productRepository->getAttributeImages($attributeIds);

        foreach ($products as &$product) {
            $coverImageId = '0';

            $productImages = array_filter($images, function ($image) use ($product) {
                return $image['id_product'] === $product['id_product'];
            });

            foreach ($productImages as $productImage) {
                if ($productImage['cover'] == 1) {
                    $coverImageId = $productImage['id_image'];
                    break;
                }
            }

            // Product is without attributes -> get product images
            if ($product['id_attribute'] == 0) {
                $productImageIds = $this->arrayFormatter->formatValueArray($productImages, 'id_image');
            } else {
                $productAttributeImages = array_filter($attributeImages, function ($image) use ($product) {
                    return $image['id_product_attribute'] === $product['id_attribute'];
                });

                // If combination has some pictures -> the first one is the cover
                if (count($productAttributeImages)) {
                    $productImageIds = $this->arrayFormatter->formatValueArray($productAttributeImages, 'id_image');
                    $coverImageId = reset($productImageIds);
                }
                // Fallback on cover & images of the product when no pictures are chosen
                else {
                    $productImageIds = $this->arrayFormatter->formatValueArray($productImages, 'id_image');
                }
            }

            $productImageIds = array_diff($productImageIds, [$coverImageId]);

            if ($this->context->link === null) {
                throw new \PrestaShopException('No link context');
            }

            $link = $this->context->link;

            /*
            Ici pour certaines boutique on aurait un comporterment qui pourrait être adapté.
            et aller chercher dans une table des images le bon libellé pour appeler ce que le marchand a.
            */

            $product['images'] = $this->arrayFormatter->arrayToString(
                array_map(function ($imageId) use ($product, $link) {
                    return $link->getImageLink($product['link_rewrite'], (string) $imageId);
                }, $productImageIds)
            );

            $product['cover'] = $coverImageId == '0' ?
                '' :
                $link->getImageLink($product['link_rewrite'], (string) $coverImageId);
        }
    }
}
