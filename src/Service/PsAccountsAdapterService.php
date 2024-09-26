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

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Helper\ModuleHelper;

if (!defined('_PS_VERSION_')) {
    exit;
}

class PsAccountsAdapterService
{
    /**
     * @var ModuleHelper
     */
    private $moduleHelper;

    /**
     * @var false|\ModuleCore
     */
    private $psAccountModule;

    public function __construct(ModuleHelper $moduleHelper)
    {
        $this->moduleHelper = $moduleHelper;
        $this->psAccountModule = $this->moduleHelper->getInstanceByName('ps_accounts');
    }

    /**
     * Get psAccounts module main class, or null if module is'nt ready
     *
     * @return false|\ModuleCore
     *
     * @throws \PrestaShopException
     */
    public function getModule()
    {
        if ($this->moduleHelper->isInstalledAndActive('ps_accounts') == false) {
            return false;
        }

        return $this->psAccountModule;
    }

    /**
     * Get psAccounts service, or null if module is'nt ready
     *
     * @return mixed
     *
     * @throws \PrestaShopException
     */
    public function getService()
    {
        if ($this->moduleHelper->isInstalledAndActive('ps_accounts') == false) {
            return false;
        }

        return $this->psAccountModule->getService('PrestaShop\Module\PsAccounts\Service\PsAccountsService');
    }

    /**
     * Get presenter from psAccounts, or null if module is'nt ready
     *
     * @return mixed
     *
     * @throws \PrestaShopException
     */
    public function getPresenter()
    {
        if ($this->moduleHelper->isInstalledAndActive('ps_accounts') == false) {
            return false;
        }

        return $this->psAccountModule->getService('PrestaShop\Module\PsAccounts\Presenter\PsAccountsPresenter');
    }

    /**
     * Get shopUuid from psAccounts, or null if module is'nt ready
     *
     * @return string
     *
     * @throws \PrestaShopException
     */
    public function getShopUuid()
    {
        if ($this->moduleHelper->isInstalledAndActive('ps_accounts') == false) {
            return '';
        }

        return $this->getService()->getShopUuid();
    }

    /**
     * Get refreshToken from psAccounts, or null if module is'nt ready
     *
     * @return string
     *
     * @throws \PrestaShopException
     */
    public function getOrRefreshToken()
    {
        if ($this->moduleHelper->isInstalledAndActive('ps_accounts') == false) {
            return '';
        }

        return $this->getService()->getOrRefreshToken();
    }
}
