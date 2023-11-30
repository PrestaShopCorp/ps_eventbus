<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class Ps_accounts extends Module
{
    /**
     * @var string
     */
    const VERSION = '0.0.0';

    /**
     * @var \PrestaShop\ModuleLibServiceContainer\DependencyInjection\ServiceContainer
     */
    private $serviceContainer;

    public function __construct()
    {
        $this->name = 'ps_accounts';
        $this->version = '42.0.0';
        $this->author = 'CloudSync team';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
          'min' => '1.6.1.24',
          'max' => '99.99.99',
        ];
        $this->bootstrap = false;

        parent::__construct();

        $this->displayName = $this->trans('PS Accounts Mock', [], 'Modules.Mymodule.Admin');
        $this->description = $this->trans('Mocking', [], 'Modules.Mymodule.Admin');
        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?', [], 'Modules.Mymodule.Admin');

        require_once __DIR__ . '/vendor/autoload.php';

        $this->serviceContainer = new \PrestaShop\ModuleLibServiceContainer\DependencyInjection\ServiceContainer(
            (string) $this->name,
            $this->getLocalPath()
        );
    }

    public function install()
    {
        if (parent::install() == false) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        if (parent::uninstall() == false) {
            return false;
        }

        return true;
    }

    public function getService($serviceName)
    {
        return $this->serviceContainer->getService($serviceName);
    }
}
