<?php

use PrestaShop\Module\PsEventbus\Decorator\CustomPriceDecorator;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;
use PrestaShop\Module\PsEventbus\Service\SpecificPriceService;
use PrestaShop\Module\PsEventbus\Tests\System\Tests\BaseTestCase;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;

/**
 * @Features("decorator")
 * @Stories("specific price decorator")
 */
class SpecificPriceDecoratorTest extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @Stories("specific price decorator")
     * @Title("testDecorateSpecificPrice")
     *
     * @dataProvider getSpecificPrices
     */
    public function testDecorateSpecificPrice(array $specificPrices, array $result)
    {
        $contextMock = $this->createMock(Context::class);
        $linkMock = $this->createMock(Link::class);
        $shopMock = $this->createMock(Shop::class);
        $shopMock->id = 1;

        $contextMock->link = $linkMock;
        $contextMock->shop = $shopMock;

        $languageRepository = $this->createMock(LanguageRepository::class);
        $languageRepository->method('getLanguageIdByIsoCode')->willReturn(1);

        $specificPriceService = $this->createMock(SpecificPriceService::class);
        $specificPriceService->method('getSpecificProductPrice')->willReturn(0);

        $productDecorator = new CustomPriceDecorator($contextMock, $specificPriceService);
        $productDecorator->decorateSpecificPrices($specificPrices);

        $this->assertEquals($result, $specificPrices);
    }

    public function getSpecificPrices()
    {
        return [
            'one country - 20%' => [
                'specificPrices' => [
                        [
                            'id_specific_price' => '1',
                            'id_product' => '1',
                            'id_shop' => '0',
                            'id_currency' => '0',
                            'id_country' => '8',
                            'id_group' => '0',
                            'id_shop_group' => '0',
                            'id_customer' => '0',
                            'id_product_attribute' => '0',
                            'price' => '-1.000000',
                            'from_quantity' => '1',
                            'reduction' => '0.200000',
                            'reduction_tax' => '1',
                            'from' => '0000-00-00 00:00:00',
                            'to' => '0000-00-00 00:00:00',
                            'country' => 'FR',
                            'currency' => 'EUR',
                            'reduction_type' => 'percentage',
                        ],
                    ],
                'result' => [
                    [
                        'id_specific_price' => 1,
                        'id_product' => 1,
                        'id_shop' => 0,
                        'id_group' => 0,
                        'id_shop_group' => 0,
                        'id_product_attribute' => 0,
                        'price' => -1.000000,
                        'from_quantity' => 1,
                        'reduction' => 0.200000,
                        'reduction_tax' => 1,
                        'country' => 'FR',
                        'currency' => 'EUR',
                        'price_tax_included' => 0.0,
                        'price_tax_excluded' => 0.0,
                        'sale_price_tax_incl' => 0.0,
                        'sale_price_tax_excl' => 0.0,
                        'id_currency' => 0,
                        'id_country' => 8,
                        'id_customer' => 0,
                        'reduction_type' => 'percentage',
                        'discount_percentage' => 20.0,
                        'discount_value_tax_incl' => 0.0,
                        'discount_value_tax_excl' => 0.0,
                    ],
                ],
            ],
            'one country - 4e discount' => [
                'specificPrice' => [
                    [
                        'id_specific_price' => '5',
                        'id_product' => '1',
                        'id_shop' => '1',
                        'id_currency' => '0',
                        'id_country' => '131',
                        'id_group' => '0',
                        'id_shop_group' => '0',
                        'id_customer' => '0',
                        'id_product_attribute' => '0',
                        'price' => '-1.000000',
                        'from_quantity' => '1',
                        'reduction' => '4.000000',
                        'reduction_tax' => '0',
                        'from' => '2021-05-00 00:00:00',
                        'to' => '2021-10-00 00:00:00',
                        'country' => null,
                        'currency' => null,
                        'reduction_type' => 'amount',
                    ],
                ],
                'result' => [
                    [
                        'id_shop' => 1,
                        'id_product' => 1,
                        'id_group' => 0,
                        'id_shop_group' => 0,
                        'id_product_attribute' => 0,
                        'id_currency' => 0,
                        'currency' => 'ALL',
                        'id_country' => 131,
                        'country' => 'ALL',
                        'from' => '2021-05-00 00:00:00',
                        'to' => '2021-10-00 00:00:00',
                        'from_quantity' => 1,
                        'price_tax_included' => 0.0,
                        'price_tax_excluded' => 0.0,
                        'sale_price_tax_incl' => 0.0,
                        'sale_price_tax_excl' => 0.0,
                        'price' => -1.000000,
                        'reduction' => 4.000000,
                        'reduction_tax' => 0,
                        'id_customer' => 0,
                        'id_specific_price' => 5,
                        'reduction_type' => 'amount',
                        'discount_percentage' => 0,
                        'discount_value_tax_incl' => 0.0,
                        'discount_value_tax_excl' => 0.0,
                    ],
                ],
            ],
        ];
    }
}
