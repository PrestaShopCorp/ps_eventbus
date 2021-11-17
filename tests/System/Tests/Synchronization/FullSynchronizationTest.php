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
use Yandex\Allure\Adapter\Annotation\Title;

/**
 * @Title("FullSynchronizationTest")
 */
class FullSynchronizationTest extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();
        $product = new Product(1);
        $product->setCarriers([1, 2]);
    }

    /**
     * @Title("testFullSync")
     *
     * @dataProvider fullSyncDataProvider
     */
    public function testFullSync(
        PaginatedApiDataProviderInterface $dataProvider,
        $type
    ) {
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

    public function fullSyncDataProvider()
    {
        return [
            'apiCarrier' => [
                'dataProvider' => $this->container->getService(CarrierDataProvider::class),
                'type' => Config::COLLECTION_CARRIER,
            ],
            'apiCarts' => [
                'dataProvider' => $this->container->getService(CartDataProvider::class),
                'type' => Config::COLLECTION_CARTS,
            ],
            'apiCategories' => [
                'dataProvider' => $this->container->getService(CategoryDataProvider::class),
                'type' => Config::COLLECTION_CATEGORIES,
            ],
            'apiModules' => [
                'dataProvider' => $this->container->getService(ModuleDataProvider::class),
                'type' => Config::COLLECTION_MODULES,
            ],
            'apiOrders' => [
                'dataProvider' => $this->container->getService(OrderDataProvider::class),
                'type' => Config::COLLECTION_ORDERS,
            ],
            'apiProducts' => [
                'dataProvider' => $this->container->getService(ProductDataProvider::class),
                'type' => Config::COLLECTION_PRODUCTS,
            ],
            'apiCustomPrices' => [
                'dataProvider' => $this->container->getService(CustomPriceDataProvider::class),
                'type' => Config::COLLECTION_PRODUCTS,
            ],
            'apiCustomProductCarrier' => [
                'dataProvider' => $this->container->getService(CustomProductCarrierDataProvider::class),
                'type' => Config::COLLECTION_CUSTOM_PRODUCT_CARRIER,
            ],
        ];
    }
}
