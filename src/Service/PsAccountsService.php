<?php

namespace PrestaShop\Module\PsEventbus\Service;

use Module;
use PrestaShop\PrestaShop\Core\Domain\Module\Exception\ModuleNotFoundException;

class PsAccountsService 
{
    private $psAccountModule;

    public function __construct()
    {
        $this->psAccountModule = Module::getInstanceByName('ps_accounts');

        if ($this->psAccountModule == false) {
            throw new ModuleNotFoundException('Ps_Accounts is\'nt installed');
        }
    }

    public function getModule()
    {
        return $this->psAccountModule;
    }

    public function getService()
    {
        return $this->psAccountModule->getService('PrestaShop\Module\PsAccounts\Service\PsAccountsService');
    }

    public function getPresenter()
    {
        return $this->psAccountModule->getService('PrestaShop\Module\PsAccounts\Presenter\PsAccountsPresenter');
    }

    public function getShopUuid()
    {
        if ($this->psAccountModule == false) {
            return null;
        }

        return $this->getService()->getShopUuid();
    }

    public function getOrRefreshToken()
    {
        if ($this->psAccountModule == false) {
            return null;
        }
        
        return $this->getService()->getOrRefreshToken();
    }
}
