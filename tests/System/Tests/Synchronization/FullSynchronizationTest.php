<?php

namespace PrestaShop\Module\PsEventbus\Tests\System\Tests\Synchronization;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Provider\CarrierDataProvider;
use PrestaShop\Module\PsEventbus\Provider\CartDataProvider;
use PrestaShop\Module\PsEventbus\Provider\CategoryDataProvider;
use PrestaShop\Module\PsEventbus\Provider\CustomPriceDataProvider;
use PrestaShop\Module\PsEventbus\Provider\CustomProductCarrierDataProvider;
use PrestaShop\Module\PsEventbus\Provider\ModuleDataProvider;
use PrestaShop\Module\PsEventbus\Provider\OrderDataProvider;
use PrestaShop\Module\PsEventbus\Provider\PaginatedApiDataProviderInterface;
use PrestaShop\Module\PsEventbus\Provider\ProductDataProvider;
use PrestaShop\Module\PsEventbus\Service\SynchronizationService;
use PrestaShop\Module\PsEventbus\Tests\System\Tests\BaseTestCase;
use Product;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Support\StepSupport;

/**
 * @Features("synchronization")
 * @Stories("full synchronization")
 */
class FullSynchronizationTest extends BaseTestCase
{
    use StepSupport;

    public function setUp()
    {
        parent::setUp();
        $product = new Product(1);
        $product->setCarriers([1, 2]);
    }

    /**
     * @Stories("full synchronization")
     * @Title("testFullSync")
     */
    public function testFullSync()
    {
        $this->executeStep('apiCarriers', function () {
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(CarrierDataProvider::class);
            $this->handle($provider, Config::COLLECTION_CARRIERS);
        });

        $this->executeStep('apiCarts', function () {
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(CartDataProvider::class);
            $this->handle($provider, Config::COLLECTION_CARTS);
        });

        $this->executeStep('apiCategories', function () {
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(CategoryDataProvider::class);
            $this->handle($provider, Config::COLLECTION_CATEGORIES);
        });

        $this->executeStep('apiModules', function () {
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(ModuleDataProvider::class);
            $this->handle($provider, Config::COLLECTION_MODULES);
        });

        $this->executeStep('apiOrders', function () {
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(OrderDataProvider::class);
            $this->handle($provider, Config::COLLECTION_ORDERS);
        });

        $this->executeStep('apiProducts', function () {
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(ProductDataProvider::class);
            $this->handle($provider, Config::COLLECTION_PRODUCTS);
        });

        $this->executeStep('apiSpecificPrices', function () {
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(CustomPriceDataProvider::class);
            $this->handle($provider, Config::COLLECTION_PRODUCTS);
        });

        $this->executeStep('apiCustomProductCarriers', function () {
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(CustomProductCarrierDataProvider::class);
            $this->handle($provider, Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS);
        });
    }

    private function handle(PaginatedApiDataProviderInterface $dataProvider, $type)
    {
        /** @var SynchronizationService $syncService */
        $syncService = $this->container->getService(SynchronizationService::class);
        $response = $syncService->handleFullSync(
            $dataProvider,
            $type,
            'test',
            'en',
            0,
            200,
            '2021-10-10T10:10:10',
            '2021-11-11T11:11:11'
        );

        $this->assertEquals(201, $response['httpCode']);
    }
}
