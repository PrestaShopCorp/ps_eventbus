<?php

namespace  PrestaShop\Module\PsEventbus\Tests\system\Tests\Synchronization;

use PrestaShop\Module\PsEventbus\Provider\CarrierDataProvider;
use PrestaShop\Module\PsEventbus\Provider\CartDataProvider;
use PrestaShop\Module\PsEventbus\Provider\CategoryDataProvider;
use PrestaShop\Module\PsEventbus\Provider\ModuleDataProvider;
use PrestaShop\Module\PsEventbus\Provider\OrderDataProvider;
use PrestaShop\Module\PsEventbus\Provider\PaginatedApiDataProviderInterface;
use PrestaShop\Module\PsEventbus\Provider\ProductDataProvider;
use PrestaShop\Module\PsEventbus\Service\SynchronizationService;
use PrestaShop\Module\PsEventbus\Tests\system\Tests\BaseTestCase;

class FullSynchronizationTest extends BaseTestCase
{
    /**
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
            50,
            '2021-10-10T10:10:10',
            '2021-11-11T11:11:11'
        );

        $this->assertEquals('201', $response['httpCode']);
    }

    public function fullSyncDataProvider()
    {
        return [
            'apiCarrier' => [
                'dataProvider' => $this->container->getService(CarrierDataProvider::class),
                'type' => 'carrier',
            ],
            'apiCarts' => [
                'dataProvider' => $this->container->getService(CartDataProvider::class),
                'type' => 'carts',
            ],
            'apiCategories' => [
                'dataProvider' => $this->container->getService(CategoryDataProvider::class),
                'type' => 'categories',
            ],
            // todo: for now it doesnt have any category matches
//            'apiGoogleTaxonomies' => [
//                'dataProvider' => $this->container->getService(GoogleTaxonomyDataProvider::class),
//                'type' => 'carrier'
//            ],
            'apiModules' => [
                'dataProvider' => $this->container->getService(ModuleDataProvider::class),
                'type' => 'modules',
            ],
            'apiOrders' => [
                'dataProvider' => $this->container->getService(OrderDataProvider::class),
                'type' => 'orders',
            ],
            'apiProducts' => [
                'dataProvider' => $this->container->getService(ProductDataProvider::class),
                'type' => 'products',
            ],
        ];
    }
}
