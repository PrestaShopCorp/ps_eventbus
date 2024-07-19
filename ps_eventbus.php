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
use PrestaShop\Module\PsEventbus\Module\Install;
use PrestaShop\Module\PsEventbus\Module\Uninstall;
use PrestaShop\Module\PsEventbus\Service\SynchronizationService;

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

class Ps_eventbus extends Module
{
    /**
     * @var array<mixed>
     */
    public $adminControllers;

    /**
     * @var string
     */
    const VERSION = '0.0.0';

    const DEFAULT_ENV = '';

    /**
     * @var array<mixed>
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
     * @var array<mixed>
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

        'actionObjectEmployeeAddAfter',
        'actionObjectEmployeeDeleteAfter',
        'actionObjectEmployeeUpdateAfter',

        'actionDispatcherBefore',
    ];

    /**
     * @var \PrestaShop\Module\PsEventbus\DependencyInjection\ServiceContainer
     */
    private $serviceContainer;

    /**
     * @var int the unique shop identifier (uuid v4)
     */
    private $shopId;

    /**
     * @var int Defines the multistore compatibility level of the module
     */
    public $multistoreCompatibility;

    /**
     * @var string contact email of the maintainers (please consider using github issues)
     */
    public $emailSupport;

    /**
     * @var string available terms of services
     */
    public $termsOfServiceUrl;

    /**
     * __construct.
     */
    public function __construct()
    {
        if (version_compare(_PS_VERSION_, '1.7.8.0', '>=')) {
            $this->multistoreCompatibility = parent::MULTISTORE_COMPATIBILITY_YES;
        }

        // @see https://devdocs.prestashop-project.org/8/modules/concepts/module-class/
        $this->name = 'ps_eventbus';
        $this->tab = 'administration';
        $this->author = 'PrestaShop';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->version = '0.0.0';
        $this->module_key = '7d76e08a13331c6c393755886ec8d5ce';

        parent::__construct();

        $this->emailSupport = 'cloudsync-support@prestashop.com';
        $this->termsOfServiceUrl =
            'https://www.prestashop.com/en/prestashop-account-privacy';
        $this->displayName = $this->l('PrestaShop EventBus');
        $this->description = $this->l('Link your PrestaShop account to synchronize your shop data to a tech partner of your choice. Do not uninstall this module if you are already using a service, as it will prevent it from working.');
        $this->confirmUninstall = $this->l('This action will immediately prevent your PrestaShop services and Community services from working as they are using PrestaShop CloudSync for syncing.');
        $this->ps_versions_compliancy = ['min' => '1.6', 'max' => _PS_VERSION_];
        $this->adminControllers = [];
        // If PHP is not compliant, we will not load composer and the autoloader
        if (!$this->isPhpVersionCompliant()) {
            return;
        }

        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
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
     * @return array<mixed>
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
            $this->_errors[] = $this->l('This requires PHP 5.6 to work properly. Please upgrade your server configuration.');

            // We return true during the installation of PrestaShop to not stop the whole process,
            // Otherwise we warn properly the installation failed.
            return defined('PS_INSTALLATION_IN_PROGRESS');
        }

        $installer = new Install($this, \Db::getInstance());

