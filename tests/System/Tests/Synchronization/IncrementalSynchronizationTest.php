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
use PrestaShop\Module\PsEventbus\Repository\EventbusSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository;
use PrestaShop\Module\PsEventbus\Service\SynchronizationService;
use PrestaShop\Module\PsEventbus\Tests\System\Tests\BaseTestCase;
use Product;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Support\StepSupport;

/**
 * @Features("synchronization")
 * @Stories("incremental synchronization")
 */
class IncrementalSynchronizationTest extends BaseTestCase
{
    use StepSupport;

    /**
     * @var EventbusSyncRepository
     */
    private $syncRepository;

    public function setUp()
    {
        parent::setUp();
        $product = new Product(1);
        $product->setCarriers([1, 2]);
        /* @var EventbusSyncRepository $syncRepository */
        $this->syncRepository = $this->container->getService(EventbusSyncRepository::class);
    }

    /**
     * @Stories("incremental synchronization")
     * @Title("testIncrementalSync")
     */
    public function testIncrementalSync()
    {
        /** @var IncrementalSyncRepository $incrementalSyncRepository */
        $incrementalSyncRepository = $this->container->getService(IncrementalSyncRepository::class);

        $this->executeStep('apiCarriers', function () use ($incrementalSyncRepository) {
            $this->syncRepository->insertTypeSync(Config::COLLECTION_CARRIERS, 0, date(DATE_ATOM), 'en');
            $incrementalSyncRepository->insertIncrementalObject(1, Config::COLLECTION_CARRIERS, date(DATE_ATOM), 1, 'en');
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(CarrierDataProvider::class);
            $this->handle($provider, Config::COLLECTION_CARRIERS);
        });

        $this->executeStep('apiCarts', function () use ($incrementalSyncRepository) {
            $this->syncRepository->insertTypeSync(Config::COLLECTION_CARTS, 0, date(DATE_ATOM), 'en');
            $incrementalSyncRepository->insertIncrementalObject(1, Config::COLLECTION_CARTS, date(DATE_ATOM), 1, 'en');
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(CartDataProvider::class);
            $this->handle($provider, Config::COLLECTION_CARTS);
        });

        $this->executeStep('apiCategories', function () use ($incrementalSyncRepository) {
            $this->syncRepository->insertTypeSync(Config::COLLECTION_CATEGORIES, 0, date(DATE_ATOM), 'en');
            $incrementalSyncRepository->insertIncrementalObject(1, Config::COLLECTION_CATEGORIES, date(DATE_ATOM), 1, 'en');
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(CategoryDataProvider::class);
            $this->handle($provider, Config::COLLECTION_CATEGORIES);
        });

        $this->executeStep('apiModules', function () use ($incrementalSyncRepository) {
            $this->syncRepository->insertTypeSync(Config::COLLECTION_MODULES, 0, date(DATE_ATOM), 'en');
            $incrementalSyncRepository->insertIncrementalObject(1, Config::COLLECTION_MODULES, date(DATE_ATOM), 1, 'en');
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(ModuleDataProvider::class);
            $this->handle($provider, Config::COLLECTION_MODULES, false);
        });

        $this->executeStep('apiOrders', function () use ($incrementalSyncRepository) {
            $this->syncRepository->insertTypeSync(Config::COLLECTION_ORDERS, 0, date(DATE_ATOM), 'en');
            $incrementalSyncRepository->insertIncrementalObject(1, Config::COLLECTION_ORDERS, date(DATE_ATOM), 1, 'en');
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(OrderDataProvider::class);
            $this->handle($provider, Config::COLLECTION_ORDERS);
        });

        $this->executeStep('apiProducts', function () use ($incrementalSyncRepository) {
            $this->syncRepository->insertTypeSync(Config::COLLECTION_PRODUCTS, 0, date(DATE_ATOM), 'en');
            $incrementalSyncRepository->insertIncrementalObject(1, Config::COLLECTION_PRODUCTS, date(DATE_ATOM), 1, 'en');
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(ProductDataProvider::class);
            $this->handle($provider, Config::COLLECTION_PRODUCTS);
        });

        $this->executeStep('apiSpecificPrices', function () use ($incrementalSyncRepository) {
            $this->syncRepository->insertTypeSync(Config::COLLECTION_PRODUCTS, 0, date(DATE_ATOM), 'en');
            $incrementalSyncRepository->insertIncrementalObject(1, Config::COLLECTION_PRODUCTS, date(DATE_ATOM), 1, 'en');
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(CustomPriceDataProvider::class);
            $this->handle($provider, Config::COLLECTION_PRODUCTS);
        });

        $this->executeStep('apiCustomProductCarriers', function () use ($incrementalSyncRepository) {
            $this->syncRepository->insertTypeSync(Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS, 0, date(DATE_ATOM), 'en');
            $incrementalSyncRepository->insertIncrementalObject(1, Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS, date(DATE_ATOM), 1, 'en');
            /** @var PaginatedApiDataProviderInterface $provider */
            $provider = $this->container->getService(CustomProductCarrierDataProvider::class);
            $this->handle($provider, Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS);
        });
    }

    private function handle(PaginatedApiDataProviderInterface $dataProvider, $type, $hasRemainingObject = true)
    {
        /** @var SynchronizationService $syncService */
        $syncService = $this->container->getService(SynchronizationService::class);
        $response = $syncService->handleIncrementalSync(
            $dataProvider,
            $type,
            'test',
            50,
            'en',
            '2021-10-10T10:10:10'
        );

        if ($hasRemainingObject) {
            $this->assertEquals(201, $response['httpCode']);

            return;
        }

        $this->assertEquals(0, $response['total_objects']);
    }
}
