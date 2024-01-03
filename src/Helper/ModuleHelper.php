<?php

namespace PrestaShop\Module\PsEventbus\Helper;

use PrestaShopBundle\Service\Routing\Router;

class ModuleHelper
{
    /** @var \Ps_eventbus */
    private $module;

    public function __construct(\Ps_eventbus $module)
    {
        $this->module = $module;
    }

    /**
     * @param string $moduleName
     *
     * @return bool
     */
    public function isInstalled(string $moduleName)
    {
        return \ModuleCore::isInstalled($moduleName);
    }

    /**
     * @param string $moduleName
     *
     * @return bool
     */
    public function isEnabled(string $moduleName)
    {
        return \ModuleCore::isEnabled($moduleName);
    }

    /**
     * @param string $moduleName
     *
     * @return string
     */
    public function getDisplayName(string $moduleName)
    {
        if (false === $this->isInstalled($moduleName)) {
            return '';
        }

        $module = \Module::getInstanceByName($moduleName);

        if (false === $module) {
            return '';
        }

        return $module->displayName;
    }

    /**
     * @param string $moduleName
     *
     * @return false|\ModuleCore
     */
    public function getInstanceByName(string $moduleName)
    {
        return \ModuleCore::getInstanceByName($moduleName);
    }

    /**
     * returns the installation link of the module if it is not installed. If installed, returns an empty string
     *
     * @param string $moduleName
     *
     * @return string
     */
    public function getInstallLink(string $moduleName)
    {
        if (true === $this->isInstalled($moduleName)) {
            return '';
        }
        /** @var Router $router * */
        $router = $this->module->get('router');

        if ($moduleName === 'ps_mbo') {
            return substr(\Tools::getShopDomainSsl(true) . __PS_BASE_URI__, 0, -1) .
            $router->generate('ps_eventbus_api_resolver', [
                'query' => 'installPsMbo',
            ]);
        }

        return substr(\Tools::getShopDomainSsl(true) . __PS_BASE_URI__, 0, -1) .
            $router->generate('admin_module_manage_action', [
                'action' => 'install',
                'module_name' => $moduleName,
            ]);
    }

    /**
     * returns the enable link of the module if it is not enabled. If enabled, returns an empty string
     *
     * @param string $moduleName
     *
     * @return string
     */
    public function getEnableLink(string $moduleName)
    {
        if (true === $this->isEnabled($moduleName)) {
            return '';
        }

        /** @var Router $router * */
        $router = $this->module->get('router');

        return substr(\Tools::getShopDomainSsl(true) . __PS_BASE_URI__, 0, -1) .
            $router->generate('admin_module_manage_action', [
                'action' => 'enable',
                'module_name' => $moduleName,
            ]);
    }

    /**
     * returns the update link of the module if it is not enabled. If enabled, returns an empty string
     *
     * @param string $moduleName
     *
     * @return string
     */
    public function getUpdateLink(string $moduleName)
    {
        /** @var Router $router * */
        $router = $this->module->get('router');

        return substr(\Tools::getShopDomainSsl(true) . __PS_BASE_URI__, 0, -1) .
            $router->generate('admin_module_manage_action', [
                'action' => 'upgrade',
                'module_name' => $moduleName,
            ]);
    }

    /**
     * get ps_analytics module version
     *
     * @param string $moduleName
     *
     * @return string
     */
    public function getModuleVersion(string $moduleName)
    {
        if (false === $this->isInstalled($moduleName)) {
            return '0.0.0';
        }

        $module = \Module::getInstanceByName($moduleName);

        if (false === $module) {
            return '0.0.0';
        }

        return $module->version;
    }

    /**
     * Build informations about module
     *
     * @param string $moduleName
     *
     * @return array
     */
    public function buildModuleInformation(string $moduleName)
    {
        return [
            'technicalName' => $moduleName,
            'displayName' => $this->getDisplayName($moduleName),
            'isInstalled' => $this->isInstalled($moduleName),
            'isEnabled' => $this->isEnabled($moduleName),
            'linkInstall' => $this->getInstallLink($moduleName),
            'linkEnable' => $this->getEnableLink($moduleName),
            'linkUpdate' => $this->getUpdateLink($moduleName),
        ];
    }
}
