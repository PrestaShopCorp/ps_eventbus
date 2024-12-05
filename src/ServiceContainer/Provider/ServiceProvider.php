<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace PrestaShop\Module\PsEventbus\ServiceContainer\Provider;

use PrestaShop\Module\PsEventbus\Api\LiveSyncApiClient;
use PrestaShop\Module\PsEventbus\Api\SyncApiClient;
use PrestaShop\Module\PsEventbus\Formatter\ArrayFormatter;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;
use PrestaShop\Module\PsEventbus\Repository\BundleRepository;
use PrestaShop\Module\PsEventbus\Repository\CarrierDetailRepository;
use PrestaShop\Module\PsEventbus\Repository\CarrierRepository;
use PrestaShop\Module\PsEventbus\Repository\CarrierTaxeRepository;
use PrestaShop\Module\PsEventbus\Repository\CartProductRepository;
use PrestaShop\Module\PsEventbus\Repository\CartRepository;
use PrestaShop\Module\PsEventbus\Repository\CartRuleRepository;
use PrestaShop\Module\PsEventbus\Repository\CategoryRepository;
use PrestaShop\Module\PsEventbus\Repository\CurrencyRepository;
use PrestaShop\Module\PsEventbus\Repository\CustomerRepository;
use PrestaShop\Module\PsEventbus\Repository\CustomProductCarrierRepository;
use PrestaShop\Module\PsEventbus\Repository\EmployeeRepository;
use PrestaShop\Module\PsEventbus\Repository\ImageRepository;
use PrestaShop\Module\PsEventbus\Repository\ImageTypeRepository;
use PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\InfoRepository;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;
use PrestaShop\Module\PsEventbus\Repository\LiveSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\ManufacturerRepository;
use PrestaShop\Module\PsEventbus\Repository\ModuleRepository;
use PrestaShop\Module\PsEventbus\Repository\OrderCartRuleRepository;
use PrestaShop\Module\PsEventbus\Repository\OrderDetailRepository;
use PrestaShop\Module\PsEventbus\Repository\OrderRepository;
use PrestaShop\Module\PsEventbus\Repository\OrderStatusHistoryRepository;
use PrestaShop\Module\PsEventbus\Repository\ProductRepository;
use PrestaShop\Module\PsEventbus\Repository\ProductSupplierRepository;
use PrestaShop\Module\PsEventbus\Repository\SpecificPriceRepository;
use PrestaShop\Module\PsEventbus\Repository\StockMovementRepository;
use PrestaShop\Module\PsEventbus\Repository\StockRepository;
use PrestaShop\Module\PsEventbus\Repository\StoreRepository;
use PrestaShop\Module\PsEventbus\Repository\SupplierRepository;
use PrestaShop\Module\PsEventbus\Repository\SyncRepository;
use PrestaShop\Module\PsEventbus\Repository\TaxonomyRepository;
use PrestaShop\Module\PsEventbus\Repository\TranslationRepository;
use PrestaShop\Module\PsEventbus\Repository\WishlistProductRepository;
use PrestaShop\Module\PsEventbus\Repository\WishlistRepository;
use PrestaShop\Module\PsEventbus\Service\ApiAuthorizationService;
use PrestaShop\Module\PsEventbus\Service\ApiHealthCheckService;
use PrestaShop\Module\PsEventbus\Service\ApiShopContentService;
use PrestaShop\Module\PsEventbus\Service\PresenterService;
use PrestaShop\Module\PsEventbus\Service\ProxyService;
use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\AttributesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\BundlesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\CarrierDetailsService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\CarriersService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\CarrierTaxesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\CartProductsService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\CartRulesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\CartsService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\CategoriesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\CurrenciesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\CustomersService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\CustomProductCarriersService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\EmployeesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\ImagesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\ImageTypesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\InfoService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\LanguagesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\ManufacturersService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\ModulesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\OrderCartRulesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\OrderDetailsService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\OrdersService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\OrderStatusHistoryService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\ProductsService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\ProductSuppliersService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\SpecificPricesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\StockMovementsService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\StocksService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\StoresService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\SuppliersService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\TaxonomiesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\ThemesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\TranslationsService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\WishlistProductsService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\WishlistsService;
use PrestaShop\Module\PsEventbus\Service\SynchronizationService;
use PrestaShop\Module\PsEventbus\ServiceContainer\Contract\IServiceProvider;
use PrestaShop\Module\PsEventbus\ServiceContainer\ServiceContainer;

