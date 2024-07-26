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

use PrestaShop\Module\PsEventbus\Module\Install;
use PrestaShop\Module\PsEventbus\Module\Uninstall;
use PrestaShop\Module\PsEventbus\DependencyInjection\ServiceContainer;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Ps_eventbus extends Module
{
    // All hooks is here
    use PrestaShop\Module\PsEventbus\UseHooks;

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
     * @var ServiceContainer
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
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.8.0', '>=')) {
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

        require_once __DIR__ . '/vendor/autoload.php';

        if ($this->context->shop === null) {
            throw new PrestaShopException('No shop context');
        }

        $this->shopId = (int) $this->context->shop->id;
    }

    /**
     * @return Context
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

        $installer = new Install($this, Db::getInstance());

        return $installer->installDatabaseTables()
            && parent::install()
            && $this->registerHook($this->getHooks());
    }

    /**
     * @return bool
     */
    public function uninstall()
    {
        $uninstaller = new Uninstall($this, Db::getInstance());

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
     * @return PrestaShop\Module\PsEventbus\DependencyInjection\ServiceContainer
     *
     * @throws Exception
     */
    public function getServiceContainer()
    {
        if (null === $this->serviceContainer) {
            // append version number to force cache generation (1.6 Core won't clear it)
            $this->serviceContainer = new PrestaShop\Module\PsEventbus\DependencyInjection\ServiceContainer(
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
     * Set PHP compatibility to 7.1
     *
     * @return bool
     */
    private function isPhpVersionCompliant()
    {
        return PHP_VERSION_ID >= 50600;
    }
}