        return $installer->installDatabaseTables()
            && parent::install()
            && $this->registerHook($this->hookToInstall);
    }

    /**
     * @return bool
     */
    public function uninstall()
    {
        $uninstaller = new Uninstall($this, \Db::getInstance());

        return $uninstaller->uninstallMenu()
            && $uninstaller->uninstallDatabaseTables()
            && parent::uninstall();
    }

    /**
     * @return string
     */
    public function getModuleEnvVar()
    {
        return strtoupper((string) $this->name) . '_ENV';
    }

    /**
     * @param string $default
     *
     * @return string
     */
    public function getModuleEnv($default = null)
    {
        return getenv($this->getModuleEnvVar()) ?: $default ?: self::DEFAULT_ENV;
    }

    /**
     * @return \PrestaShop\Module\PsEventbus\DependencyInjection\ServiceContainer
     *
     * @throws Exception
     */
    public function getServiceContainer()
    {
        if (null === $this->serviceContainer) {
            // append version number to force cache generation (1.6 Core won't clear it)
            $this->serviceContainer = new \PrestaShop\Module\PsEventbus\DependencyInjection\ServiceContainer(
                $this->name . str_replace(['.', '-', '+'], '', $this->version),
                $this->getLocalPath(),
                $this->getModuleEnv()
            );
        }

        return $this->serviceContainer;
    }

    /**
     * This function allows you to patch bugs that can be found related to "ServiceNotFoundException".
     * It ensures that you have access to the SymfonyContainer, and also that you have access to FO services.
     *
     * @param string $serviceName
     *
     * @return mixed
     */
    public function getService($serviceName)
    {
        return $this->getServiceContainer()->getService($serviceName);
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return void
     */
    public function hookActionObjectImageDeleteAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $image = $parameters['object'];

        if (isset($image->id_product)) {
            $synchronizationService->sendLiveSync('products', $image->id_product, 'delete');
            $synchronizationService->insertIncrementalSyncObject(
                $image->id_product,
                Config::COLLECTION_PRODUCTS,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $image = $parameters['object'];
        if (isset($image->id_product)) {
            $synchronizationService->sendLiveSync('products', $image->id_product, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $image->id_product,
                Config::COLLECTION_PRODUCTS,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $image = $parameters['object'];
        if (isset($image->id_product)) {
            $synchronizationService->sendLiveSync('products', $image->id_product, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $image->id_product,
                Config::COLLECTION_PRODUCTS,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $language = $parameters['object'];
        if (isset($language->id)) {
            $synchronizationService->sendLiveSync('languages', $language->id, 'delete');
            $synchronizationService->insertDeletedObject(
                $language->id,
                Config::COLLECTION_LANGUAGES,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $language = $parameters['object'];
        if (isset($language->id) && isset($language->id_product)) {
            $synchronizationService->sendLiveSync('languages', $language->id_product, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $language->id,
                Config::COLLECTION_LANGUAGES,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $language = $parameters['object'];
        if (isset($language->id) && isset($language->id_product)) {
            $synchronizationService->sendLiveSync('languages', $language->id_product, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $language->id,
                Config::COLLECTION_LANGUAGES,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $manufacturer = $parameters['object'];
        if (isset($manufacturer->id)) {
            $synchronizationService->sendLiveSync('manufacturers', $manufacturer->id, 'delete');
            $synchronizationService->insertDeletedObject(
                $manufacturer->id,
                Config::COLLECTION_MANUFACTURERS,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $manufacturer = $parameters['object'];
        if (isset($manufacturer->id)) {
            $synchronizationService->sendLiveSync('manufacturers', $manufacturer->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $manufacturer->id,
                Config::COLLECTION_MANUFACTURERS,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $manufacturer = $parameters['object'];
        if (isset($manufacturer->id)) {
            $synchronizationService->sendLiveSync('manufacturers', $manufacturer->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $manufacturer->id,
                Config::COLLECTION_MANUFACTURERS,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $supplier = $parameters['object'];
        if (isset($supplier->id)) {
            $synchronizationService->sendLiveSync('suppliers', $supplier->id, 'delete');
            $synchronizationService->insertDeletedObject(
                $supplier->id,
                Config::COLLECTION_SUPPLIERS,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $supplier = $parameters['object'];
        if (isset($supplier->id)) {
            $synchronizationService->sendLiveSync('suppliers', $supplier->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $supplier->id,
                Config::COLLECTION_SUPPLIERS,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $supplier = $parameters['object'];
        if (isset($supplier->id)) {
            $synchronizationService->sendLiveSync('suppliers', $supplier->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $supplier->id,
                Config::COLLECTION_SUPPLIERS,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $product = $parameters['object'];

        if (isset($product->id)) {
            $synchronizationService->sendLiveSync('products', $product->id, 'delete');
            $synchronizationService->insertDeletedObject(
                $product->id,
                Config::COLLECTION_PRODUCTS,
                date(DATE_ATOM),
                $this->shopId
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $product = $parameters['object'];
        if (isset($product->id)) {
            $synchronizationService->sendLiveSync('products', $product->id, 'upsert');
            $synchronizationService->sendLiveSync('custom-product-carriers', $product->id, 'upsert');
            $synchronizationService->sendLiveSync('stocks', $product->id, 'upsert');

            $synchronizationService->insertIncrementalSyncObject(
                $product->id,
                Config::COLLECTION_PRODUCTS,
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
    public function hookActionObjectProductUpdateAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        /** @var Product $product */
        $product = $parameters['object'];

        if (isset($product->id)) {
            $synchronizationService->sendLiveSync('products', $product->id, 'upsert');
            $synchronizationService->sendLiveSync('custom-product-carriers', $product->id, 'upsert');
            $synchronizationService->sendLiveSync('stocks', $product->id, 'upsert');

            $synchronizationService->insertIncrementalSyncObject(
                $product->id,
                Config::COLLECTION_PRODUCTS,
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
    public function hookActionObjectWishlistDeleteAfter($parameters)
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $wishlist = $parameters['object'];
        if (isset($wishlist->id)) {
            $synchronizationService->sendLiveSync('wishlists', $wishlist->id, 'delete');
            $synchronizationService->insertDeletedObject(
                $wishlist->id,
                Config::COLLECTION_WISHLISTS,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $wishlist = $parameters['object'];
        if (isset($wishlist->id)) {
            $synchronizationService->sendLiveSync('wishlists', $wishlist->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $wishlist->id,
                Config::COLLECTION_WISHLISTS,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $wishlist = $parameters['object'];
        if (isset($wishlist->id)) {
            $synchronizationService->sendLiveSync('wishlists', $wishlist->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $wishlist->id,
                Config::COLLECTION_WISHLISTS,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $stock = $parameters['object'];
        if (isset($stock->id)) {
            $synchronizationService->sendLiveSync('stocks', $stock->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $stock->id,
                Config::COLLECTION_STOCKS,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $stock = $parameters['object'];
        if (isset($stock->id)) {
            $synchronizationService->sendLiveSync('stocks', $stock->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $stock->id,
                Config::COLLECTION_STOCKS,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $product = $parameters['object'];
        if (isset($product->id)) {
            $synchronizationService->sendLiveSync('stores', $product->id, 'delete');
            $synchronizationService->insertDeletedObject(
                $product->id,
                Config::COLLECTION_STORES,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $product = $parameters['object'];
        if (isset($product->id)) {
            $synchronizationService->sendLiveSync('stores', $product->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $product->id,
                Config::COLLECTION_STORES,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $store = $parameters['object'];
        if (isset($store->id)) {
            $synchronizationService->sendLiveSync('stores', $store->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $store->id,
                Config::COLLECTION_STORES,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        /** @var Combination $combination */
        $combination = $parameters['object'];

        if (isset($combination->id)) {
            $synchronizationService->sendLiveSync('products', $combination->id, 'delete');
            $synchronizationService->insertDeletedObject(
                $combination->id,
                Config::COLLECTION_PRODUCT_ATTRIBUTES,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $category = $parameters['object'];

        if (isset($category->id)) {
            $synchronizationService->sendLiveSync('categories', $category->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $category->id,
                Config::COLLECTION_CATEGORIES,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $category = $parameters['object'];

        if (isset($category->id)) {
            $synchronizationService->sendLiveSync('categories', $category->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $category->id,
                Config::COLLECTION_CATEGORIES,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $category = $parameters['object'];

        if (isset($category->id)) {
            $synchronizationService->sendLiveSync('categories', $category->id, 'delete');
            $synchronizationService->insertDeletedObject(
                $category->id,
                Config::COLLECTION_CATEGORIES,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $customer = $parameters['object'];

        if (isset($customer->id)) {
            $synchronizationService->sendLiveSync('customers', $customer->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $customer->id,
                Config::COLLECTION_CUSTOMERS,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $customer = $parameters['object'];

        if (isset($customer->id)) {
            $synchronizationService->sendLiveSync('customers', $customer->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $customer->id,
                Config::COLLECTION_CUSTOMERS,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $customer = $parameters['object'];

        if (isset($customer->id)) {
            $synchronizationService->sendLiveSync('customers', $customer->id, 'delete');
            $synchronizationService->insertDeletedObject(
                $customer->id,
                Config::COLLECTION_CUSTOMERS,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $currency = $parameters['object'];

        if (isset($currency->id)) {
            $synchronizationService->sendLiveSync('currencies', $currency->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $currency->id,
                Config::COLLECTION_CURRENCIES,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $currency = $parameters['object'];

        if (isset($currency->id)) {
            $synchronizationService->sendLiveSync('currencies', $currency->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $currency->id,
                Config::COLLECTION_CURRENCIES,
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $currency = $parameters['object'];

        if (isset($currency->id)) {
            $synchronizationService->sendLiveSync('currencies', $currency->id, 'delete');
            $synchronizationService->insertDeletedObject(
                $currency->id,
                Config::COLLECTION_CURRENCIES,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $cart = $parameters['object'];

        if (isset($cart->id)) {
            $synchronizationService->sendLiveSync('carts', $cart->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $cart->id,
                Config::COLLECTION_CARTS,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $cart = $parameters['object'];

        if (isset($cart->id)) {
            $synchronizationService->sendLiveSync('carts', $cart->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $cart->id,
                Config::COLLECTION_CARTS,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $cartRule = $parameters['object'];

        if (isset($cartRule->id)) {
            $synchronizationService->sendLiveSync('cart_rules', $cartRule->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $cartRule->id,
                Config::COLLECTION_CART_RULES,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $cartRule = $parameters['object'];

        if (isset($cartRule->id)) {
            $synchronizationService->sendLiveSync('cart_rules', $cartRule->id, 'delete');
            $synchronizationService->insertIncrementalSyncObject(
                $cartRule->id,
                Config::COLLECTION_CART_RULES,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $cartRule = $parameters['object'];

        if (isset($cartRule->id)) {
            $synchronizationService->sendLiveSync('cart_rules', $cartRule->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $cartRule->id,
                Config::COLLECTION_CART_RULES,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $order = $parameters['object'];

        if (isset($order->id)) {
            $synchronizationService->sendLiveSync('orders', $order->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $order->id,
                Config::COLLECTION_ORDERS,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $order = $parameters['object'];

        if (isset($order->id)) {
            $synchronizationService->sendLiveSync('orders', $order->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $order->id,
                Config::COLLECTION_ORDERS,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        /** @var Carrier $carrier */
        $carrier = $parameters['object'];

        if (isset($carrier->id)) {
            $synchronizationService->sendLiveSync('carriers', $carrier->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $carrier->id,
                Config::COLLECTION_CARRIERS,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        /** @var Carrier $carrier */
        $carrier = $parameters['object'];

        if (isset($carrier->id)) {
            $synchronizationService->sendLiveSync('carriers', $carrier->id, 'upsert');
            $synchronizationService->insertIncrementalSyncObject(
                $carrier->id,
                Config::COLLECTION_CARRIERS,
                date(DATE_ATOM),
                $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        /** @var Carrier $carrier */
        $carrier = $parameters['object'];

        if (isset($carrier->id)) {
            $synchronizationService->sendLiveSync('carriers', $carrier->id, 'delete');
            $synchronizationService->insertIncrementalSyncObject(
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
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
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectEmployeeAddAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_EMPLOYEES,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectEmployeeDeleteAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');
        $synchronizationService->insertDeletedObject(
            0,
            Config::COLLECTION_EMPLOYEES,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectEmployeeUpdateAfter()
    {
        /** @var SynchronizationService $synchronizationService * */
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        $synchronizationService->insertIncrementalSyncObject(
            0,
            Config::COLLECTION_EMPLOYEES,
            date(DATE_ATOM),
            $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

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
                    $synchronizationService->insertIncrementalSyncObject(
                        0,
                        Config::COLLECTION_TRANSLATIONS,
                        date(DATE_ATOM),
                        $this->shopId
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        /** @var SpecificPrice $specificPrice */
        $specificPrice = $parameters['object'];

        if ($specificPrice instanceof SpecificPrice) {
            if (isset($specificPrice->id)) {
                $synchronizationService->sendLiveSync('specific-prices', $specificPrice->id, 'upsert');
                $synchronizationService->insertIncrementalSyncObject(
                    $specificPrice->id,
                    Config::COLLECTION_SPECIFIC_PRICES,
                    date(DATE_ATOM),
                    $this->shopId
                );
            }
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        /** @var SpecificPrice $specificPrice */
        $specificPrice = $parameters['object'];

        if ($specificPrice instanceof SpecificPrice) {
            if (isset($specificPrice->id)) {
                $synchronizationService->sendLiveSync('specific-prices', $specificPrice->id, 'upsert');
                $synchronizationService->insertIncrementalSyncObject(
                    $specificPrice->id,
                    Config::COLLECTION_SPECIFIC_PRICES,
                    date(DATE_ATOM),
                    $this->shopId
                );
            }
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
        $synchronizationService = $this->getService('PrestaShop\Module\PsEventbus\Service\SynchronizationService');

        /** @var SpecificPrice $specificPrice */
        $specificPrice = $parameters['object'];

        if ($specificPrice instanceof SpecificPrice) {
            if (isset($specificPrice->id)) {
                $synchronizationService->sendLiveSync('specific-prices', $specificPrice->id, 'delete');
                $synchronizationService->insertDeletedObject(
                    $specificPrice->id,
                    Config::COLLECTION_SPECIFIC_PRICES,
                    date(DATE_ATOM),
                    $this->shopId
                );
            }
        }
    }

    /**
     * Set PHP compatibility to 7.1
     *
     * @return bool
     */
    private function isPhpVersionCompliant()
    {
        return PHP_VERSION_ID >= 50600;
    }
}
