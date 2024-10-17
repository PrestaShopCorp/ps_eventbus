<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\PsEventbus\Helper;

use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder;

if (!defined('_PS_VERSION_')) {
    exit;
}

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
