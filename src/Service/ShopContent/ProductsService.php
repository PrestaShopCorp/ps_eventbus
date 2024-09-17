<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Formatter\ArrayFormatter;
use PrestaShop\Module\PsEventbus\Repository\CategoryRepository;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\ProductRepository;

class ProductsService implements ShopContentServiceInterface
{
    /** @var ProductRepository */
    private $productRepository;

    /** @var CategoryRepository */
    private $categoryRepository;

    /** @var LanguageRepository */
    private $languageRepository;

    /** @var ArrayFormatter */
    private $arrayFormatter;

    /** @var \Context */
    private $context;

    /** @var int */
    private $shopId;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        LanguageRepository $languageRepository,
        ArrayFormatter $arrayFormatter
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->languageRepository = $languageRepository;
        $this->arrayFormatter = $arrayFormatter;

        $context = \Context::getContext();

        if ($context == null) {
            throw new \PrestaShopException('Context not found');
        }

        $this->context = $context;

        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $this->shopId = (int) $this->context->shop->id;
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
        $result = $this->productRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->decorateProducts($result, $langIso);
        $this->castProducts($result);

        return array_map(function ($item) {
            return [
                'id' => $item['unique_product_id'],
                'collection' => Config::COLLECTION_PRODUCTS,
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
        $result = $this->productRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->decorateProducts($result, $langIso);
        $this->castProducts($result);

        return array_map(function ($item) {
            return [
                'id' => $item['unique_product_id'],
                'collection' => Config::COLLECTION_PRODUCTS,
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
        return $this->productRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $products
     * @param string $langIso
     *
     * @return void
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function decorateProducts(&$products, $langIso)
    {
        $this->addFeatureValues($products, $langIso);
        $this->addAttributeValues($products, $langIso);
        $this->addImages($products);

        foreach ($products as &$product) {
            $this->addLanguageIsoCode($product, $langIso);
            $this->addUniqueId($product);
            $this->addAttributeId($product);
            $this->addLink($product);
            $this->addProductPrices($product);
            $this->formatDescriptions($product);
            $this->addCategoryTree($product);
        }
    }

    /**
     * @param array<mixed> $products
     *
     * @return void
     */
    private function castProducts(&$products)
    {
        foreach ($products as &$product) {
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
    }

    /**
     * @param array<mixed> $product
     *
     * @return void
     */
    private function addLink(&$product)
    {
        if ($this->context->link === null) {
            throw new \PrestaShopException('No link context');
        }

        try {
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
     * @param array<mixed> $product
     *
     * @return void
     */
    private function addProductPrices(&$product)
    {
        $product['price_tax_excl'] = (float) $product['price_tax_excl'];
        $product['price_tax_incl'] =
            (float) \Product::getPriceStatic($product['id_product'], true, $product['id_attribute'], 6, null, false, false);
        $product['sale_price_tax_excl'] =
            (float) \Product::getPriceStatic($product['id_product'], false, $product['id_attribute'], 6);
        $product['sale_price_tax_incl'] =
            (float) \Product::getPriceStatic($product['id_product'], true, $product['id_attribute'], 6);

        $product['tax'] = $product['price_tax_incl'] - $product['price_tax_excl'];
        $product['sale_tax'] = $product['sale_price_tax_incl'] - $product['sale_price_tax_excl'];
    }

    /**
     * @param array<mixed> $product
     *
     * @return void
     */
    private function formatDescriptions(&$product)
    {
        $product['description'] = base64_encode($product['description']);
        $product['description_short'] = base64_encode($product['description_short']);
    }

    /**
     * @param array<mixed> $product
     *
     * @return void
     */
    private function addCategoryTree(&$product)
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
     * @param array<mixed> $product
     *
     * @return void
     */
    private function addUniqueId(&$product)
    {
        $product['unique_product_id'] = "{$product['id_product']}-{$product['id_attribute']}-{$product['iso_code']}";
    }

    /**
     * @param array<mixed> $product
     *
     * @return void
     */
    private function addAttributeId(&$product)
    {
        $product['id_product_attribute'] = "{$product['id_product']}-{$product['id_attribute']}";
    }

    /**
     * @param array<mixed> $product
     * @param string $langiso
     *
     * @return void
     */
    private function addLanguageIsoCode(&$product, $langiso)
    {
        $product['iso_code'] = $langiso;
    }

    /**
     * @param array<mixed> $products
     * @param string $langIso
     *
     * @return void
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function addFeatureValues(&$products, $langIso)
    {
        $productIds = $this->arrayFormatter->formatValueArray($products, 'id_product', true);
        $features = $this->productRepository->getProductFeatures($productIds, $langIso);

        foreach ($products as &$product) {
            $product['features'] = isset($features[$product['id_product']]) ? $features[$product['id_product']] : '';
        }
    }

    /**
     * @param array<mixed> $products
     * @param string $langIso
     *
     * @return void
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function addAttributeValues(&$products, $langIso)
    {
        $attributeIds = $this->arrayFormatter->formatValueArray($products, 'id_attribute', true);
        $attributes = $this->productRepository->getProductAttributeValues($attributeIds, $langIso);

        foreach ($products as &$product) {
            $product['attributes'] = isset($attributes[$product['id_attribute']]) ? $attributes[$product['id_attribute']] : '';
        }
    }

    /**
     * @param array<mixed> $products
     *
     * @return void
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function addImages(&$products)
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
             * Ici pour certaines boutique on aurait un comportement qui pourrait être adapté.
             * et aller chercher dans la table des images le bon libellé pour appeler ce que le marchand possède.
             */
            $product['images'] = $this->arrayFormatter->arrayToString(
                array_map(function ($imageId) use ($product, $link) {
                    return $link->getImageLink($product['link_rewrite'], (string) $imageId);
                }, $productImageIds)
            );

            $product['cover'] = $coverImageId == '0' ? '' : $link->getImageLink($product['link_rewrite'], (string) $coverImageId);
        }
    }
}