class ServiceProvider implements IServiceProvider
{
    /**
     * @param ServiceContainer $container
     *
     * @return void
     */
    public function provide(ServiceContainer $container)
    {
        $container->registerProvider(ApiAuthorizationService::class, static function () use ($container) {
            return new ApiAuthorizationService(
                $container->get(SyncRepository::class),
                $container->get(SyncApiClient::class),
                $container->get(PsAccountsAdapterService::class),
                $container->get(ErrorHandler::class)
            );
        });
        $container->registerProvider(ApiShopContentService::class, static function () use ($container) {
            return new ApiShopContentService(
                $container->get('ps_eventbus.module'),
                $container->get(ApiAuthorizationService::class),
                $container->get(SynchronizationService::class),
                $container->get(SyncRepository::class),
                $container->get(ErrorHandler::class)
            );
        });
        $container->registerProvider(ApiHealthCheckService::class, static function () use ($container) {
            return new ApiHealthCheckService(
                $container->get(PsAccountsAdapterService::class),
                $container->get(ApiAuthorizationService::class),
                $container->get(ErrorHandler::class),
                $container->getParameter('ps_eventbus.sync_api_url'),
                $container->getParameter('ps_eventbus.live_sync_api_url'),
                $container->getParameter('ps_eventbus.proxy_api_url')
            );
        });
        $container->registerProvider(AttributesService::class, static function () use ($container) {
            return new AttributesService();
        });
        $container->registerProvider(BundlesService::class, static function () use ($container) {
            return new BundlesService(
                $container->get(BundleRepository::class)
            );
        });
        $container->registerProvider(CarriersService::class, static function () use ($container) {
            return new CarriersService(
                $container->get(CarrierRepository::class)
            );
        });
        $container->registerProvider(CarrierDetailsService::class, static function () use ($container) {
            return new CarrierDetailsService(
                $container->get(CarrierDetailRepository::class)
            );
        });
        $container->registerProvider(CarrierTaxesService::class, static function () use ($container) {
            return new CarrierTaxesService(
                $container->get(CarrierTaxeRepository::class)
            );
        });
        $container->registerProvider(CartsService::class, static function () use ($container) {
            return new CartsService(
                $container->get(CartRepository::class)
            );
        });
        $container->registerProvider(CartProductsService::class, static function () use ($container) {
            return new CartProductsService(
                $container->get(CartProductRepository::class)
            );
        });
        $container->registerProvider(CartRulesService::class, static function () use ($container) {
            return new CartRulesService(
                $container->get(CartRuleRepository::class)
            );
        });
        $container->registerProvider(CustomProductCarriersService::class, static function () use ($container) {
            return new CustomProductCarriersService(
                $container->get(CustomProductCarrierRepository::class)
            );
        });
        $container->registerProvider(CustomersService::class, static function () use ($container) {
            return new CustomersService(
                $container->get(CustomerRepository::class)
            );
        });
        $container->registerProvider(CategoriesService::class, static function () use ($container) {
            return new CategoriesService(
                $container->get(CategoryRepository::class)
            );
        });
        $container->registerProvider(CurrenciesService::class, static function () use ($container) {
            return new CurrenciesService(
                $container->get(CurrencyRepository::class)
            );
        });
        $container->registerProvider(EmployeesService::class, static function () use ($container) {
            return new EmployeesService(
                $container->get(EmployeeRepository::class)
            );
        });
        $container->registerProvider(ImagesService::class, static function () use ($container) {
            return new ImagesService(
                $container->get(ImageRepository::class)
            );
        });
        $container->registerProvider(ImageTypesService::class, static function () use ($container) {
            return new ImageTypesService(
                $container->get(ImageTypeRepository::class)
            );
        });
        $container->registerProvider(InfoService::class, static function () use ($container) {
            return new InfoService(
                $container->get('ps_eventbus.context'),
                $container->get(InfoRepository::class),
                $container->get(LanguagesService::class),
                $container->get(CurrenciesService::class)
            );
        });
        $container->registerProvider(LanguagesService::class, static function () use ($container) {
            return new LanguagesService(
                $container->get(LanguageRepository::class)
            );
        });
        $container->registerProvider(ManufacturersService::class, static function () use ($container) {
            return new ManufacturersService(
                $container->get(ManufacturerRepository::class)
            );
        });
        $container->registerProvider(ModulesService::class, static function () use ($container) {
            return new ModulesService(
                $container->get(ModuleRepository::class),
                $container->get(InfoRepository::class)
            );
        });
        $container->registerProvider(OrdersService::class, static function () use ($container) {
            return new OrdersService(
                $container->get(OrderRepository::class),
                $container->get(OrderStatusHistoryRepository::class),
                $container->get(ArrayFormatter::class)
            );
        });
        $container->registerProvider(OrderCartRulesService::class, static function () use ($container) {
            return new OrderCartRulesService(
                $container->get(OrderCartRuleRepository::class)
            );
        });
        $container->registerProvider(OrderDetailsService::class, static function () use ($container) {
            return new OrderDetailsService(
                $container->get(OrderDetailRepository::class)
            );
        });
        $container->registerProvider(OrderStatusHistoryService::class, static function () use ($container) {
            return new OrderStatusHistoryService(
                $container->get(OrderStatusHistoryRepository::class)
            );
        });
        $container->registerProvider(PresenterService::class, static function () {
            return new PresenterService();
        });
        $container->registerProvider(ProductsService::class, static function () use ($container) {
            return new ProductsService(
                $container->get(ProductRepository::class),
                $container->get(LanguagesService::class),
                $container->get(CategoriesService::class),
                $container->get(ArrayFormatter::class)
            );
        });
        $container->registerProvider(ProductSuppliersService::class, static function () use ($container) {
            return new ProductSuppliersService(
                $container->get(ProductSupplierRepository::class)
            );
        });
        $container->registerProvider(SynchronizationService::class, static function () use ($container) {
            return new SynchronizationService(
                $container->get(LiveSyncApiClient::class),
                $container->get(SyncRepository::class),
                $container->get(IncrementalSyncRepository::class),
                $container->get(LiveSyncRepository::class),
                $container->get(LanguagesService::class),
                $container->get(ProxyService::class),
                $container->get(ErrorHandler::class)
            );
        });
        $container->registerProvider(SpecificPricesService::class, static function () use ($container) {
            return new SpecificPricesService(
                $container->get(SpecificPriceRepository::class),
                $container->get(ProductRepository::class)
            );
        });
        $container->registerProvider(StocksService::class, static function () use ($container) {
            return new StocksService(
                $container->get(StockRepository::class)
            );
        });
        $container->registerProvider(StockMovementsService::class, static function () use ($container) {
            return new StockMovementsService(
                $container->get(StockMovementRepository::class)
            );
        });
        $container->registerProvider(StoresService::class, static function () use ($container) {
            return new StoresService(
                $container->get(StoreRepository::class)
            );
        });
        $container->registerProvider(SuppliersService::class, static function () use ($container) {
            return new SuppliersService(
                $container->get(SupplierRepository::class)
            );
        });
        $container->registerProvider(TaxonomiesService::class, static function () use ($container) {
            return new TaxonomiesService(
                $container->get(TaxonomyRepository::class)
            );
        });
        $container->registerProvider(ThemesService::class, static function () use ($container) {
            return new ThemesService(
                $container->get('ps_eventbus.context')
            );
        });
        $container->registerProvider(TranslationsService::class, static function () use ($container) {
            return new TranslationsService(
                $container->get(TranslationRepository::class)
            );
        });
        $container->registerProvider(WishlistsService::class, static function () use ($container) {
            return new WishlistsService(
                $container->get(WishlistRepository::class)
            );
        });
        $container->registerProvider(WishlistProductsService::class, static function () use ($container) {
            return new WishlistProductsService(
                $container->get(WishlistProductRepository::class)
            );
        });
    }
}
