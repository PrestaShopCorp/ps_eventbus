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

namespace PrestaShop\Module\PsEventbus\Module;

use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder;
use Ps_eventbus;

class Upgrade
{
    /**
     * @var \Ps_eventbus
     */
    private $module;

    /**
     * Install constructor.
     *
     * @param \Ps_eventbus $module
     *
     * @return void
     */
    public function __construct(\Ps_eventbus $module)
    {
        $this->module = $module;
    }

    /**
     * Upgrade ps_eventbus module
     *
     * @return bool
     */
    public function upgradePsEventbus()
    {
        if (true === \Module::needUpgrade($this->module)) {
            /** @var ModuleManagerBuilder $moduleManagerBuilder */
            $moduleManagerBuilder = ModuleManagerBuilder::getInstance();
            $moduleManager = $moduleManagerBuilder->build();

            return $moduleManager->upgrade((string) $this->module->name);
        }

        return true;
    }
}
