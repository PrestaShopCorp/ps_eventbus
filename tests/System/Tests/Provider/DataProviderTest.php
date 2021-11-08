<?php

namespace PrestaShop\Module\PsEventbus\Tests\system\Tests\Provider;

use PrestaShop\Module\PsEventbus\Provider\CarrierDataProvider;
use PrestaShop\Module\PsEventbus\Provider\PaginatedApiDataProviderInterface;
use PrestaShop\Module\PsEventbus\Tests\system\Tests\BaseTestCase;

class DataProviderTest extends BaseTestCase
{
    /**
     * @dataProvider getDataProviderInfo
     */
    public function testDataProviders(PaginatedApiDataProviderInterface $dataProvider, $response)
    {
        $formattedData = $dataProvider->getFormattedData(0, 50, 'en');
        $this->assertEquals($response, $formattedData);
    }

    public function getDataProviderInfo()
    {
        return [
            'carrier provider' => [
                'provider' => $this->container->getService(CarrierDataProvider::class),
                'expected response' =>
                    [
                        [
                            'collection' => 'carriers',
                            'id' => '1',
                            'properties' =>
                                [
                                    'id_carrier' => '1',
                                    'id_reference' => '1',
                                    'name' => 'eventBus',
                                    'carrier_taxes_rates_group_id' => '1',
                                    'url' => '',
                                    'active' => true,
                                    'deleted' => false,
                                    'shipping_handling' => 0,
                                    'free_shipping_starts_at_price' => 100,
                                    'free_shipping_starts_at_weight' => 10,
                                    'disable_carrier_when_out_of_range' => false,
                                    'is_module' => false,
                                    'is_free' => true,
                                    'shipping_external' => false,
                                    'need_range' => false,
                                    'external_module_name' => '',
                                    'max_width' => 0,
                                    'max_height' => 0,
                                    'max_depth' => 0,
                                    'max_weight' => 0,
                                    'grade' => 0,
                                    'delay' => 'Pick up in-store',
                                    'currency' => 'EUR',
                                    'weight_unit' => 'kg',
                                ],
                        ],
                        [
                            'collection' => 'carriers',
                            'id' => '2',
                            'properties' =>
                                [
                                    'id_carrier' => '15',
                                    'id_reference' => '2',
                                    'name' => 'My carrier',
                                    'carrier_taxes_rates_group_id' => '1',
                                    'url' => '',
                                    'active' => true,
                                    'deleted' => false,
                                    'shipping_handling' => 2,
                                    'free_shipping_starts_at_price' => 100,
                                    'free_shipping_starts_at_weight' => 10,
                                    'disable_carrier_when_out_of_range' => false,
                                    'is_module' => false,
                                    'is_free' => false,
                                    'shipping_external' => false,
                                    'need_range' => false,
                                    'external_module_name' => '',
                                    'max_width' => 0,
                                    'max_height' => 0,
                                    'max_depth' => 0,
                                    'max_weight' => 0,
                                    'grade' => 0,
                                    'delay' => 'Delivery next day!',
                                    'currency' => 'EUR',
                                    'weight_unit' => 'kg',
                                ],
                        ],
                        [
                            'collection' => 'carrier_details',
                            'id' => '2-1-0-2',
                            'properties' =>
                                [
                                    'id_reference' => '2',
                                    'id_carrier_detail' => '2',
                                    'shipping_method' => 'range_weight',
                                    'delimiter1' => 0,
                                    'delimiter2' => 10000,
                                    'country_ids' => 'FR,LT',
                                    'state_ids' => '',
                                    'price' => 5,
                                ],
                        ],
                        [
                            'collection' => 'carrier_taxes',
                            'id' => '2-1',
                            'properties' =>
                                [
                                    'id_reference' => '2',
                                    'id_carrier_tax' => '1',
                                    'country_id' => 'FR',
                                    'state_ids' => '',
                                    'tax_rate' => 21,
                                ],
                        ],
                        [
                            'collection' => 'carriers',
                            'id' => '3',
                            'properties' =>
                                [
                                    'id_carrier' => '21',
                                    'id_reference' => '3',
                                    'name' => 'test2',
                                    'carrier_taxes_rates_group_id' => '0',
                                    'url' => '',
                                    'active' => true,
                                    'deleted' => false,
                                    'shipping_handling' => 2,
                                    'free_shipping_starts_at_price' => 100,
                                    'free_shipping_starts_at_weight' => 10,
                                    'disable_carrier_when_out_of_range' => false,
                                    'is_module' => false,
                                    'is_free' => false,
                                    'shipping_external' => false,
                                    'need_range' => false,
                                    'external_module_name' => '',
                                    'max_width' => 0,
                                    'max_height' => 0,
                                    'max_depth' => 0,
                                    'max_weight' => 0,
                                    'grade' => 0,
                                    'delay' => 'test2',
                                    'currency' => 'EUR',
                                    'weight_unit' => 'kg',
                                ],
                        ],
                    ]
            ]
        ];
    }
}
