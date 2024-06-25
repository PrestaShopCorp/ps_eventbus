<?php

namespace PrestaShop\Module\PsEventbus\Helper;

use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder;
use PrestaShopBundle\Service\Routing\Router;

class ModuleHelper
{
    /**
     * @var \Ps_eventbus
     */
    private $module;

    /**
     * @var \PrestaShop\PrestaShop\Core\Module\ModuleManager|\PrestaShop\PrestaShop\Core\Addon\Module\ModuleManager
     */
    private $moduleManager;

    public function __construct(\Ps_eventbus $module)
    {
        $this->module = $module;

        $moduleManagerBuilder = null;

        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $moduleManagerBuilder = ModuleManagerBuilder::getInstance();
        }

        if (is_null($moduleManagerBuilder)) {
            return;
        }

        $this->moduleManager = $moduleManagerBuilder->build();
    }

    /**
     * returns the module install status
     *
     * @param string $moduleName
     *
     * @return bool|null
     */
    public function isInstalled(string $moduleName)
    {
        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            $module = \Module::getInstanceByName($moduleName);

            if ($module) {
                return true;
            }

            return null;
        }

        return $this->moduleManager->isInstalled($moduleName);
    }

    /**
     * returns the module enable status
     *
     * @param string $moduleName
     *
     * @return bool|null
     */
    public function isEnabled(string $moduleName)
    {
        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            $module = \Module::getInstanceByName($moduleName);

            if ($module && $module->active) {
                return true;
            }

            return null;
        }

        return $this->moduleManager->isEnabled($moduleName);
    }

    /**
     * @param string $moduleName
     *
     * @return bool
     */
    public function isInstalledAndActive(string $moduleName)
    {
        return $this->isInstalled($moduleName) && $this->isEnabled($moduleName);
    }

    /**
     * returns true/false when module is out/up to date, and null when ps_mbo is not installed
     *
     * @param string $moduleName
     *
     * @return bool|null
     */
    public function isUpToDate(string $moduleName)
    {
        $mboModule = \Module::getInstanceByName('ps_mbo');

        if ($mboModule == false) {
            return null;
        }

        try {
            $mboHelper = $mboModule->get('mbo.modules.helper');
        } catch (\Exception $e) {
            return null;
        }

        if ($mboHelper == false) {
            return null;
        }

        $moduleVersionInfos = $mboHelper->findForUpdates($moduleName);

        return $moduleVersionInfos['upgrade_available'];
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
     * returns the display name of the module
     *
     * @param string $moduleName
     *
     * @return string
     */
    public function getDisplayName(string $moduleName)
    {
        if (false === $this->isInstalled($moduleName)) {
            return '';
        }

        $module = $this->getInstanceByName($moduleName);

        if (false === $module) {
            return '';
        }

        return $module->displayName;
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
     * returns the update link of the module
     *
     * @param string $moduleName
     *
     * @return string
     */
    public function getUpdateLink(string $moduleName)
    {
        // need to check if module is up to date, if not, return empty string

        /** @var Router $router * */
        $router = $this->module->get('router');

        return substr(\Tools::getShopDomainSsl(true) . __PS_BASE_URI__, 0, -1) .
            $router->generate('admin_module_manage_action', [
                'action' => 'upgrade',
                'module_name' => $moduleName,
            ]);
    }

    /**
     * get module version
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
            'isUpToDate' => $this->isUpToDate($moduleName),
            'linkInstall' => $this->getInstallLink($moduleName),
            'linkEnable' => $this->getEnableLink($moduleName),
            'linkUpdate' => $this->getUpdateLink($moduleName),
        ];
    }
}
