<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Helper\ModuleHelper;

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
