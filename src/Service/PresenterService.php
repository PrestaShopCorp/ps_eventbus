<?php

namespace PrestaShop\Module\PsEventbus\Service;

use Configuration;
use ModuleCore;
use PrestaShop\AccountsAuth\Service\PsAccountsService;
use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder;
use Tools;

class PresenterService
{
    /**
     * @var PsAccountsService|null
     */
    private $psAccountsService = null;

    public function __construct()
    {
        $this->initPsAccount();
    }

    /**
     * @return void
     */
    public function initPsAccount()
    {
        $moduleManager = ModuleManagerBuilder::getInstance();
        if (!$moduleManager) {
            return;
        }
        $moduleManager = $moduleManager->build();

        if (!$moduleManager->isInstalled('ps_accounts')) {
            $moduleManager->install('ps_accounts');
        } elseif (!$moduleManager->isEnabled('ps_accounts')) {
            $moduleManager->enable('ps_accounts');
        }

        $accountsModule = \Module::getInstanceByName('ps_accounts');
        /* @phpstan-ignore-next-line */
        $accountService = $accountsModule->getService('PrestaShop\Module\PsAccounts\Service\PsAccountsService');
        $this->psAccountsService = $accountService;
    }

    /**
     * @param object|ModuleCore|false $object
     *
     * @return array
     */
    private function convertObjectToArray($object)
    {
        if ($object == false) {
            return [];
        }
        $array = [];
        /* @phpstan-ignore-next-line */ // TODO understand why phpstan complains about this
        foreach ($object as $key => $value) {
            if (is_object($value)) {
                $array[$key] = $this->convertObjectToArray($value);
            } else {
                $array[$key] = $value;
            }
        }

        return $array;
    }

    /**
     * @param array $consents
     *
     * @return array
     */
    private function enforceMandatoryConsents($consents)
    {
        $mandatories = ['info', 'modules', 'themes'];
        foreach ($mandatories as $consent) {
            if (!in_array($consent, $consents)) {
                array_unshift($consents, $consent);
            }
        }

        return $consents;
    }

    /**
     * @param ModuleCore $module
     * @param array $requiredConsents
     * @param array $optionalConsents
     *
     * @return array
     */
    public function expose(ModuleCore $module, $requiredConsents = [], $optionalConsents = [])
    {
        $requiredConsents = $this->enforceMandatoryConsents($requiredConsents);
        if ($this->psAccountsService == null) {
            return [
                'module' => array_merge([
                    'logoUrl' => Tools::getHttpHost(true) . '/modules/' . $module->name . '/logo.png',
                ], $this->convertObjectToArray($module)),
                'psEventbusModule' => $this->convertObjectToArray(\Module::getInstanceByName('ps_eventbus')),
            ];
        } else {
            return [
                'jwt' => $this->psAccountsService->getOrRefreshToken(),
                'requiredConsents' => $requiredConsents,
                'optionalConsents' => $optionalConsents,
                'module' => array_merge([
                    'logoUrl' => Tools::getHttpHost(true) . '/modules/' . $module->name . '/logo.png',
                ], $this->convertObjectToArray($module)),
                'shop' => [
                    /* @phpstan-ignore-next-line */
                    'id' => $this->psAccountsService->getShopUuid(),
                    'name' => Configuration::get('PS_SHOP_NAME'),
                    'url' => Tools::getHttpHost(true),
                ],
                'psEventbusModule' => $this->convertObjectToArray(\Module::getInstanceByName('ps_eventbus')),
            ];
        }
    }
}
