<?php

namespace PrestaShop\Module\PsEventbus\Service;

use ModuleCore;
use PrestaShop\Module\PsEventbus\Helper\ModuleHelper;
use PrestaShopException;

class PsAccountsAdapterService
{
    /**
     * @var ModuleHelper
     */
    private $moduleHelper;

    /**
     * 
     * @var false|ModuleCore
     */
    private $psAccountModule;

    public function __construct(ModuleHelper $moduleHelper)
    {   
        $this->moduleHelper = $moduleHelper;
        $this->psAccountModule = $this->moduleHelper->getInstanceByName('ps_accounts');
    }

    /**
     * Get psAccounts module main class, or null if module is'nt ready
     * @return PsAccountsService
     * @throws PrestaShopException 
     */
    public function getModule()
    {
        if ($this->moduleHelper->isInstalledAndActive('ps_accounts') == false) {
            return null;
        }

        return $this->psAccountModule;
    }

    /**
     * Get psAccounts service, or null if module is'nt ready
     * @return PsAccountsService
     * @throws PrestaShopException 
     */
    public function getService()
    {
        if ($this->moduleHelper->isInstalledAndActive('ps_accounts') == false) {
            return null;
        }

        return $this->psAccountModule->getService('PrestaShop\Module\PsAccounts\Service\PsAccountsService');
    }

    /**
     * Get presenter from psAccounts, or null if module is'nt ready
     * @return PsAccountsPresenter
     * @throws PrestaShopException 
     */
    public function getPresenter()
    {
        if ($this->moduleHelper->isInstalledAndActive('ps_accounts') == false) {
            return null;
        }

        return $this->psAccountModule->getService('PrestaShop\Module\PsAccounts\Presenter\PsAccountsPresenter');
    }

    /**
     * Get shopUuid from psAccounts, or null if module is'nt ready
     * @return string|null 
     * @throws PrestaShopException 
     */
    public function getShopUuid()
    {
        return $this->getService()->getShopUuid();
    }

    /**
     * Get refreshToken from psAccounts, or null if module is'nt ready
     * @return string|null 
     * @throws PrestaShopException 
     */
    public function getOrRefreshToken()
    {
        return $this->getService()->getOrRefreshToken();
    }
}
