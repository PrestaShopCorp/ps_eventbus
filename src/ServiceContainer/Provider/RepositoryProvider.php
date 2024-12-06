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
use PrestaShop\Module\PsEventbus\ServiceContainer\Contract\IServiceProvider;
use PrestaShop\Module\PsEventbus\ServiceContainer\ServiceContainer;
use PrestaShop\Module\PsEventbus\Repository\AttributeRepository;

class RepositoryProvider implements IServiceProvider
{
    /**
     * @param ServiceContainer $container
     *
     * @return void
     */
    public function provide(ServiceContainer $container)
    {
        $container->registerProvider(BundleRepository::class, static function () {
            return new BundleRepository();
        });
        $container->registerProvider(CarrierRepository::class, static function () {
            return new CarrierRepository();
        });
        $container->registerProvider(CarrierDetailRepository::class, static function () {
            return new CarrierDetailRepository();
        });
        $container->registerProvider(CarrierTaxeRepository::class, static function () {
            return new CarrierTaxeRepository();
        });
        $container->registerProvider(CartRepository::class, static function () {
            return new CartRepository();
        });
        $container->registerProvider(CartProductRepository::class, static function () {
            return new CartProductRepository();
        });
        $container->registerProvider(CartRuleRepository::class, static function () {
            return new CartRuleRepository();
        });
        $container->registerProvider(CustomProductCarrierRepository::class, static function () {
            return new CustomProductCarrierRepository();
        });
        $container->registerProvider(CategoryRepository::class, static function () {
            return new CategoryRepository();
        });
        $container->registerProvider(CustomerRepository::class, static function () {
            return new CustomerRepository();
        });
        $container->registerProvider(CurrencyRepository::class, static function () {
            return new CurrencyRepository();
        });
        $container->registerProvider(EmployeeRepository::class, static function () {
            return new EmployeeRepository();
        });
        $container->registerProvider(ImageRepository::class, static function () {
            return new ImageRepository();
        });
        $container->registerProvider(ImageTypeRepository::class, static function () {
            return new ImageTypeRepository();
        });
        $container->registerProvider(IncrementalSyncRepository::class, static function () use ($container) {
            return new IncrementalSyncRepository(
                $container->get(ErrorHandler::class)
            );
        });
        $container->registerProvider(ModuleRepository::class, static function () {
            return new ModuleRepository();
        });
        $container->registerProvider(LanguageRepository::class, static function () {
            return new LanguageRepository();
        });
        $container->registerProvider(LiveSyncRepository::class, static function () {
            return new LiveSyncRepository();
        });
        $container->registerProvider(ManufacturerRepository::class, static function () {
            return new ManufacturerRepository();
        });
        $container->registerProvider(OrderRepository::class, static function () {
            return new OrderRepository();
        });
        $container->registerProvider(OrderCartRuleRepository::class, static function () {
            return new OrderCartRuleRepository();
        });
        $container->registerProvider(OrderStatusHistoryRepository::class, static function () {
            return new OrderStatusHistoryRepository();
        });
        $container->registerProvider(OrderDetailRepository::class, static function () {
            return new OrderDetailRepository();
        });
        $container->registerProvider(ProductRepository::class, static function () {
            return new ProductRepository();
        });
        $container->registerProvider(ProductSupplierRepository::class, static function () {
            return new ProductSupplierRepository();
        });
        $container->registerProvider(InfoRepository::class, static function () {
            return new InfoRepository();
        });
        
        $container->registerProvider(StockRepository::class, static function () {
            return new StockRepository();
        });
        $container->registerProvider(StockMovementRepository::class, static function () {
            return new StockMovementRepository();
        });
        $container->registerProvider(SpecificPriceRepository::class, static function () {
            return new SpecificPriceRepository();
        });
        $container->registerProvider(SupplierRepository::class, static function () {
            return new SupplierRepository();
        });
        $container->registerProvider(StoreRepository::class, static function () {
            return new StoreRepository();
        });
        $container->registerProvider(SyncRepository::class, static function () {
            return new SyncRepository();
        });
        $container->registerProvider(TaxonomyRepository::class, static function () {
            return new TaxonomyRepository();
        });
        $container->registerProvider(TranslationRepository::class, static function () {
            return new TranslationRepository();
        });
        $container->registerProvider(WishlistRepository::class, static function () {
            return new WishlistRepository();
        });
        $container->registerProvider(WishlistProductRepository::class, static function () {
            return new WishlistProductRepository();
        });
    }
}
