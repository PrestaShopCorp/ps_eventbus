<?php

namespace PrestaShop\Module\PsEventbus\Tests\System\Tests\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Provider\CustomPriceDataProvider;
use PrestaShop\Module\PsEventbus\Provider\PaginatedApiDataProviderInterface;
use PrestaShop\Module\PsEventbus\Tests\System\Tests\BaseTestCase;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;

/**
 * @Features("dataProvider")
 * @Stories("custom price data provider")
 */
class CustomPriceDataProviderTest extends BaseTestCase
{
    /**
     * @Stories("custom price data provider")
     * @Title("testDataProviders")
     *
     * @dataProvider getDataProviderInfo
     */
    public function testDataProviders(PaginatedApiDataProviderInterface $dataProvider, array $result)
    {
        $formattedData = $dataProvider->getFormattedData(0, 50, 'en');
        $this->assertEquals($result, $formattedData);
    }

    public function getDataProviderInfo()
    {
        return [
            'custom price provider' => [
                'provider' => $this->container->getService(CustomPriceDataProvider::class),
                'result' => [
                        0 => [
                                'id' => 1,
                                'collection' => Config::COLLECTION_SPECIFIC_PRICES,
                                'properties' => [
                                        'id_specific_price' => 1,
                                        'id_product' => 1,
                                        'id_shop' => 0,
                                        'id_shop_group' => 0,
                                        'id_currency' => 0,
                                        'id_country' => 0,
                                        'id_group' => 0,
                                        'id_customer' => 0,
                                        'id_product_attribute' => 0,
                                        'price' => -1,
                                        'from_quantity' => 1,
                                        'reduction' => 0.2,
                                        'reduction_tax' => 1,
                                        'reduction_type' => 'percentage',
                                        'country' => 'ALL',
                                        'currency' => 'ALL',
                                        'price_tax_included' => 23.9,
                                        'price_tax_excluded' => 23.9,
                                        'sale_price_tax_incl' => 19.12,
                                        'sale_price_tax_excl' => 19.12,
                                        'discount_percentage' => 20,
                                        'discount_value_tax_incl' => 0,
                                        'discount_value_tax_excl' => 0,
                                    ],
                            ],
                        1 => [
                                'id' => 2,
                                'collection' => Config::COLLECTION_SPECIFIC_PRICES,
                                'properties' => [
                                        'id_specific_price' => 2,
                                        'id_product' => 2,
                                        'id_shop' => 0,
                                        'id_shop_group' => 0,
                                        'id_currency' => 0,
                                        'id_country' => 0,
                                        'id_group' => 0,
                                        'id_customer' => 0,
                                        'id_product_attribute' => 0,
                                        'price' => -1,
                                        'from_quantity' => 1,
                                        'reduction' => 0.2,
                                        'reduction_tax' => 1,
                                        'reduction_type' => 'percentage',
                                        'country' => 'ALL',
                                        'currency' => 'ALL',
                                        'price_tax_included' => 35.9,
                                        'price_tax_excluded' => 35.9,
                                        'sale_price_tax_incl' => 28.72,
                                        'sale_price_tax_excl' => 28.72,
                                        'discount_percentage' => 20,
                                        'discount_value_tax_incl' => 0,
                                        'discount_value_tax_excl' => 0,
                                    ],
                            ],
                        2 => [
                                'id' => 3,
                                'collection' => Config::COLLECTION_SPECIFIC_PRICES,
                                'properties' => [
                                        'id_specific_price' => 3,
                                        'id_product' => 3,
                                        'id_shop' => 1,
                                        'id_shop_group' => 0,
                                        'id_currency' => 1,
                                        'id_country' => 8,
                                        'id_group' => 1,
                                        'id_customer' => 0,
                                        'id_product_attribute' => 13,
                                        'price' => -1,
                                        'from_quantity' => 2,
                                        'reduction' => 2.5,
                                        'reduction_tax' => 1,
                                        'from' => '2021-11-08 00:00:00',
                                        'to' => '2021-11-30 00:00:00',
                                        'reduction_type' => 'amount',
                                        'country' => 'FR',
                                        'currency' => 'USD',
                                        'price_tax_included' => 29,
                                        'price_tax_excluded' => 29,
                                        'sale_price_tax_incl' => 26.5,
                                        'sale_price_tax_excl' => 26.5,
                                        'discount_percentage' => 0,
                                        'discount_value_tax_incl' => 2.5,
                                        'discount_value_tax_excl' => 2.5,
                                    ],
                            ],
                    ],
            ],
        ];
    }
}
