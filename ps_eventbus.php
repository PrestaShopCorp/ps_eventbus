<?php

require_once __DIR__ . '/vendor/autoload.php';

if (!defined('_PS_VERSION_')) {
    exit;
}

class Ps_eventbus extends Module
{
    use PrestaShop\Module\PsEventbus\Traits\UseHooks;

    public $adminControllers;

    public $version;

    private $container;

    private $shopId;

    public $multistoreCompatibility;

    public $emailSupport;

    public $termsOfServiceUrl;

    public function __construct()
    {
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.8.0', '>=')) {
            $this->multistoreCompatibility = parent::MULTISTORE_COMPATIBILITY_YES;
        }

        $this->name = 'ps_eventbus';
        $this->tab = 'administration';
        $this->author = 'PrestaShop';
        $this->need_instance = 0;
        $this->bootstrap = true;
        $this->version = '0.0.0';
        $this->module_key = '7d76e08a13331c6c393755886ec8d5ce';

        parent::__construct();

        $this->emailSupport = 'cloudsync-support@prestashop.com';
        $this->termsOfServiceUrl = 'https://www.prestashop.com/en/prestashop-account-privacy';
        $this->displayName = $this->l('PrestaShop EventBus');
        $this->description = $this->l('Link your PrestaShop account to synchronize your shop data to a tech partner of your choice. Do not uninstall this module if you are already using a service, as it will prevent it from working.');
        $this->confirmUninstall = $this->l('This action will immediately prevent your PrestaShop services and Community services from working as they are using PrestaShop CloudSync for syncing.');
        $this->ps_versions_compliancy = ['min' => '1.6.1.11', 'max' => _PS_VERSION_];
        $this->adminControllers = [];

        if (!$this->isPhpVersionCompliant()) {
            return;
        }

        if ($this->context->shop === null) {
            throw new PrestaShopException('No shop context');
        }

        $this->shopId = (int) $this->context->shop->id;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function getAdminControllers()
    {
        return $this->adminControllers;
    }

    /**
     * @return void
     */
    public function getContent()
    {
        Tools::redirectAdmin(
            $this->context->link->getAdminLink('AdminPsEventbus')
        );
    }

    public function install()
    {
        if (!$this->isPhpVersionCompliant()) {
            $this->_errors[] = $this->l('This requires PHP 5.6 to work properly. Please upgrade your server configuration.');

            return defined('PS_INSTALLATION_IN_PROGRESS');
        }

        $installer = new PrestaShop\Module\PsEventbus\Module\Install($this, Db::getInstance());

        return $installer->installDatabaseTables()
            && parent::install()
            && $this->registerHook($this->getHooks())
            && $this->installTab();
    }

    /**
     * @return bool
     */
    private function installTab()
    {
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdminPsEventbus';
        $tab->name = array_fill_keys(
            array_column(Language::getLanguages(false), 'id_lang'),
            'EventBus'
        );
        $tab->id_parent = -1; // Hidden tab (accessible via getContent redirect)
        $tab->module = $this->name;

        return $tab->add();
    }

    public function uninstall()
    {
        $uninstaller = new PrestaShop\Module\PsEventbus\Module\Uninstall($this, Db::getInstance());

        return $uninstaller->uninstallMenu()
            && $uninstaller->uninstallDatabaseTables()
            && parent::uninstall();
    }

    public function getServiceContainer()
    {
        if (null === $this->container) {
            $this->container = PrestaShop\Module\PsEventbus\ServiceContainer\ServiceContainer::createInstance(
                __DIR__ . '/config.php'
            );
        }

        return $this->container;
    }

    public function getService($serviceName)
    {
        return $this->getServiceContainer()->getService($serviceName);
    }

    private function isPhpVersionCompliant()
    {
        return PHP_VERSION_ID >= 50600;
    }
}
