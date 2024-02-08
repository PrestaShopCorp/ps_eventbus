<?php
/*
 * Copyright (c) 2007-2023 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please email
 * license@prestashop.com, so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2023 PrestaShop SA and Contributors
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

use PrestaShop\Module\PsEventbus\Config\Config;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Ps_eventbus extends Module
{
    /**
     * @var array
     */
    public $adminControllers;

    /**
     * @var string
     */
    const VERSION = '0.0.0';

    /**
     * @var array
     */
    const REQUIRED_TABLES = [
        'eventbus_type_sync',
        'eventbus_job',
        'eventbus_deleted_objects',
        'eventbus_incremental_sync',
    ];

    /**
     * @var string
     */
    public $version;

    /**
     * List of hook to install at the installation of the module
     *
     * @var array
     */
    private $hookToInstall = [
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
    ];

    /**
     * @var \PrestaShop\ModuleLibServiceContainer\DependencyInjection\ServiceContainer
     */
    private $serviceContainer;

    /**
     * @var int
     */
    private $shopId;

    /**
     * __construct.
     */
    public function __construct()
    {
        $this->name = 'ps_eventbus';
        $this->tab = 'administration';
        $this->author = 'PrestaShop';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->version = '0.0.0';
        $this->module_key = '7d76e08a13331c6c393755886ec8d5ce';

        parent::__construct();

        $this->displayName = $this->l('PrestaShop EventBus');
        $this->description = $this->l('Link your PrestaShop account to synchronize your shop data to a tech partner of your choice. Do not uninstall this module if you are already using a service, as it will prevent it from working.');
        $this->confirmUninstall = $this->l('This action will immediately prevent your PrestaShop services and Community services from working as they are using PrestaShop CloudSync for syncing.');
        $this->ps_versions_compliancy = ['min' => '1.6', 'max' => _PS_VERSION_];
        $this->adminControllers = [];
        // If PHP is not compliant, we will not load composer and the autoloader
        if (!$this->isPhpVersionCompliant()) {
            return;
        }

        require_once __DIR__ . '/vendor/autoload.php';

        $this->serviceContainer = new \PrestaShop\ModuleLibServiceContainer\DependencyInjection\ServiceContainer(
            (string) $this->name,
            $this->getLocalPath()
        );

        if ($this->context->shop === null) {
            throw new PrestaShopException('No shop context');
        }

        $this->shopId = (int) $this->context->shop->id;
    }

    /**
     * @return \Context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return array
     */
    public function getAdminControllers()
    {
        return $this->adminControllers;
    }

    /**
     * @return bool
     */
    public function install()
    {
        if (!$this->isPhpVersionCompliant()) {
            $this->_errors[] = $this->l('This requires PHP 7.1 to work properly. Please upgrade your server configuration.');

            // We return true during the installation of PrestaShop to not stop the whole process,
            // Otherwise we warn properly the installation failed.
            return defined('PS_INSTALLATION_IN_PROGRESS');
        }

        $installer = new PrestaShop\Module\PsEventbus\Module\Install($this, Db::getInstance());

        return $installer->installInMenu()
            && $installer->installDatabaseTables()
            && parent::install()
            && $this->registerHook($this->hookToInstall);
    }

    /**
     * @return bool
     */
    public function uninstall()
    {
        $uninstaller = new PrestaShop\Module\PsEventbus\Module\Uninstall($this, Db::getInstance());

        return $uninstaller->uninstallMenu()
            && $uninstaller->uninstallDatabaseTables()
            && parent::uninstall();
    }

    /**
     * @param string $serviceName
     *
     * @return mixed
     */
    public function getService($serviceName)
    {
        return $this->serviceContainer->getService($serviceName);
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectImageDeleteAfter($parameters)
    {
        $image = $parameters['object'];
        if (isset($image->id_product)) {
            $this->sendLiveSync('products', $image->id_product, 'delete');
            $this->insertIncrementalSyncObject(
                $image->id_product,
                Config::COLLECTION_PRODUCTS,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectImageAddAfter($parameters)
    {
        $image = $parameters['object'];
        if (isset($image->id_product)) {
            $this->sendLiveSync('products', $image->id_product, 'upsert');
            $this->insertIncrementalSyncObject(
                $image->id_product,
                Config::COLLECTION_PRODUCTS,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectImageUpdateAfter($parameters)
    {
        $image = $parameters['object'];
        if (isset($image->id_product)) {
            $this->sendLiveSync('products', $image->id_product, 'upsert');
            $this->insertIncrementalSyncObject(
                $image->id_product,
                Config::COLLECTION_PRODUCTS,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectLanguageDeleteAfter($parameters)
    {
        $language = $parameters['object'];
        if (isset($language->id)) {
            $this->sendLiveSync('languages', $language->id, 'delete');
            $this->insertDeletedObject(
                $language->id,
                Config::COLLECTION_LANGUAGES,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectLanguageAddAfter($parameters)
    {
        $language = $parameters['object'];
        if (isset($language->id) && isset($language->id_product)) {
            $this->sendLiveSync('languages', $language->id_product, 'upsert');
            $this->insertIncrementalSyncObject(
                $language->id,
                Config::COLLECTION_LANGUAGES,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectLanguageUpdateAfter($parameters)
    {
        $language = $parameters['object'];
        if (isset($language->id) && isset($language->id_product)) {
            $this->sendLiveSync('languages', $language->id_product, 'upsert');
            $this->insertIncrementalSyncObject(
                $language->id,
                Config::COLLECTION_LANGUAGES,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectManufacturerDeleteAfter($parameters)
    {
        $manufacturer = $parameters['object'];
        if (isset($manufacturer->id)) {
            $this->sendLiveSync('manufacturers', $manufacturer->id, 'delete');
            $this->insertDeletedObject(
                $manufacturer->id,
                Config::COLLECTION_MANUFACTURERS,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectManufacturerAddAfter($parameters)
    {
        $manufacturer = $parameters['object'];
        if (isset($manufacturer->id)) {
            $this->sendLiveSync('manufacturers', $manufacturer->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $manufacturer->id,
                Config::COLLECTION_MANUFACTURERS,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectManufacturerUpdateAfter($parameters)
    {
        $manufacturer = $parameters['object'];
        if (isset($manufacturer->id)) {
            $this->sendLiveSync('manufacturers', $manufacturer->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $manufacturer->id,
                Config::COLLECTION_MANUFACTURERS,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectSupplierDeleteAfter($parameters)
    {
        $supplier = $parameters['object'];
        if (isset($supplier->id)) {
            $this->sendLiveSync('suppliers', $supplier->id, 'delete');
            $this->insertDeletedObject(
                $supplier->id,
                Config::COLLECTION_SUPPLIERS,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectSupplierAddAfter($parameters)
    {
        $supplier = $parameters['object'];
        if (isset($supplier->id)) {
            $this->sendLiveSync('suppliers', $supplier->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $supplier->id,
                Config::COLLECTION_SUPPLIERS,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectSupplierUpdateAfter($parameters)
    {
        $supplier = $parameters['object'];
        if (isset($supplier->id)) {
            $this->sendLiveSync('suppliers', $supplier->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $supplier->id,
                Config::COLLECTION_SUPPLIERS,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectProductDeleteAfter($parameters)
    {
        $product = $parameters['object'];

        if (isset($product->id)) {
            $this->sendLiveSync('products', $product->id, 'delete');
            $this->insertDeletedObject(
                $product->id,
                Config::COLLECTION_PRODUCTS,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectProductAddAfter($parameters)
    {
        $product = $parameters['object'];
        if (isset($product->id)) {
            $this->sendLiveSync('products', $product->id, 'upsert');
            $this->sendLiveSync('custom-product-carriers', $product->id, 'upsert');
            $this->sendLiveSync('stocks', $product->id, 'upsert');

            $this->insertIncrementalSyncObject(
                $product->id,
                Config::COLLECTION_PRODUCTS,
                date(DATE_ATOM),
                $this->shopId,
                true
            );

            $this->insertIncrementalSyncObject(
                $product->id,
                Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS,
                date(DATE_ATOM),
                $this->shopId,
                false
            );

            $this->insertIncrementalSyncObject(
                $product->id,
                Config::COLLECTION_STOCKS,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectProductUpdateAfter($parameters)
    {
        /** @var Product $product */
        $product = $parameters['object'];

        if (isset($product->id)) {
            $this->sendLiveSync('products', $product->id, 'upsert');
            $this->sendLiveSync('custom-product-carriers', $product->id, 'upsert');
            $this->sendLiveSync('stocks', $product->id, 'upsert');

            $this->insertIncrementalSyncObject(
                $product->id,
                Config::COLLECTION_PRODUCTS,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
            $this->insertIncrementalSyncObject(
                $product->id,
                Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
            $this->insertIncrementalSyncObject(
                $product->id,
                Config::COLLECTION_STOCKS,
                date(DATE_ATOM),
                $this->shopId,
                false
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectWishlistDeleteAfter($parameters)
    {
        $wishlist = $parameters['object'];
        if (isset($wishlist->id)) {
            $this->sendLiveSync('wishlists', $wishlist->id, 'delete');
            $this->insertDeletedObject(
                $wishlist->id,
                Config::COLLECTION_WISHLISTS,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectWishlistAddAfter($parameters)
    {
        $wishlist = $parameters['object'];
        if (isset($wishlist->id)) {
            $this->sendLiveSync('wishlists', $wishlist->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $wishlist->id,
                Config::COLLECTION_WISHLISTS,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectWishlistUpdateAfter($parameters)
    {
        $wishlist = $parameters['object'];
        if (isset($wishlist->id)) {
            $this->sendLiveSync('wishlists', $wishlist->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $wishlist->id,
                Config::COLLECTION_WISHLISTS,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectStockAddAfter($parameters)
    {
        $stock = $parameters['object'];
        if (isset($stock->id)) {
            $this->sendLiveSync('stocks', $stock->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $stock->id,
                Config::COLLECTION_STOCKS,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectStockUpdateAfter($parameters)
    {
        $stock = $parameters['object'];
        if (isset($stock->id)) {
            $this->sendLiveSync('stocks', $stock->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $stock->id,
                Config::COLLECTION_STOCKS,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectStoreDeleteAfter($parameters)
    {
        $product = $parameters['object'];
        if (isset($product->id)) {
            $this->sendLiveSync('stores', $product->id, 'delete');
            $this->insertDeletedObject(
                $product->id,
                Config::COLLECTION_STORES,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectStoreAddAfter($parameters)
    {
        $product = $parameters['object'];
        if (isset($product->id)) {
            $this->sendLiveSync('stores', $product->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $product->id,
                Config::COLLECTION_STORES,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectStoreUpdateAfter($parameters)
    {
        $store = $parameters['object'];
        if (isset($store->id)) {
            $this->sendLiveSync('stores', $store->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $store->id,
                Config::COLLECTION_STORES,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCombinationDeleteAfter($parameters)
    {
        /** @var Combination $combination */
        $combination = $parameters['object'];

        if (isset($combination->id)) {
            $this->sendLiveSync('products', $combination->id, 'delete');
            $this->insertDeletedObject(
                $combination->id,
                Config::COLLECTION_PRODUCT_ATTRIBUTES,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCategoryAddAfter($parameters)
    {
        $category = $parameters['object'];

        if (isset($category->id)) {
            $this->sendLiveSync('categories', $category->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $category->id,
                Config::COLLECTION_CATEGORIES,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCategoryUpdateAfter($parameters)
    {
        $category = $parameters['object'];

        if (isset($category->id)) {
            $this->sendLiveSync('categories', $category->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $category->id,
                Config::COLLECTION_CATEGORIES,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCategoryDeleteAfter($parameters)
    {
        $category = $parameters['object'];

        if (isset($category->id)) {
            $this->sendLiveSync('categories', $category->id, 'delete');
            $this->insertDeletedObject(
                $category->id,
                Config::COLLECTION_CATEGORIES,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCustomerAddAfter($parameters)
    {
        $customer = $parameters['object'];

        if (isset($customer->id)) {
            $this->sendLiveSync('customers', $customer->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $customer->id,
                Config::COLLECTION_CUSTOMERS,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCustomerUpdateAfter($parameters)
    {
        $customer = $parameters['object'];

        if (isset($customer->id)) {
            $this->sendLiveSync('customers', $customer->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $customer->id,
                Config::COLLECTION_CUSTOMERS,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCustomerDeleteAfter($parameters)
    {
        $customer = $parameters['object'];

        if (isset($customer->id)) {
            $this->sendLiveSync('customers', $customer->id, 'delete');
            $this->insertDeletedObject(
                $customer->id,
                Config::COLLECTION_CUSTOMERS,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCurrencyAddAfter($parameters)
    {
        $currency = $parameters['object'];

        if (isset($currency->id)) {
            $this->sendLiveSync('currencies', $currency->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $currency->id,
                Config::COLLECTION_CURRENCIES,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCurrencyUpdateAfter($parameters)
    {
        $currency = $parameters['object'];

        if (isset($currency->id)) {
            $this->sendLiveSync('currencies', $currency->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $currency->id,
                Config::COLLECTION_CURRENCIES,
                date(DATE_ATOM),
                $this->shopId,
                true
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCartAddAfter($parameters)
    {
        $cart = $parameters['object'];

        if (isset($cart->id)) {
            $this->sendLiveSync('carts', $cart->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $cart->id,
                Config::COLLECTION_CARTS,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCartUpdateAfter($parameters)
    {
        $cart = $parameters['object'];

        if (isset($cart->id)) {
            $this->sendLiveSync('carts', $cart->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $cart->id,
                Config::COLLECTION_CARTS,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCartRuleAddAfter($parameters)
    {
        $cartRule = $parameters['object'];

        if (isset($cartRule->id)) {
            $this->sendLiveSync('cart_rules', $cartRule->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $cartRule->id,
                Config::COLLECTION_CART_RULES,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCartRuleDeleteAfter($parameters)
    {
        $cartRule = $parameters['object'];

        if (isset($cartRule->id)) {
            $this->sendLiveSync('cart_rules', $cartRule->id, 'delete');
            $this->insertIncrementalSyncObject(
                $cartRule->id,
                Config::COLLECTION_CART_RULES,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCartRuleUpdateAfter($parameters)
    {
        $cartRule = $parameters['object'];

        if (isset($cartRule->id)) {
            $this->sendLiveSync('cart_rules', $cartRule->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $cartRule->id,
                Config::COLLECTION_CART_RULES,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectOrderAddAfter($parameters)
    {
        $order = $parameters['object'];

        if (isset($order->id)) {
            $this->sendLiveSync('orders', $order->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $order->id,
                Config::COLLECTION_ORDERS,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectOrderUpdateAfter($parameters)
    {
        $order = $parameters['object'];

        if (isset($order->id)) {
            $this->sendLiveSync('orders', $order->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $order->id,
                Config::COLLECTION_ORDERS,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCarrierAddAfter($parameters)
    {
        /** @var Carrier $carrier */
        $carrier = $parameters['object'];

        if (isset($carrier->id)) {
            $this->sendLiveSync('carriers', $carrier->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $carrier->id,
                Config::COLLECTION_CARRIERS,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCarrierUpdateAfter($parameters)
    {
        /** @var Carrier $carrier */
        $carrier = $parameters['object'];

        if (isset($carrier->id)) {
            $this->sendLiveSync('carriers', $carrier->id, 'upsert');
            $this->insertIncrementalSyncObject(
                $carrier->id,
                Config::COLLECTION_CARRIERS,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCarrierDeleteAfter($parameters)
    {
        /** @var Carrier $carrier */
        $carrier = $parameters['object'];

        if (isset($carrier->id)) {
            $this->sendLiveSync('carriers', $carrier->id, 'delete');
            $this->insertIncrementalSyncObject(
                $carrier->id,
                Config::COLLECTION_CARRIERS,
                date(DATE_ATOM),
                $this->shopId
            );
        }
    }

    /**
     * @return void
     */
    public function hookActionObjectCountryAddAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectCountryUpdateAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectCountryDeleteAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectStateAddAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectStateUpdateAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectStateDeleteAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectZoneAddAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectZoneUpdateAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectZoneDeleteAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxAddAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxUpdateAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxDeleteAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxRulesGroupAddAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxRulesGroupUpdateAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxRulesGroupDeleteAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionShippingPreferencesPageSave()
    {
        $this->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectSpecificPriceAddAfter($parameters)
    {
        /** @var SpecificPrice $specificPrice */
        $specificPrice = $parameters['object'];

        if ($specificPrice instanceof SpecificPrice) {
            if (isset($specificPrice->id)) {
                $this->sendLiveSync('specific-prics', $specificPrice->id, 'upsert');
                $this->insertIncrementalSyncObject(
                    $specificPrice->id,
                    Config::COLLECTION_SPECIFIC_PRICES,
                    date(DATE_ATOM),
                    $this->shopId
                );
            }
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectSpecificPriceUpdateAfter($parameters)
    {
        /** @var SpecificPrice $specificPrice */
        $specificPrice = $parameters['object'];

        if ($specificPrice instanceof SpecificPrice) {
            if (isset($specificPrice->id)) {
                $this->sendLiveSync('specific-prics', $specificPrice->id, 'upsert');
                $this->insertIncrementalSyncObject(
                    $specificPrice->id,
                    Config::COLLECTION_SPECIFIC_PRICES,
                    date(DATE_ATOM),
                    $this->shopId
                );
            }
        }
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectSpecificPriceDeleteAfter($parameters)
    {
        /** @var SpecificPrice $specificPrice */
        $specificPrice = $parameters['object'];

        if ($specificPrice instanceof SpecificPrice) {
            if (isset($specificPrice->id)) {
                $this->sendLiveSync('specific-prics', $specificPrice->id, 'delete');
                $this->insertDeletedObject(
                    $specificPrice->id,
                    Config::COLLECTION_SPECIFIC_PRICES,
                    date(DATE_ATOM),
                    $this->shopId
                );
            }
        }
    }

    /**
     * @param string $shopContent
     * @param int $shopContentId
     * @param string $action
     *
     * @return void
     */
    private function sendLiveSync(string $shopContent, int $shopContentId, string $action)
    {
        if ((int) $shopContentId === 0) {
            return;
        }

        /** @var \PrestaShop\Module\PsEventbus\Service\SynchronizationService $synchronizationService */
        $synchronizationService = $this->getService(PrestaShop\Module\PsEventbus\Service\SynchronizationService::class);

        if ($synchronizationService->debounceLiveSync($shopContent)) {
            try {
                /** @var \PrestaShop\Module\PsEventbus\Api\LiveSyncApiClient $liveSyncApiClient */
                $liveSyncApiClient = $this->getService(\PrestaShop\Module\PsEventbus\Api\LiveSyncApiClient::class);
                $liveSyncApiClient->liveSync($shopContent, (int) $shopContentId, $action);
            } catch (\Exception $e) {
            }
        }
    }

    /**
     * @param int $objectId
     * @param string $type
     * @param string $date
     * @param int $shopId
     * @param bool $hasMultiLang
     *
     * @return void
     */
    private function insertIncrementalSyncObject($objectId, $type, $date, $shopId, $hasMultiLang = false)
    {
        if ((int) $objectId === 0) {
            return;
        }

        /** @var \PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository $incrementalSyncRepository */
        $incrementalSyncRepository = $this->getService(
            \PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository::class
        );

        /** @var \PrestaShop\Module\PsEventbus\Repository\LanguageRepository $languageRepository */
        $languageRepository = $this->getService(
            \PrestaShop\Module\PsEventbus\Repository\LanguageRepository::class
        );

        if ($hasMultiLang) {
            $languagesIsoCodes = $languageRepository->getLanguagesIsoCodes();

            foreach ($languagesIsoCodes as $languagesIsoCode) {
                $incrementalSyncRepository->insertIncrementalObject($objectId, $type, $date, $shopId, $languagesIsoCode);
            }
        } else {
            $languagesIsoCode = $languageRepository->getDefaultLanguageIsoCode();

            $incrementalSyncRepository->insertIncrementalObject($objectId, $type, $date, $shopId, $languagesIsoCode);
        }
    }

    /**
     * @param int $objectId
     * @param string $type
     * @param string $date
     * @param int $shopId
     *
     * @return void
     */
    private function insertDeletedObject($objectId, $type, $date, $shopId)
    {
        if ((int) $objectId === 0) {
            return;
        }

        /** @var \PrestaShop\Module\PsEventbus\Repository\DeletedObjectsRepository $deletedObjectsRepository */
        $deletedObjectsRepository = $this->getService(
            \PrestaShop\Module\PsEventbus\Repository\DeletedObjectsRepository::class
        );

        /** @var \PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository $incrementalSyncRepository */
        $incrementalSyncRepository = $this->getService(
            \PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository::class
        );

        $deletedObjectsRepository->insertDeletedObject($objectId, $type, $date, $shopId);
        $incrementalSyncRepository->removeIncrementalSyncObject($type, $objectId);
    }

    /**
     * Set PHP compatibility to 7.1
     *
     * @return bool
     */
    private function isPhpVersionCompliant()
    {
        return PHP_VERSION_ID >= 70100;
    }
}
