<?php

namespace PrestaShop\Module\PsEventbus\Helper;

use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder;

class ModuleHelper
{
    /**
     * @var \PrestaShop\PrestaShop\Core\Module\ModuleManager|\PrestaShop\PrestaShop\Core\Addon\Module\ModuleManager
     */
    private $moduleManager;

    public function __construct()
    {
        $moduleManagerBuilder = null;

        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7', '>=')) {
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
    public function isInstalled($moduleName)
    {
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7', '<')) {
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
    public function isEnabled($moduleName)
    {
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7', '<')) {
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
    public function isInstalledAndActive($moduleName)
    {
        return $this->isInstalled($moduleName) && $this->isEnabled($moduleName);
    }

    /**
     * @param string $moduleName
     *
     * @return false|\ModuleCore
     */
    public function getInstanceByName($moduleName)
    {
        return \ModuleCore::getInstanceByName($moduleName);
    }
}
