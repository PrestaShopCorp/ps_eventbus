<?php

namespace PrestaShop\Module\PsEventbus\Tests\System\Tests\Provider;

use PrestaShop\Module\PsEventbus\Provider\CarrierDataProvider;
use PrestaShop\Module\PsEventbus\Provider\CartDataProvider;
use PrestaShop\Module\PsEventbus\Provider\CategoryDataProvider;
use PrestaShop\Module\PsEventbus\Provider\CustomPriceDataProvider;
use PrestaShop\Module\PsEventbus\Provider\CustomProductCarrierDataProvider;
use PrestaShop\Module\PsEventbus\Provider\ModuleDataProvider;
use PrestaShop\Module\PsEventbus\Provider\OrderDataProvider;
use PrestaShop\Module\PsEventbus\Provider\PaginatedApiDataProviderInterface;
use PrestaShop\Module\PsEventbus\Provider\ProductDataProvider;
use PrestaShop\Module\PsEventbus\Tests\System\Tests\BaseTestCase;
use Yandex\Allure\Adapter\Annotation\Title;

/**
 * @Title("DataProviderTest")
 */
class DataProviderTest extends BaseTestCase
{
    /**
     * @Title("testDataProviders")
     *
     * @dataProvider getDataProviderInfo
     */
    public function testDataProviders(PaginatedApiDataProviderInterface $dataProvider)
    {
        $formattedData = $dataProvider->getFormattedData(0, 50, 'en');
        foreach ($formattedData as $data) {
            $this->assertArrayHasKey('collection', $data);
            $this->assertArrayHasKey('id', $data);
            $this->assertArrayHasKey('properties', $data);
        }
    }

    public function getDataProviderInfo()
    {
        return [
            'carrier provider' => [
                'provider' => $this->container->getService(CarrierDataProvider::class),
                ],
            'cart provider' => [
                'provider' => $this->container->getService(CartDataProvider::class),
                ],
            'category provider' => [
                'provider' => $this->container->getService(CategoryDataProvider::class),
                ],
            'modules provider' => [
                'provider' => $this->container->getService(ModuleDataProvider::class),
                ],
            'order provider' => [
                'provider' => $this->container->getService(OrderDataProvider::class),
                ],
            'product provider' => [
                'provider' => $this->container->getService(ProductDataProvider::class),
                ],
            'custom price provider' => [
                'provider' => $this->container->getService(CustomPriceDataProvider::class),
                ],
            'custom product carrier' => [
                'provider' => $this->container->getService(CustomProductCarrierDataProvider::class),
                ],
        ];
    }
}
