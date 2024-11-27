<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\PsEventbus\Traits;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\CustomProductCarrierRepository;
use PrestaShop\Module\PsEventbus\Repository\StockRepository;
use PrestaShop\Module\PsEventbus\Service\SynchronizationService;

if (!defined('_PS_VERSION_')) {
    exit;
}

trait UseHooks
{
    /**
     * @return array<string>
     */
    public function getHooks()
    {
        // Retourne la liste des hooks a register
        return [
            'actionObjectCarrierAddAfter',
            'actionObjectCarrierDeleteAfter',
            'actionObjectCarrierUpdateAfter',

            'actionObjectCartAddAfter',
            'actionObjectCartUpdateAfter',

            'actionObjectCartRuleAddAfter',
            'actionObjectCartRuleDeleteAfter',
            'actionObjectCartRuleUpdateAfter',

            'actionObjectCategoryAddAfter',
            'actionObjectCategoryDeleteAfter',
            'actionObjectCategoryUpdateAfter',

            'actionObjectCombinationDeleteAfter',

            'actionObjectCountryAddAfter',
            'actionObjectCountryDeleteAfter',
            'actionObjectCountryUpdateAfter',

            'actionObjectCurrencyAddAfter',
            'actionObjectCurrencyUpdateAfter',

            'actionObjectCustomerAddAfter',
            'actionObjectCustomerDeleteAfter',
            'actionObjectCustomerUpdateAfter',

            'actionObjectImageAddAfter',
            'actionObjectImageDeleteAfter',
            'actionObjectImageUpdateAfter',

            'actionObjectLanguageAddAfter',
            'actionObjectLanguageDeleteAfter',
            'actionObjectLanguageUpdateAfter',

            'actionObjectManufacturerAddAfter',
            'actionObjectManufacturerDeleteAfter',
            'actionObjectManufacturerUpdateAfter',

            'actionObjectOrderAddAfter',
            'actionObjectOrderUpdateAfter',

            'actionObjectProductAddAfter',
            'actionObjectProductDeleteAfter',
            'actionObjectProductUpdateAfter',

            'actionObjectSpecificPriceAddAfter',
            'actionObjectSpecificPriceDeleteAfter',
            'actionObjectSpecificPriceUpdateAfter',

            'actionObjectStateAddAfter',
            'actionObjectStateDeleteAfter',
            'actionObjectStateUpdateAfter',

            'actionObjectStockAddAfter',
            'actionObjectStockUpdateAfter',

            'actionObjectStoreAddAfter',
            'actionObjectStoreDeleteAfter',
            'actionObjectStoreUpdateAfter',

            'actionObjectSupplierAddAfter',
            'actionObjectSupplierDeleteAfter',
            'actionObjectSupplierUpdateAfter',

            'actionObjectTaxAddAfter',
            'actionObjectTaxDeleteAfter',
            'actionObjectTaxRulesGroupAddAfter',
            'actionObjectTaxRulesGroupDeleteAfter',
            'actionObjectTaxRulesGroupUpdateAfter',
            'actionObjectTaxUpdateAfter',

            'actionObjectWishlistAddAfter',
            'actionObjectWishlistDeleteAfter',
            'actionObjectWishlistUpdateAfter',

            'actionObjectZoneAddAfter',
            'actionObjectZoneDeleteAfter',
            'actionObjectZoneUpdateAfter',

            'actionShippingPreferencesPageSave',

            'actionObjectEmployeeAddAfter',
            'actionObjectEmployeeDeleteAfter',
            'actionObjectEmployeeUpdateAfter',

            'actionDispatcherBefore',
        ];
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectImageDeleteAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Image $image */
        $image = $parameters['object'];

        if ($image->id_product) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_IMAGES,Config::INCREMENTAL_TYPE_DELETE);
    
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_IMAGES => $image->id_image],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectImageAddAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Image $image */
        $image = $parameters['object'];

        if ($image->id_product) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_IMAGES,Config::INCREMENTAL_TYPE_UPSERT);
    
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_IMAGES => $image->id_image],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectImageUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Image $image */
        $image = $parameters['object'];

        if ($image->id_product) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_IMAGES, Config::INCREMENTAL_TYPE_UPSERT);
    
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_IMAGES => $image->id_image],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectLanguageDeleteAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Language $language */
        $language = $parameters['object'];

        if ($language->id) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_LANGUAGES, Config::INCREMENTAL_TYPE_DELETE);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_LANGUAGES => $language->id],
                Config::INCREMENTAL_TYPE_DELETE,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectLanguageAddAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Language $language */
        $language = $parameters['object'];

        if ($language->id) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_LANGUAGES, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_LANGUAGES => $language->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectLanguageUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Language $language */
        $language = $parameters['object'];

        if ($language->id) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_LANGUAGES, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_LANGUAGES => $language->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectManufacturerDeleteAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Manufacturer $manufacturer */
        $manufacturer = $parameters['object'];

        if (isset($manufacturer->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_MANUFACTURERS, Config::INCREMENTAL_TYPE_DELETE);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_MANUFACTURERS => $manufacturer->id],
                Config::INCREMENTAL_TYPE_DELETE,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectManufacturerAddAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Manufacturer $manufacturer */
        $manufacturer = $parameters['object'];

        if (isset($manufacturer->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_MANUFACTURERS, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_MANUFACTURERS => $manufacturer->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectManufacturerUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Manufacturer $manufacturer */
        $manufacturer = $parameters['object'];

        if (isset($manufacturer->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_MANUFACTURERS, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_MANUFACTURERS => $manufacturer->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectSupplierDeleteAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Supplier $supplier */
        $supplier = $parameters['object'];

        if (isset($supplier->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_SUPPLIERS, Config::INCREMENTAL_TYPE_DELETE);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_SUPPLIERS => $supplier->id],
                Config::INCREMENTAL_TYPE_DELETE,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectSupplierAddAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Supplier $supplier */
        $supplier = $parameters['object'];

        if (isset($supplier->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_SUPPLIERS, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_SUPPLIERS => $supplier->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectSupplierUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Supplier $supplier */
        $supplier = $parameters['object'];

        if (isset($supplier->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_SUPPLIERS, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_SUPPLIERS => $supplier->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectProductDeleteAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Product $product */
        $product = $parameters['object'];

        if (isset($product->id)) {
            $synchronizationService->sendLiveSync(
                [
                    Config::COLLECTION_PRODUCTS,
                    Config::COLLECTION_BUNDLES,
                    Config::COLLECTION_PRODUCT_SUPPLIERS
                ],
                Config::INCREMENTAL_TYPE_DELETE
            );
            $synchronizationService->insertContentIntoIncremental(
                [
                    Config::COLLECTION_PRODUCTS => $product->id,
                    Config::COLLECTION_BUNDLES => $product->id,
                    Config::COLLECTION_PRODUCT_SUPPLIERS => $product->id
                ],
                Config::INCREMENTAL_TYPE_DELETE,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectProductAddAfter($parameters)
    {
        /** @var \Product $product */
        $product = $parameters['object'];

        if (!isset($product->id)) {
            return;
        }

        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var CustomProductCarrierRepository $customProductCarrierRepository */
        $customProductCarrierRepository = $this->getService('PrestaShop\Module\PsEventbus\Repository\CustomProductCarrierRepository');
        $customProductCarriers = $customProductCarrierRepository->getCustomProductCarrierIdsByCarrierId($product->id);
        $customProductCarrierIds = array_column($customProductCarriers, 'id_carrier_reference');

        /** @var StockRepository $stockRepository */
        $stockRepository = $this->getService('PrestaShop\Module\PsEventbus\Repository\StockRepository');
        $stockId = $stockRepository->getStockIdByProductId($product->id);

        $synchronizationService->sendLiveSync(
            [
                Config::COLLECTION_PRODUCTS,
                Config::COLLECTION_BUNDLES,
                Config::COLLECTION_PRODUCT_SUPPLIERS,
                Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS,
                Config::COLLECTION_STOCKS,
                CONFIG::COLLECTION_STOCK_MOVEMENTS
            ],
            Config::INCREMENTAL_TYPE_UPSERT
        );

        $synchronizationService->insertContentIntoIncremental(
            [
                Config::COLLECTION_PRODUCTS => $product->id,
                Config::COLLECTION_BUNDLES => $product->id,
                Config::COLLECTION_PRODUCT_SUPPLIERS => $product->id,
                Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS => $customProductCarrierIds,
                Config::COLLECTION_STOCKS => $stockId,
                CONFIG::COLLECTION_STOCK_MOVEMENTS => $stockId
            ],
            Config::INCREMENTAL_TYPE_UPSERT,
            date(DATE_ATOM),
            $this->shopId,
            true
        );
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectProductUpdateAfter($parameters)
    {
        /** @var \Product $product */
        $product = $parameters['object'];

        if (!isset($product->id)) {
            return;
        }

        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var CustomProductCarrierRepository $customProductCarrierRepository */
        $customProductCarrierRepository = $this->getService('PrestaShop\Module\PsEventbus\Repository\CustomProductCarrierRepository');
        $customProductCarriers = $customProductCarrierRepository->getCustomProductCarrierIdsByCarrierId($product->id);
        $customProductCarrierIds = array_column($customProductCarriers, 'id_carrier_reference');

        /** @var StockRepository $stockRepository */
        $stockRepository = $this->getService('PrestaShop\Module\PsEventbus\Repository\StockRepository');
        $stockId = $stockRepository->getStockIdByProductId($product->id);

        $synchronizationService->sendLiveSync(
            [
                Config::COLLECTION_PRODUCTS,
                Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS,
                Config::COLLECTION_STOCKS,
                CONFIG::COLLECTION_STOCK_MOVEMENTS
            ],
            Config::INCREMENTAL_TYPE_UPSERT
        );

        $synchronizationService->insertContentIntoIncremental(
            [
                Config::COLLECTION_PRODUCTS => $product->id,
                Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS => $customProductCarrierIds,
                Config::COLLECTION_STOCKS => $stockId,
                CONFIG::COLLECTION_STOCK_MOVEMENTS => $stockId
            ],
            Config::INCREMENTAL_TYPE_UPSERT,
            date(DATE_ATOM),
            $this->shopId,
            true
        );
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectWishlistDeleteAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $wishlist = $parameters['object'];

        if ($wishlist->id) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_WISHLISTS, Config::INCREMENTAL_TYPE_DELETE);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_WISHLISTS => $wishlist->id],
                Config::INCREMENTAL_TYPE_DELETE,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectWishlistAddAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $wishlist = $parameters['object'];

        if ($wishlist->id) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_WISHLISTS, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_WISHLISTS => $wishlist->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectWishlistUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $wishlist = $parameters['object'];

        if ($wishlist->id) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_WISHLISTS, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_WISHLISTS => $wishlist->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectStockAddAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Stock $stock */
        $stock = $parameters['object'];

        if (isset($stock->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_STOCKS, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_STOCKS => $stock->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectStockUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Stock $stock */
        $stock = $parameters['object'];

        if (isset($stock->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_STOCKS, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_STOCKS => $stock->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectStoreDeleteAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Store $store */
        $store = $parameters['object'];

        if ($store->id) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_STORES, Config::INCREMENTAL_TYPE_DELETE);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_STORES => $store->id],
                Config::INCREMENTAL_TYPE_DELETE,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectStoreAddAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Store $store */
        $store = $parameters['object'];

        if ($store->id) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_STORES, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_STORES => $store->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectStoreUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Store $store */
        $store = $parameters['object'];

        if ($store->id) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_STORES, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_STORES => $store->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCombinationDeleteAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Combination $combination */
        $combination = $parameters['object'];

        if (isset($combination->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_ATTRIBUTES, Config::INCREMENTAL_TYPE_DELETE);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_ATTRIBUTES => $combination->id],
                Config::INCREMENTAL_TYPE_DELETE,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCategoryAddAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Category $category * */
        $category = $parameters['object'];

        if (isset($category->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_CATEGORIES, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_CATEGORIES => $category->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCategoryUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Category $category * */
        $category = $parameters['object'];

        if (isset($category->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_CATEGORIES, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_CATEGORIES => $category->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCategoryDeleteAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Category $category * */
        $category = $parameters['object'];

        if (isset($category->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_CATEGORIES, Config::INCREMENTAL_TYPE_DELETE);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_CATEGORIES => $category->id],
                Config::INCREMENTAL_TYPE_DELETE,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCustomerAddAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Customer $customer * */
        $customer = $parameters['object'];

        if ($customer->id) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_CUSTOMERS, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_CUSTOMERS => $customer->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCustomerUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Customer $customer * */
        $customer = $parameters['object'];

        if ($customer->id) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_CUSTOMERS, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_CUSTOMERS => $customer->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCustomerDeleteAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Customer $customer * */
        $customer = $parameters['object'];

        if ($customer->id) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_CUSTOMERS, Config::INCREMENTAL_TYPE_DELETE);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_CUSTOMERS => $customer->id],
                Config::INCREMENTAL_TYPE_DELETE,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCurrencyAddAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Currency $currency * */
        $currency = $parameters['object'];

        if (isset($currency->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_CURRENCIES, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_CURRENCIES => $currency->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCurrencyUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Currency $currency * */
        $currency = $parameters['object'];

        if (isset($currency->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_CURRENCIES, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_CURRENCIES => $currency->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCurrencyDeleteAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Currency $currency * */
        $currency = $parameters['object'];

        if (isset($currency->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_CURRENCIES, Config::INCREMENTAL_TYPE_DELETE);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_CURRENCIES => $currency->id],
                Config::INCREMENTAL_TYPE_DELETE,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCartAddAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $cart = $parameters['object'];

        if (isset($cart->id)) {
            $synchronizationService->sendLiveSync(
                [
                    Config::COLLECTION_CARTS,
                    Config::COLLECTION_CART_PRODUCTS
                ],
                Config::INCREMENTAL_TYPE_UPSERT
            );
    
            $synchronizationService->insertContentIntoIncremental(
                [
                    Config::COLLECTION_CARTS => $cart->id,
                    Config::COLLECTION_CART_PRODUCTS => $cart->id
                ],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCartUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $cart = $parameters['object'];

        if (isset($cart->id)) {
            $synchronizationService->sendLiveSync(
                [
                    Config::COLLECTION_CARTS,
                    Config::COLLECTION_CART_PRODUCTS
                ],
                Config::INCREMENTAL_TYPE_UPSERT
            );
    
            $synchronizationService->insertContentIntoIncremental(
                [
                    Config::COLLECTION_CARTS => $cart->id,
                    Config::COLLECTION_CART_PRODUCTS => $cart->id
                ],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCartRuleAddAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $cartRule = $parameters['object'];

        if (isset($cartRule->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_CART_RULES, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_CART_RULES => $cartRule->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCartRuleDeleteAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $cartRule = $parameters['object'];

        if (isset($cartRule->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_CART_RULES, Config::INCREMENTAL_TYPE_DELETE);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_CART_RULES => $cartRule->id],
                Config::INCREMENTAL_TYPE_DELETE,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCartRuleUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $cartRule = $parameters['object'];

        if (isset($cartRule->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_CART_RULES, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_CART_RULES => $cartRule->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectOrderAddAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $order = $parameters['object'];

        if (isset($order->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_ORDERS, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_ORDERS => $order->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectOrderUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $order = $parameters['object'];

        if (isset($order->id)) {
            $synchronizationService->sendLiveSync(
                [
                    Config::COLLECTION_ORDERS,
                    Config::COLLECTION_ORDER_CART_RULES,
                    Config::COLLECTION_ORDER_DETAILS,
                    Config::COLLECTION_ORDER_STATUS_HISTORY,
                ],
                Config::INCREMENTAL_TYPE_UPSERT
            );
            $synchronizationService->insertContentIntoIncremental(
                [
                    Config::COLLECTION_ORDERS => $order->id,
                    Config::COLLECTION_ORDER_CART_RULES => $order->id,
                    Config::COLLECTION_ORDER_DETAILS => $order->id,
                    Config::COLLECTION_ORDER_STATUS_HISTORY => $order->id,
                ],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCarrierAddAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Carrier $carrier */
        $carrier = $parameters['object'];

        if (isset($carrier->id)) {
            $synchronizationService->sendLiveSync(
                [
                    Config::COLLECTION_CARRIERS => $carrier->id,
                    Config::COLLECTION_CARRIER_DETAILS => $carrier->id,
                    Config::COLLECTION_CARRIER_TAXES => $carrier->id,
                ],
                Config::INCREMENTAL_TYPE_UPSERT
            );

            $synchronizationService->insertContentIntoIncremental(
                [
                    Config::COLLECTION_CARRIERS => $carrier->id,
                    Config::COLLECTION_CARRIER_DETAILS => $carrier->id,
                    Config::COLLECTION_CARRIER_TAXES => $carrier->id,
                ],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCarrierUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \Carrier $carrier */
        $carrier = $parameters['object'];

        if (isset($carrier->id)) {
            $synchronizationService->sendLiveSync(
                [
                    Config::COLLECTION_CARRIERS,
                    Config::COLLECTION_CARRIER_DETAILS,
                    Config::COLLECTION_CARRIER_TAXES,
                ],
                Config::INCREMENTAL_TYPE_UPSERT
            );

            $synchronizationService->insertContentIntoIncremental(
                [
                    Config::COLLECTION_CARRIERS => $carrier->id,
                    Config::COLLECTION_CARRIER_DETAILS => $carrier->id,
                    Config::COLLECTION_CARRIER_TAXES => $carrier->id,
                ],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectCarrierDeleteAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);
        /** @var \Carrier $carrier */
        $carrier = $parameters['object'];

        if (isset($carrier->id)) {
            $synchronizationService->sendLiveSync(
                [
                    Config::COLLECTION_CARRIERS,
                    Config::COLLECTION_CARRIER_DETAILS,
                    Config::COLLECTION_CARRIER_TAXES,
                ],
                Config::INCREMENTAL_TYPE_DELETE
            );

            $synchronizationService->insertContentIntoIncremental(
                [
                    Config::COLLECTION_CARRIERS => $carrier->id,
                    Config::COLLECTION_CARRIER_DETAILS => $carrier->id,
                    Config::COLLECTION_CARRIER_TAXES => $carrier->id,
                ],
                Config::INCREMENTAL_TYPE_DELETE,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @return void
     */
    public function hookActionObjectCountryAddAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_UPSERT,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectCountryUpdateAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_UPSERT,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectCountryDeleteAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_DELETE,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectStateAddAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_UPSERT,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectStateUpdateAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_UPSERT,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectStateDeleteAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_DELETE,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectZoneAddAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_UPSERT,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectZoneUpdateAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_UPSERT,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectZoneDeleteAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_DELETE,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxAddAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_UPSERT,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxUpdateAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_UPSERT,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxDeleteAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_DELETE,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxRulesGroupAddAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_UPSERT,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxRulesGroupUpdateAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_UPSERT,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxRulesGroupDeleteAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_DELETE,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionShippingPreferencesPageSave()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_CARRIERS => 0],
            Config::INCREMENTAL_TYPE_DELETE,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectEmployeeAddAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_EMPLOYEES => 0],
            Config::INCREMENTAL_TYPE_UPSERT,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectEmployeeDeleteAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);
        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_EMPLOYEES => 0],
            Config::INCREMENTAL_TYPE_DELETE,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectEmployeeUpdateAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $synchronizationService->insertContentIntoIncremental(
            [Config::COLLECTION_EMPLOYEES => 0],
            Config::INCREMENTAL_TYPE_UPSERT,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * This is global hook. This hook is called at the beginning of the dispatch method of the Dispatcher
     * It's possible to use this hook all time when we don't have specific hook.
     * Available since: 1.7.1
     *
     * Unable to use hookActionDispatcherAfter. Seem to be have a strange effect. When i use
     * this hook and try to dump() the content, no dump appears in the symfony debugger, and no more hooks appear.
     * For security reasons, I like to use the before hook, and put it in a try/catch
     *
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionDispatcherBefore($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        try {
            /*
             * Class "ActionDispatcherLegacyHooksSubscriber" as implement in 1.7.3.0:
             * https://github.com/PrestaShop/PrestaShop/commit/a4ae4544cc62c818aba8b3d9254308f538b7acdc
             */
            if ($parameters['controller_type'] != 2) {
                return;
            }

            if (array_key_exists('route', $parameters)) {
                $route = $parameters['route'];

                // when translation is edited or reset, add to incremental sync
                if ($route == 'api_translation_value_edit' || $route == 'api_translation_value_reset') {
                    $synchronizationService->insertContentIntoIncremental(
                        [Config::COLLECTION_TRANSLATIONS => 0],
                        Config::INCREMENTAL_TYPE_UPSERT,
                        date(DATE_ATOM),
                        $this->shopId,
                        false
                    );
                }
            }
        } catch (\Exception $e) {
            return;
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectSpecificPriceAddAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        $specificPrice = $parameters['object'];

        if ($specificPrice instanceof \SpecificPrice && isset($specificPrice->id)) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_SPECIFIC_PRICES, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_SPECIFIC_PRICES => $specificPrice->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectSpecificPriceUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \SpecificPrice $specificPrice */
        $specificPrice = $parameters['object'];

        if ($specificPrice->id) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_SPECIFIC_PRICES, Config::INCREMENTAL_TYPE_UPSERT);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_SPECIFIC_PRICES => $specificPrice->id],
                Config::INCREMENTAL_TYPE_UPSERT,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectSpecificPriceDeleteAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService(Config::SYNC_SERVICE_NAME);

        /** @var \SpecificPrice $specificPrice */
        $specificPrice = $parameters['object'];

        if ($specificPrice->id) {
            $synchronizationService->sendLiveSync(Config::COLLECTION_SPECIFIC_PRICES, Config::INCREMENTAL_TYPE_DELETE);
            $synchronizationService->insertContentIntoIncremental(
                [Config::COLLECTION_SPECIFIC_PRICES => $specificPrice->id],
                Config::INCREMENTAL_TYPE_DELETE,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }
}
