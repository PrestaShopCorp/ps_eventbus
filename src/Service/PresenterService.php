<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsAccounts\Service\PsAccountsService;

class PresenterService
{
    public function __construct()
    {
        $accountsModule = \Module::getInstanceByName('ps_accounts');
        $accountService = $accountsModule->getService(PsAccountsService::class);
        $this->psAccountsService = $accountService;
    }

    /**
     * @return array
     */
    public function expose()
    {
        return [
            'jwt' => $this->psAccountsService->getOrRefreshToken(),
            'consentUri' => \Context::getContext()->link->getModuleLink('ps_eventbus', 'apiMerchantConsent'),
            'consents' => ['products', 'carts'],
        ];
    }
}
