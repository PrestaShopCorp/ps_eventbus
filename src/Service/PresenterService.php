<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\AccountsAuth\Service\PsAccountsService;

class PresenterService
{
    /**
     * @var PsAccountsService
     */
    private $psAccountsService;

    public function __construct()
    {
        $accountsModule = \Module::getInstanceByName('ps_accounts');
        /* @phpstan-ignore-next-line */
        $accountService = $accountsModule->getService('PrestaShop\Module\PsAccounts\Service\PsAccountsService');
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
