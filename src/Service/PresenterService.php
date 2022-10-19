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
     * @param string $moduleName
     * @param array $requiredConsents
     * @param array $optionalConsents
     *
     * @return array
     */
    public function expose($moduleName, $requiredConsents = [], $optionalConsents = [])
    {
        return [
            'jwt' => $this->psAccountsService->getOrRefreshToken(),
            /* @phpstan-ignore-next-line */
            'shopId' => $this->psAccountsService->getShopUuid(),
            'requiredConsents' => $requiredConsents,
            'optionalConsents' => $optionalConsents,
            'moduleName' => $moduleName,
        ];
    }
}
