<?php

/**
 * 2007-2020 PrestaShop.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2020 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
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
    const VERSION = 'x.y.z';

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
        'actionObjectProductAddAfter',
        'actionObjectProductUpdateAfter',
        'actionObjectProductDeleteAfter',
        'actionObjectCategoryAddAfter',
        'actionObjectCategoryUpdateAfter',
        'actionObjectCategoryDeleteAfter',
        'actionObjectCustomerAddAfter',
        'actionObjectCustomerUpdateAfter',
        'actionObjectCustomerDeleteAfter',
        'actionObjectCurrencyAddAfter',
        'actionObjectCurrencyUpdateAfter',
        'actionObjectOrderAddAfter',
        'actionObjectOrderUpdateAfter',
        'actionObjectCartAddAfter',
        'actionObjectCartUpdateAfter',
        'actionObjectCarrierAddAfter',
        'actionObjectCarrierUpdateAfter',
        'actionObjectCarrierDeleteAfter',
        'actionObjectCountryAddAfter',
        'actionObjectCountryUpdateAfter',
        'actionObjectCountryDeleteAfter',
        'actionObjectStateAddAfter',
        'actionObjectStateUpdateAfter',
        'actionObjectStateDeleteAfter',
        'actionObjectWishlistAddAfter',
        'actionObjectWishlistUpdateAfter',
        'actionObjectWishlistDeleteAfter',
        'actionObjectZoneAddAfter',
        'actionObjectZoneUpdateAfter',
        'actionObjectZoneDeleteAfter',
        'actionObjectTaxAddAfter',
        'actionObjectTaxUpdateAfter',
        'actionObjectTaxDeleteAfter',
        'actionObjectTaxRulesGroupAddAfter',
        'actionObjectTaxRulesGroupUpdateAfter',
        'actionObjectTaxRulesGroupDeleteAfter',
        'actionShippingPreferencesPageSave',
        'actionObjectSpecificPriceAddAfter',
        'actionObjectSpecificPriceUpdateAfter',
        'actionObjectSpecificPriceDeleteAfter',
        'actionObjectCombinationDeleteAfter',
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
        $this->version = 'x.y.z';
        $this->module_key = '7d76e08a13331c6c393755886ec8d5ce';

        parent::__construct();

        $this->displayName = $this->l('PrestaShop EventBus');
        $this->description = $this->l('Link your PrestaShop account to synchronize your shop data to a tech partner of your choice. Do not uninstall this module if you are already using a service, as it will prevent it from working.');
        $this->confirmUninstall = $this->l('This action will immediately prevent your PrestaShop services and Community services from working as they are using PrestaShop CloudSync for syncing.');
        $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_];
        $this->adminControllers = [];
        // If PHP is not compliant, we will not load composer and the autoloader
        if (!$this->isPhpVersionCompliant()) {
            return;
        }

        require_once __DIR__ . '/vendor/autoload.php';

        $this->serviceContainer = new \PrestaShop\ModuleLibServiceContainer\DependencyInjection\ServiceContainer(
            $this->name,
            $this->getLocalPath()
        );

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
            $this->_errors[] = $this->l('This requires PHP 7.2.5 to work properly. Please upgrade your server configuration.');

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
    public function hookActionObjectProductDeleteAfter($parameters)
    {
        $product = $parameters['object'];

        $this->insertDeletedObject(
            $product->id,
            Config::COLLECTION_PRODUCTS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectProductAddAfter($parameters)
    {
        $product = $parameters['object'];

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
        /** @var int $productId */
        $productId = $product->id;

        $this->insertIncrementalSyncObject(
            $productId,
            Config::COLLECTION_PRODUCTS,
            date(DATE_ATOM),
            $this->shopId,
            true
        );

        $this->insertIncrementalSyncObject(
            $productId,
            Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS,
            date(DATE_ATOM),
            $this->shopId,
            false
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectWishlistDeleteAfter($parameters)
    {
        $product = $parameters['object'];

        $this->insertDeletedObject(
            $product->id,
            Config::COLLECTION_WISHLISTS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectWishlistAddAfter($parameters)
    {
        $product = $parameters['object'];

        $this->insertIncrementalSyncObject(
            $product->id,
            Config::COLLECTION_WISHLISTS,
            date(DATE_ATOM),
            $this->shopId,
            true
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectWishlistUpdateAfter($parameters)
    {
        /** @var Wishlist $wishlist */
        $wishlist = $parameters['object'];
        /** @var int $wishlistId */
        $wishlistId = $wishlist->id;

        $this->insertIncrementalSyncObject(
            $wishlistId,
            Config::COLLECTION_WISHLISTS,
            date(DATE_ATOM),
            $this->shopId,
            true
        );
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
        /** @var int $combinationId */
        $combinationId = $combination->id;

        $this->insertDeletedObject(
            $combinationId,
            Config::COLLECTION_PRODUCT_ATTRIBUTES,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCategoryAddAfter($parameters)
    {
        $category = $parameters['object'];
        /** @var int $categoryId */
        $categoryId = $category->id;

        $this->insertIncrementalSyncObject(
            $categoryId,
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CATEGORIES,
            date(DATE_ATOM),
            $this->shopId,
            true
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCategoryUpdateAfter($parameters)
    {
        $category = $parameters['object'];
        /** @var int $categoryId */
        $categoryId = $category->id;

        $this->insertIncrementalSyncObject(
            $categoryId,
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CATEGORIES,
            date(DATE_ATOM),
            $this->shopId,
            true
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCategoryDeleteAfter($parameters)
    {
        $category = $parameters['object'];
        /** @var int $categoryId */
        $categoryId = $category->id;

        $this->insertDeletedObject(
            $categoryId,
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CATEGORIES,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCustomerAddAfter($parameters)
    {
        $customer = $parameters['object'];
        /** @var int $customerId */
        $customerId = $customer->id;

        $this->insertIncrementalSyncObject(
            $customerId,
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CUSTOMERS,
            date(DATE_ATOM),
            $this->shopId,
            true
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCustomerUpdateAfter($parameters)
    {
        $customer = $parameters['object'];
        /** @var int $customerId */
        $customerId = $customer->id;

        $this->insertIncrementalSyncObject(
            $customerId,
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CUSTOMERS,
            date(DATE_ATOM),
            $this->shopId,
            true
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCustomerDeleteAfter($parameters)
    {
        $customer = $parameters['object'];
        /** @var int $customerId */
        $customerId = $customer->id;

        $this->insertDeletedObject(
            $customerId,
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CUSTOMERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCurrencyAddAfter($parameters)
    {
        $currency = $parameters['object'];
        /** @var int $currencyId */
        $currencyId = $currency->id;

        $this->insertIncrementalSyncObject(
            $currencyId,
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CURRENCIES,
            date(DATE_ATOM),
            $this->shopId,
            true
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCurrencyUpdateAfter($parameters)
    {
        $currency = $parameters['object'];
        /** @var int $currencyId */
        $currencyId = $currency->id;

        $this->insertIncrementalSyncObject(
            $currencyId,
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CURRENCIES,
            date(DATE_ATOM),
            $this->shopId,
            true
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCartAddAfter($parameters)
    {
        $cart = $parameters['object'];
        /** @var int $cartId */
        $cartId = $cart->id;

        $this->insertIncrementalSyncObject(
            $cartId,
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARTS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectCartUpdateAfter($parameters)
    {
        $cart = $parameters['object'];
        /** @var int $cartId */
        $cartId = $cart->id;

        $this->insertIncrementalSyncObject(
            $cartId,
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARTS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectOrderAddAfter($parameters)
    {
        $order = $parameters['object'];
        /** @var int $orderId */
        $orderId = $order->id;

        $this->insertIncrementalSyncObject(
            $orderId,
            Config::COLLECTION_ORDERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectOrderUpdateAfter($parameters)
    {
        $order = $parameters['object'];
        /** @var int $orderId */
        $orderId = $order->id;

        $this->insertIncrementalSyncObject(
            $orderId,
            Config::COLLECTION_ORDERS,
            date(DATE_ATOM),
            $this->shopId
        );
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
        /** @var int $carrierId */
        $carrierId = $carrier->id;

        $this->insertIncrementalSyncObject(
            $carrierId,
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
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
        /** @var int $carrierId */
        $carrierId = $carrier->id;

        $this->insertIncrementalSyncObject(
            $carrierId,
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
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
        /** @var int $carrierId */
        $carrierId = $carrier->id;

        $this->insertIncrementalSyncObject(
            $carrierId,
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
            date(DATE_ATOM),
            $this->shopId
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectCountryAddAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
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
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
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
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
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
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
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
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
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
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
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
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
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
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
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
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
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
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
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
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
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
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
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
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
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
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
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
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
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
            PrestaShop\Module\PsEventbus\Config\Config::COLLECTION_CARRIERS,
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
            /** @var int $specificPriceId */
            $specificPriceId = $specificPrice->id;
            $this->insertIncrementalSyncObject(
                $specificPriceId,
                Config::COLLECTION_SPECIFIC_PRICES,
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
    public function hookActionObjectSpecificPriceUpdateAfter($parameters)
    {
        /** @var SpecificPrice $specificPrice */
        $specificPrice = $parameters['object'];

        if ($specificPrice instanceof SpecificPrice) {
            /** @var int $specificPriceId */
            $specificPriceId = $specificPrice->id;
            $this->insertIncrementalSyncObject(
                $specificPriceId,
                Config::COLLECTION_SPECIFIC_PRICES,
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
    public function hookActionObjectSpecificPriceDeleteAfter($parameters)
    {
        /** @var SpecificPrice $specificPrice */
        $specificPrice = $parameters['object'];

        if ($specificPrice instanceof SpecificPrice) {
            /** @var int $specificPriceId */
            $specificPriceId = $specificPrice->id;
            $this->insertDeletedObject(
                $specificPriceId,
                Config::COLLECTION_SPECIFIC_PRICES,
                date(DATE_ATOM),
                $this->shopId
            );
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
     * @return bool
     */
    private function isPhpVersionCompliant()
    {
        return PHP_VERSION_ID >= 70205;
    }
}
