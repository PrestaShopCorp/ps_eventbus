<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\AccountsAuth\Service\PsAccountsService;
use PrestaShop\Module\PsEventbus\Helper\ModuleHelper;
use Configuration;
use Context;
use Module;
use PrestaShopException;
use Tools;
use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder;

class PresenterService
{
    /**
     * @var PsAccountsService|null
     */
    private $psAccountsService;

    public function __construct()
    {
        $moduleManager = ModuleManagerBuilder::getInstance();
        if (!$moduleManager) {
            return;
        }
        $moduleManager = $moduleManager->build();
        if ($moduleManager->isInstalled('ps_accounts')) {
            $psAccounts = Module::getInstanceByName('ps_accounts');
            $psAccountsService = $psAccounts->getService('PrestaShop\Module\PsAccounts\Service\PsAccountsService');

            $this->psAccountsService = $psAccountsService;
        } else {
            $this->initPsAccount();
        }
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
        } else {
            $moduleManager->upgrade('ps_accounts');
        }
    }

    /**
     * @param object|\ModuleCore|false $object
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
     * @param \PrestaShop\PrestaShop\Adapter\Entity\ModuleCore $module
     * @param array $requiredConsents
     * @param array $optionalConsents
     *
     * @return array
     */
    public function expose(\ModuleCore $module, $requiredConsents = [], $optionalConsents = [])
    {
        /** @var \Ps_eventbus $psEventbusModule */
        $psEventbusModule = Module::getInstanceByName('ps_eventbus');

        /** @var ModuleHelper $moduleHelper */
        $moduleHelper = $psEventbusModule->getService('ps_eventbus.helper.module');

        if (!in_array('info', $requiredConsents)) {
            array_unshift($requiredConsents, 'info');
        }
        if ($this->psAccountsService == null) {
            return [];
        } else {
            $language = Context::getContext()->language;

            if ($language == null) {
                throw new PrestaShopException('No language context');
            }

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
                    'lang' => $language->iso_code,
                ],
                'psEventbusModule' => $this->convertObjectToArray(Module::getInstanceByName('ps_eventbus')),
                'modulesInformation' => [
                    'psEventbus' => $moduleHelper->buildModuleInformation(
                        'ps_eventbus'
                    ),
                    'psMbo' => $moduleHelper->buildModuleInformation(
                        'ps_mbo'
                    ),
                ],
            ];
        }
    }
}
