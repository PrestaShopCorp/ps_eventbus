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
if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

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
    ];

    /**
     * @var \PrestaShop\ModuleLibServiceContainer\DependencyInjection\ServiceContainer
     */
    private $serviceContainer;

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
        $this->version = '1.5.2';
        $this->module_key = '7d76e08a13331c6c393755886ec8d5ce';

        parent::__construct();

        $this->displayName = $this->l('PrestaShop Eventbus');
        $this->description = $this->l('Link your PrestaShop account to synchronize your shop\'s data to the partners you want . Don&#039;t uninstall this module if you are already using a service, as it will prevent it from working.');
        $this->confirmUninstall = $this->l('This action will prevent immediately your PrestaShop services and Community services from working as they are using PrestaShop Eventbus module for syncing.');
        $this->ps_versions_compliancy = ['min' => '1.6', 'max' => _PS_VERSION_];
        $this->adminControllers = [];
        $this->serviceContainer = new \PrestaShop\ModuleLibServiceContainer\DependencyInjection\ServiceContainer(
            $this->name,
            $this->getLocalPath()
        );
        $this->registerhook('actionObjectSpecificPriceDeleteAfter');
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
            'products',
            date(DATE_ATOM),
            $this->context->shop->id
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
            'products',
            date(DATE_ATOM),
            $this->context->shop->id,
            true
        );
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function hookActionObjectProductUpdateAfter($parameters)
    {
        $product = $parameters['object'];

        $this->insertIncrementalSyncObject(
            $product->id,
            'products',
            date(DATE_ATOM),
            $this->context->shop->id,
            true
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

        $this->insertIncrementalSyncObject(
            $category->id,
            'categories',
            date(DATE_ATOM),
            $this->context->shop->id,
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

        $this->insertIncrementalSyncObject(
            $category->id,
            'categories',
            date(DATE_ATOM),
            $this->context->shop->id,
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

        $this->insertDeletedObject(
            $category->id,
            'categories',
            date(DATE_ATOM),
            $this->context->shop->id
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

        $this->insertIncrementalSyncObject(
            $cart->id,
            'carts',
            date(DATE_ATOM),
            $this->context->shop->id
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

        $this->insertIncrementalSyncObject(
            $cart->id,
            'carts',
            date(DATE_ATOM),
            $this->context->shop->id
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

        $this->insertIncrementalSyncObject(
            $order->id,
            'orders',
            date(DATE_ATOM),
            $this->context->shop->id
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

        $this->insertIncrementalSyncObject(
            $order->id,
            'orders',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectCarrierAddAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectCarrierUpdateAfter($params)
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectCarrierDeleteAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectCountryAddAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectCountryUpdateAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectCountryDeleteAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectStateAddAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectStateUpdateAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectStateDeleteAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectZoneAddAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectZoneUpdateAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectZoneDeleteAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxAddAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxUpdateAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxDeleteAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxRulesGroupAddAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxRulesGroupUpdateAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectTaxRulesGroupDeleteAfter()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionShippingPreferencesPageSave()
    {
        $this->insertIncrementalSyncObject(
            0,
            'carrier',
            date(DATE_ATOM),
            $this->context->shop->id
        );
    }

    /**
     * @return void
     */
    public function hookActionObjectSpecificPriceAddAfter($params)
    {
        /** @var SpecificPrice $specificPrice */
        $specificPrice = $params['object'];
        if ($specificPrice instanceof SpecificPrice) {
            $this->insertIncrementalSyncObject(
                $specificPrice->id,
                'price',
                date(DATE_ATOM),
                $this->context->shop->id
            );
        }
    }

    /**
     * @return void
     */
    public function hookActionObjectSpecificPriceUpdateAfter($params)
    {
        /** @var SpecificPrice $specificPrice */
        $specificPrice = $params['object'];
        if ($specificPrice instanceof SpecificPrice) {
            $this->insertIncrementalSyncObject(
                $specificPrice->id,
                'price',
                date(DATE_ATOM),
                $this->context->shop->id
            );
        }
    }

    /**
     * @return void
     */
    public function hookActionObjectSpecificPriceDeleteAfter($params)
    {
        /** @var SpecificPrice $specificPrice */
        $specificPrice = $params['object'];
        if ($specificPrice instanceof SpecificPrice) {
            $this->insertDeletedObject(
                $specificPrice->id,
                'price',
                date(DATE_ATOM),
                $this->context->shop->id
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
     * @param int $id
     * @param string $type
     * @param string $date
     * @param int $shopId
     *
     * @return void
     */
    private function insertDeletedObject($id, $type, $date, $shopId)
    {
        /** @var \PrestaShop\Module\PsEventbus\Repository\DeletedObjectsRepository $deletedObjectsRepository */
        $deletedObjectsRepository = $this->getService(
            \PrestaShop\Module\PsEventbus\Repository\DeletedObjectsRepository::class
        );

        /** @var \PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository $incrementalSyncRepository */
        $incrementalSyncRepository = $this->getService(
            \PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository::class
        );

        $deletedObjectsRepository->insertDeletedObject($id, $type, $date, $shopId);
        $incrementalSyncRepository->removeIncrementalSyncObject($type, $id);
    }
}
