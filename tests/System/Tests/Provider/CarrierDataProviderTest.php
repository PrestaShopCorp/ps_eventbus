<?php

namespace PrestaShop\Module\PsEventbus\Tests\System\Tests\Provider;

use PrestaShop\Module\PsEventbus\Provider\CarrierDataProvider;
use PrestaShop\Module\PsEventbus\Provider\PaginatedApiDataProviderInterface;
use PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository;
use PrestaShop\Module\PsEventbus\Tests\System\Tests\BaseTestCase;

class CarrierDataProviderTest extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();
        /** @var IncrementalSyncRepository $syncRepository */
        $syncRepository = $this->container->getService(IncrementalSyncRepository::class);
        $syncRepository->insertIncrementalObject(1, 'carrier', '2021-01-01 08:45:30', 1, 1);
        $syncRepository->insertIncrementalObject(2, 'carrier', '2021-01-02 08:45:30', 1, 2);
        $syncRepository->insertIncrementalObject(3, 'carrier', '2021-01-03 08:45:30', 2, 1);
    }

    /**
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
                                    'name' => '177',
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
                            'id' => '2-2-0-1',
                            'properties' => [
                                    'id_reference' => '2',
                                    'id_carrier_detail' => '1',
                                    'shipping_method' => 'range_weight',
                                    'delimiter1' => 0,
                                    'delimiter2' => 10000,
                                    'country_ids' => 'US',
                                    'state_ids' => 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC',
                                    'price' => 5,
                                ],
                        ],
                    3 => [
                            'collection' => 'carrier_taxes',
                            'id' => '2-2',
                            'properties' => [
                                    'id_reference' => '2',
                                    'id_carrier_tax' => '9',
                                    'country_id' => 'US',
                                    'state_ids' => 'FL',
                                    'tax_rate' => 6,
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
                            'id' => '3-2-1-2',
                            'properties' => [
                                    'id_reference' => '3',
                                    'id_carrier_detail' => '2',
                                    'shipping_method' => 'range_price',
                                    'delimiter1' => 0,
                                    'delimiter2' => 50,
                                    'country_ids' => 'US',
                                    'state_ids' => 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC',
                                    'price' => 4,
                                ],
                        ],
                    6 => [
                            'collection' => 'carrier_details',
                            'id' => '3-2-1-3',
                            'properties' => [
                                    'id_reference' => '3',
                                    'id_carrier_detail' => '3',
                                    'shipping_method' => 'range_price',
                                    'delimiter1' => 50,
                                    'delimiter2' => 100,
                                    'country_ids' => 'US',
                                    'state_ids' => 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC',
                                    'price' => 2,
                                ],
                        ],
                    7 => [
                            'collection' => 'carrier_details',
                            'id' => '3-2-1-4',
                            'properties' => [
                                    'id_reference' => '3',
                                    'id_carrier_detail' => '4',
                                    'shipping_method' => 'range_price',
                                    'delimiter1' => 100,
                                    'delimiter2' => 200,
                                    'country_ids' => 'US',
                                    'state_ids' => 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC',
                                    'price' => 0,
                                ],
                        ],
                    8 => [
                            'collection' => 'carrier_taxes',
                            'id' => '3-2',
                            'properties' => [
                                    'id_reference' => '3',
                                    'id_carrier_tax' => '9',
                                    'country_id' => 'US',
                                    'state_ids' => 'FL',
                                    'tax_rate' => 6,
                                ],
                        ],
                    9 => [
                            'collection' => 'carrier_taxes',
                            'id' => '3-2',
                            'properties' => [
                                    'id_reference' => '3',
                                    'id_carrier_tax' => '9',
                                    'country_id' => 'US',
                                    'state_ids' => 'FL',
                                    'tax_rate' => 6,
                                ],
                        ],
                    10 => [
                            'collection' => 'carrier_taxes',
                            'id' => '3-2',
                            'properties' => [
                                    'id_reference' => '3',
                                    'id_carrier_tax' => '9',
                                    'country_id' => 'US',
                                    'state_ids' => 'FL',
                                    'tax_rate' => 6,
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
                            'id' => '4-2-0-2',
                            'properties' => [
                                    'id_reference' => '4',
                                    'id_carrier_detail' => '2',
                                    'shipping_method' => 'range_weight',
                                    'delimiter1' => 0,
                                    'delimiter2' => 1,
                                    'country_ids' => 'US',
                                    'state_ids' => 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC',
                                    'price' => 0,
                                ],
                        ],
                    13 => [
                            'collection' => 'carrier_details',
                            'id' => '4-2-0-3',
                            'properties' => [
                                    'id_reference' => '4',
                                    'id_carrier_detail' => '3',
                                    'shipping_method' => 'range_weight',
                                    'delimiter1' => 1,
                                    'delimiter2' => 3,
                                    'country_ids' => 'US',
                                    'state_ids' => 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC',
                                    'price' => 3,
                                ],
                        ],
                    14 => [
                            'collection' => 'carrier_details',
                            'id' => '4-2-0-4',
                            'properties' => [
                                    'id_reference' => '4',
                                    'id_carrier_detail' => '4',
                                    'shipping_method' => 'range_weight',
                                    'delimiter1' => 3,
                                    'delimiter2' => 10000,
                                    'country_ids' => 'US',
                                    'state_ids' => 'AA,AE,AP,AL,AK,AZ,AR,CA,CO,CT,DE,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY,PR,VI,DC',
                                    'price' => 6,
                                ],
                        ],
                    15 => [
                            'collection' => 'carrier_taxes',
                            'id' => '4-2',
                            'properties' => [
                                    'id_reference' => '4',
                                    'id_carrier_tax' => '9',
                                    'country_id' => 'US',
                                    'state_ids' => 'FL',
                                    'tax_rate' => 6,
                                ],
                        ],
                    16 => [
                            'collection' => 'carrier_taxes',
                            'id' => '4-2',
                            'properties' => [
                                    'id_reference' => '4',
                                    'id_carrier_tax' => '9',
                                    'country_id' => 'US',
                                    'state_ids' => 'FL',
                                    'tax_rate' => 6,
                                ],
                        ],
                    17 => [
                            'collection' => 'carrier_taxes',
                            'id' => '4-2',
                            'properties' => [
                                    'id_reference' => '4',
                                    'id_carrier_tax' => '9',
                                    'country_id' => 'US',
                                    'state_ids' => 'FL',
                                    'tax_rate' => 6,
                                ],
                        ],
                ],
            ],
        ];
    }
}
