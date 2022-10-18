<?php

namespace PrestaShop\Module\PsEventbus\Service;


class PresenterService
{

    public function __construct()
    {
        $accountsModule =  \Module::getInstanceByName("ps_accounts");
        $accountService = $accountsModule->getService("PrestaShop\Module\PsAccounts\Service\PsAccountsService");
        $this->psAccountsService = $accountService;
    }

    /**
     *
     * @return array
     *
     */
    public function expose()
    {
        return [
            'jwt' => $this->psAccountsService->getOrRefreshToken(),
            'consentUri' => \Context::getContext()->link->getModuleLink('ps_eventbus', 'apiMerchantConsent'),
            'consents' => ['products', 'carts']
        ];
    }
}
