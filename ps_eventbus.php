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

use PrestaShop\Module\PsEventbus\DependencyInjection\ServiceContainer;
use PrestaShop\Module\PsEventbus\Module\Install;
use PrestaShop\Module\PsEventbus\Module\Uninstall;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

class Ps_eventbus extends Module
{
    // All hooks is here
    use PrestaShop\Module\PsEventbus\Traits\UseHooks;

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
        $this->ps_versions_compliancy = ['min' => '1.6.1.11', 'max' => _PS_VERSION_];
        $this->adminControllers = [];
        // If PHP is not compliant, we will not load composer and the autoloader
        if (!$this->isPhpVersionCompliant()) {
            return;
        }

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
     * @return ServiceContainer
     *
     * @throws Exception
     */
    public function getServiceContainer()
    {
        if (null === $this->serviceContainer) {
            // append version number to force cache generation (1.6 Core won't clear it)
            $this->serviceContainer = new ServiceContainer(
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
        try {
            return $this->getServiceContainer()->getService($serviceName);
        } catch (ServiceNotFoundException $exception) {
            if (method_exists($this, 'get')) {
                return $this->get($serviceName);
            }

            throw new ServiceNotFoundException($serviceName);
        }
    }

    /**
     * @param string $serviceName
     *
     * @return mixed
     */
    public function hasService($serviceName)
    {
        return $this->getServiceContainer()->hasService($serviceName);
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
