<?php

namespace PrestaShop\Module\PsEventbus\Tests\System\Tests\Provider;

use PrestaShop\Module\PsEventbus\Provider\PaginatedApiDataProviderInterface;
use PrestaShop\Module\PsEventbus\Provider\ProductDataProvider;
use PrestaShop\Module\PsEventbus\Tests\System\Tests\BaseTestCase;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;

/**
 * @Features("dataProvider")
 * @Stories("product data provider")
 */
class ProductDataProviderTest extends BaseTestCase
{
    /**
     * @Stories("product data provider")
     * @Title("testDataProviders")
     *
     * @dataProvider getDataProviderInfo
     */
    public function testFormattedData(PaginatedApiDataProviderInterface $dataProvider)
    {
        $formattedData = $dataProvider->getFormattedData(0, 50, 'en');
        foreach ($formattedData as $data) {
            $this->assertArrayHasKey('id', $data);
            $this->assertArrayHasKey('collection', $data);
            $this->assertArrayHasKey('properties', $data);
            $properties = $data['properties'];
            if ($data['collection'] === 'products') {
                $this->checkProductCollectionProperties($properties);
            } elseif ($data['collection'] === 'bundle') {
                $this->checkBundleCollectionProperties($properties);
            }
        }
    }

    /**
     * @Stories("product data provider")
     * @Title("testDataProviders")
     *
     * @dataProvider getDataProviderInfo
     */
    public function testDataIncremental(PaginatedApiDataProviderInterface $dataProvider)
    {
        $formattedData = $dataProvider->getFormattedDataIncremental(50, 'en', [1]);
        foreach ($formattedData as $data) {
            $this->assertArrayHasKey('id', $data);
            $this->assertArrayHasKey('collection', $data);
            $this->assertArrayHasKey('properties', $data);
            $properties = $data['properties'];
            if ($data['collection'] === 'products') {
                $this->checkProductCollectionProperties($properties);
            } elseif ($data['collection'] === 'bundle') {
                $this->checkBundleCollectionProperties($properties);
            }
        }
    }

    public function getDataProviderInfo()
    {
        return [
            [
                'provider' => $this->container->getService(ProductDataProvider::class),
            ],
        ];
    }

    private function checkProductCollectionProperties(array $properties)
    {
        $this->assertArrayHasKey('id_product', $properties);
        $this->assertArrayHasKey('id_attribute', $properties);
        $this->assertArrayHasKey('is_default_attribute', $properties);
        $this->assertArrayHasKey('name', $properties);
        $this->assertArrayHasKey('description', $properties);
        $this->assertArrayHasKey('description_short', $properties);
        $this->assertArrayHasKey('link_rewrite', $properties);
        $this->assertArrayHasKey('default_category', $properties);
        $this->assertArrayHasKey('id_category_default', $properties);
        $this->assertArrayHasKey('reference', $properties);
        $this->assertArrayHasKey('upc', $properties);
        $this->assertArrayHasKey('ean', $properties);
        $this->assertArrayHasKey('condition', $properties);
        $this->assertArrayHasKey('visibility', $properties);
        $this->assertArrayHasKey('active', $properties);
        $this->assertArrayHasKey('quantity', $properties);
        $this->assertArrayHasKey('manufacturer', $properties);
        $this->assertArrayHasKey('weight', $properties);
        $this->assertArrayHasKey('price_tax_excl', $properties);
        $this->assertArrayHasKey('created_at', $properties);
        $this->assertArrayHasKey('updated_at', $properties);
        $this->assertArrayHasKey('width', $properties);
        $this->assertArrayHasKey('height', $properties);
        $this->assertArrayHasKey('depth', $properties);
        $this->assertArrayHasKey('additional_delivery_times', $properties);
        $this->assertArrayHasKey('additional_shipping_cost', $properties);
        $this->assertArrayHasKey('delivery_in_stock', $properties);
        $this->assertArrayHasKey('delivery_out_stock', $properties);
        $this->assertArrayHasKey('isbn', $properties);
        $this->assertArrayHasKey('features', $properties);
        $this->assertArrayHasKey('attributes', $properties);
        $this->assertArrayHasKey('images', $properties);
        $this->assertArrayHasKey('cover', $properties);
        $this->assertArrayHasKey('iso_code', $properties);
        $this->assertArrayHasKey('unique_product_id', $properties);
        $this->assertArrayHasKey('id_product_attribute', $properties);
        $this->assertArrayHasKey('link', $properties);
        $this->assertArrayHasKey('price_tax_incl', $properties);
        $this->assertArrayHasKey('sale_price_tax_excl', $properties);
        $this->assertArrayHasKey('sale_price_tax_incl', $properties);
        $this->assertArrayHasKey('tax', $properties);
        $this->assertArrayHasKey('sale_tax', $properties);
        $this->assertArrayHasKey('category_path', $properties);
        $this->assertArrayHasKey('category_id_path', $properties);
        $this->assertArrayHasKey('available_for_order', $properties);
        $this->assertArrayHasKey('available_date', $properties);
        $this->assertArrayHasKey('is_bundle', $properties);
        $this->assertArrayHasKey('is_virtual', $properties);
    }

    private function checkBundleCollectionProperties(array $properties)
    {
        $this->assertArrayHasKey('id_bundle', $properties);
        $this->assertArrayHasKey('id_product', $properties);
        $this->assertArrayHasKey('id_product_attribute', $properties);
        $this->assertArrayHasKey('unique_product_id', $properties);
        $this->assertArrayHasKey('quantity', $properties);
    }
}
