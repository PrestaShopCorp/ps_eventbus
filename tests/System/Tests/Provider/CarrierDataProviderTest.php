<?php

namespace PrestaShop\Module\PsEventbus\Tests\System\Tests\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Provider\CarrierDataProvider;
use PrestaShop\Module\PsEventbus\Provider\PaginatedApiDataProviderInterface;
use PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository;
use PrestaShop\Module\PsEventbus\Tests\System\Tests\BaseTestCase;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;

/**
 * @Features("dataProvider")
 * @Stories("carrier data provider")
 */
class CarrierDataProviderTest extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();
        /** @var IncrementalSyncRepository $syncRepository */
        $syncRepository = $this->container->getService(IncrementalSyncRepository::class);
        $syncRepository->insertIncrementalObject(1, Config::COLLECTION_CARRIERS, '2021-01-01 08:45:30', 1, 1);
        $syncRepository->insertIncrementalObject(2, Config::COLLECTION_CARRIERS, '2021-01-02 08:45:30', 1, 2);
        $syncRepository->insertIncrementalObject(3, Config::COLLECTION_CARRIERS, '2021-01-03 08:45:30', 2, 1);
    }

    /**
     * @Stories("carrier data provider")
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
                'provider' => $this->container->getService(CarrierDataProvider::class),
                'result' => [
                    0 => [
                        'collection' => 'carriers',
                        'id' => '1',
                        'properties' => [
                            'id_carrier' => '1',
                            'id_reference' => '1',
                            'name' => '',
                            'carrier_taxes_rates_group_id' => '1',
                            'url' => '',
                            'active' => true,
                            'deleted' => false,
                            'shipping_handling' => 0,
                            'free_shipping_starts_at_price' => 0,
                            'free_shipping_starts_at_weight' => 0,
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
                            'currency' => 'USD',
                            'weight_unit' => 'kg',
                            'updated_at' => '2021-01-01 08:45:30',
                        ],
                    ],
                    1 => [
                        'collection' => 'carriers',
                        'id' => '2',
                        'properties' => [
                            'id_carrier' => '2',
                            'id_reference' => '2',
                            'name' => 'My carrier',
                            'carrier_taxes_rates_group_id' => '9',
                            'url' => '',
                            'active' => true,
                            'deleted' => false,
                            'shipping_handling' => 2,
                            'free_shipping_starts_at_price' => 0,
                            'free_shipping_starts_at_weight' => 0,
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
                            'currency' => 'USD',
                            'weight_unit' => 'kg',
                            'updated_at' => date('Y-m-d 00:00:00'),
                        ],
                    ],
                    2 => [
                        'collection' => 'carrier_details',
                        'id' => '2-2-range_weight-1',
                        'properties' => [
                            'id_reference' => '2',
                            'id_carrier_detail' => '1',
                            'shipping_method' => 'range_weight',
                            'delimiter1' => 0,
                            'delimiter2' => 10000,
                            'country_ids' => 'US',
                            'state_ids' => 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC',
                            'price' => 5,
                            'id_zone' => '2',
                            'id_range' => '1',
                        ],
                    ],
                    3 => [
                        'collection' => 'carrier_taxes',
                        'id' => '2-2-1',
                        'properties' => [
                            'id_reference' => '2',
                            'id_carrier_tax' => '9',
                            'country_id' => 'US',
                            'state_ids' => 'FL',
                            'tax_rate' => 6,
                            'id_zone' => '2',
                            'id_range' => '1',
                        ],
                    ],
                    4 => [
                        'collection' => 'carriers',
                        'id' => '3',
                        'properties' => [
                            'id_carrier' => '3',
                            'id_reference' => '3',
                            'name' => 'My cheap carrier',
                            'carrier_taxes_rates_group_id' => '9',
                            'url' => '',
                            'active' => false,
                            'deleted' => false,
                            'shipping_handling' => 2,
                            'free_shipping_starts_at_price' => 0,
                            'free_shipping_starts_at_weight' => 0,
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
                            'delay' => 'Buy more to pay less!',
                            'currency' => 'USD',
                            'weight_unit' => 'kg',
                            'updated_at' => date('Y-m-d 00:00:00'),
                        ],
                    ],
                    5 => [
                        'collection' => 'carrier_details',
                        'id' => '3-2-range_price-2',
                        'properties' => [
                            'id_reference' => '3',
                            'id_carrier_detail' => '2',
                            'shipping_method' => 'range_price',
                            'delimiter1' => 0,
                            'delimiter2' => 50,
                            'country_ids' => 'US',
                            'state_ids' => 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC',
                            'price' => 4,
                            'id_zone' => '2',
                            'id_range' => '2',
                        ],
                    ],
                    6 => [
                        'collection' => 'carrier_details',
                        'id' => '3-2-range_price-3',
                        'properties' => [
                            'id_reference' => '3',
                            'id_carrier_detail' => '3',
                            'shipping_method' => 'range_price',
                            'delimiter1' => 50,
                            'delimiter2' => 100,
                            'country_ids' => 'US',
                            'state_ids' => 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC',
                            'price' => 2,
                            'id_zone' => '2',
                            'id_range' => '3',
                        ],
                    ],
                    7 => [
                        'collection' => 'carrier_details',
                        'id' => '3-2-range_price-4',
                        'properties' => [
                            'id_reference' => '3',
                            'id_carrier_detail' => '4',
                            'shipping_method' => 'range_price',
                            'delimiter1' => 100,
                            'delimiter2' => 200,
                            'country_ids' => 'US',
                            'state_ids' => 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC',
                            'price' => 0,
                            'id_zone' => '2',
                            'id_range' => '4',
                        ],
                    ],
                    8 => [
                        'collection' => 'carrier_taxes',
                        'id' => '3-2-2',
                        'properties' => [
                            'id_reference' => '3',
                            'id_carrier_tax' => '9',
                            'country_id' => 'US',
                            'state_ids' => 'FL',
                            'tax_rate' => 6,
                            'id_zone' => '2',
                            'id_range' => '2',
                        ],
                    ],
                    9 => [
                        'collection' => 'carrier_taxes',
                        'id' => '3-2-3',
                        'properties' => [
                            'id_reference' => '3',
                            'id_carrier_tax' => '9',
                            'country_id' => 'US',
                            'state_ids' => 'FL',
                            'tax_rate' => 6,
                            'id_zone' => '2',
                            'id_range' => '3',
                        ],
                    ],
                    10 => [
                        'collection' => 'carrier_taxes',
                        'id' => '3-2-4',
                        'properties' => [
                            'id_reference' => '3',
                            'id_carrier_tax' => '9',
                            'country_id' => 'US',
                            'state_ids' => 'FL',
                            'tax_rate' => 6,
                            'id_zone' => '2',
                            'id_range' => '4',
                        ],
                    ],
                    11 => [
                        'collection' => 'carriers',
                        'id' => '4',
                        'properties' => [
                            'id_carrier' => '4',
                            'id_reference' => '4',
                            'name' => 'My light carrier',
                            'carrier_taxes_rates_group_id' => '9',
                            'url' => '',
                            'active' => false,
                            'deleted' => false,
                            'shipping_handling' => 2,
                            'free_shipping_starts_at_price' => 0,
                            'free_shipping_starts_at_weight' => 0,
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
                            'delay' => 'The lighter the cheaper!',
                            'currency' => 'USD',
                            'weight_unit' => 'kg',
                            'updated_at' => date('Y-m-d 00:00:00'),
                        ],
                    ],
                    12 => [
                        'collection' => 'carrier_details',
                        'id' => '4-2-range_weight-2',
                        'properties' => [
                            'id_reference' => '4',
                            'id_carrier_detail' => '2',
                            'shipping_method' => 'range_weight',
                            'delimiter1' => 0,
                            'delimiter2' => 1,
                            'country_ids' => 'US',
                            'state_ids' => 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC',
                            'price' => 0,
                            'id_zone' => '2',
                            'id_range' => '2',
                        ],
                    ],
                    13 => [
                        'collection' => 'carrier_details',
                        'id' => '4-2-range_weight-3',
                        'properties' => [
                            'id_reference' => '4',
                            'id_carrier_detail' => '3',
                            'shipping_method' => 'range_weight',
                            'delimiter1' => 1,
                            'delimiter2' => 3,
                            'country_ids' => 'US',
                            'state_ids' => 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC',
                            'price' => 3,
                            'id_zone' => '2',
                            'id_range' => '3',
                        ],
                    ],
                    14 => [
                        'collection' => 'carrier_details',
                        'id' => '4-2-range_weight-4',
                        'properties' => [
                            'id_reference' => '4',
                            'id_carrier_detail' => '4',
                            'shipping_method' => 'range_weight',
                            'delimiter1' => 3,
                            'delimiter2' => 10000,
                            'country_ids' => 'US',
                            'state_ids' => 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC',
                            'price' => 6,
                            'id_zone' => '2',
                            'id_range' => '4',
                        ],
                    ],
                    15 => [
                        'collection' => 'carrier_taxes',
                        'id' => '4-2-2',
                        'properties' => [
                            'id_reference' => '4',
                            'id_carrier_tax' => '9',
                            'country_id' => 'US',
                            'state_ids' => 'FL',
                            'tax_rate' => 6,
                            'id_zone' => '2',
                            'id_range' => '2',
                        ],
                    ],
                    16 => [
                        'collection' => 'carrier_taxes',
                        'id' => '4-2-3',
                        'properties' => [
                            'id_reference' => '4',
                            'id_carrier_tax' => '9',
                            'country_id' => 'US',
                            'state_ids' => 'FL',
                            'tax_rate' => 6,
                            'id_zone' => '2',
                            'id_range' => '3',
                        ],
                    ],
                    17 => [
                        'collection' => 'carrier_taxes',
                        'id' => '4-2-4',
                        'properties' => [
                            'id_reference' => '4',
                            'id_carrier_tax' => '9',
                            'country_id' => 'US',
                            'state_ids' => 'FL',
                            'tax_rate' => 6,
                            'id_zone' => '2',
                            'id_range' => '4',
                        ],
                    ],
                ],
            ],
        ];
    }
}
