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
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Support\StepSupport;

/**
 * @Features("dataProvider")
 * @Stories("data provider")
 */
class DataProviderTest extends BaseTestCase
{
    use StepSupport;

    /**
     * @Stories("data provider")
     * @Title("testDataProviders")
     */
    public function testDataProviders()
    {
        $this->executeStep('carrier provider', function () {
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(CarrierDataProvider::class);
            $this->handle($provider);
        });

        $this->executeStep('cart provider', function () {
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(CartDataProvider::class);
            $this->handle($provider);
        });

        $this->executeStep('category provider', function () {
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(CategoryDataProvider::class);
            $this->handle($provider);
        });

        $this->executeStep('modules provider', function () {
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(ModuleDataProvider::class);
            $this->handle($provider);
        });

        $this->executeStep('order provider', function () {
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(OrderDataProvider::class);
            $this->handle($provider);
        });

        $this->executeStep('product provider', function () {
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(ProductDataProvider::class);
            $this->handle($provider);
        });

        $this->executeStep('custom price provider', function () {
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(CustomPriceDataProvider::class);
            $this->handle($provider);
        });

        $this->executeStep('custom product carrier', function () {
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(CustomProductCarrierDataProvider::class);
            $this->handle($provider);
        });
    }

    private function handle(PaginatedApiDataProviderInterface $dataProvider)
    {
        $formattedData = $dataProvider->getFormattedData(0, 50, 'en');
        foreach ($formattedData as $data) {
            $this->assertArrayHasKey('collection', $data);
            $this->assertArrayHasKey('id', $data);
            $this->assertArrayHasKey('properties', $data);
        }
    }
}
