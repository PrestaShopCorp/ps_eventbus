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

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;
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
     * @var ErrorHandler
     */
    private $errorHandler;

    /**
     * @var false|\ModuleCore
     */
    private $psAccountModule;

    public function __construct(ModuleHelper $moduleHelper, ErrorHandler $errorHandler)
    {
        $this->moduleHelper = $moduleHelper;
        $this->errorHandler = $errorHandler;
        $this->psAccountModule = $this->moduleHelper->getInstanceByName('ps_accounts');
    }

    /**
     * Get psAccounts module main class, or null if module is'nt ready
     *
     * @return false|\ModuleCore
     */
    public function getModule()
    {
        if (!$this->moduleHelper->isInstalledAndActive('ps_accounts')) {
            return false;
        }

        return $this->psAccountModule;
    }

    /**
     * Get psAccounts service, or null if module is'nt ready
     *
     * @return mixed
     */
    public function getService()
    {
        if (!$this->moduleHelper->isInstalledAndActive('ps_accounts')) {
            return false;
        }

        try {
            return $this->psAccountModule->getService('PrestaShop\Module\PsAccounts\Service\PsAccountsService');
        } catch (\Exception $e) {
            $this->errorHandler->handle(
                new \PrestaShopException('Failed to load PsAccountsService', 0, $e),
                true
            );

            return false;
        }
    }

    /**
     * Get presenter from psAccounts, or null if module is'nt ready
     *
     * @return mixed
     */
    public function getPresenter()
    {
        if (!$this->moduleHelper->isInstalledAndActive('ps_accounts') || !$this->getService()) {
            return false;
        }

        try {
            return $this->psAccountModule->getService('PrestaShop\Module\PsAccounts\Presenter\PsAccountsPresenter');
        } catch (\Exception $e) {
            $this->errorHandler->handle(
                new \PrestaShopException('Failed to load PsAccountsPresenter', 0, $e),
                true
            );

            return false;
        }
    }

    /**
     * Get shopUuid from psAccounts, or null if module is'nt ready
     *
     * @return string
     */
    public function getShopUuid()
    {
        if (!$this->moduleHelper->isInstalledAndActive('ps_accounts') || !$this->getService()) {
            return '';
        }

        try {
            return $this->getService()->getShopUuid();
        } catch (\Exception $e) {
            $this->errorHandler->handle(
                new \PrestaShopException('Failed to get shop uuid from ps_account', 0, $e),
                true
            );

            return '';
        }
    }

    /**
     * Get refreshToken from psAccounts, or null if module is'nt ready
     *
     * @return string
     */
    public function getOrRefreshToken()
    {
        if (!$this->moduleHelper->isInstalledAndActive('ps_accounts') || !$this->getService()) {
            return '';
        }

        try {
            return $this->getService()->getOrRefreshToken();
        } catch (\Exception $e) {
            $this->errorHandler->handle(
                new \PrestaShopException('Failed to get refresh token from ps_account', 0, $e),
                true
            );

            return '';
        }
    }
}
