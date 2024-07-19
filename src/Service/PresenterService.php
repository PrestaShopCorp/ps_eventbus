<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\PrestaShop\Core\Addon\Module\ModuleManagerBuilder;

class PresenterService
{
    /**
     * @var PsAccountsAdapterService
     */
    private $psAccountsAdapterService;

    public function __construct()
    {
        $moduleManagerBuilder = ModuleManagerBuilder::getInstance();
        if (!$moduleManagerBuilder) {
            return;
        }
        $moduleManager = $moduleManagerBuilder->build();
        if ($moduleManager->isInstalled('ps_accounts')) {
            $psEventbus = \Module::getInstanceByName('ps_eventbus');
            $psAccountsAdapterService = $psEventbus->getService('PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService');

            $this->psAccountsAdapterService = $psAccountsAdapterService;
        } else {
            $this->installPsAccount();
        }
    }

    /**
     * @return void
     */
    public function installPsAccount()
    {
        $moduleManagerBuilder = ModuleManagerBuilder::getInstance();

        if (!$moduleManagerBuilder) {
            return;
        }

        $moduleManager = $moduleManagerBuilder->build();

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
     * @return array<mixed>
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
     * @param \ModuleCore $module
     * @param array<mixed> $requiredConsents
     * @param array<mixed> $optionalConsents
     *
     * @return array<mixed>
     */
    public function expose(\ModuleCore $module, $requiredConsents = [], $optionalConsents = [])
    {
        if (!in_array('info', $requiredConsents)) {
            array_unshift($requiredConsents, 'info');
        }
        if ($this->psAccountsAdapterService == null) {
            return [];
        } else {
            $language = \Context::getContext()->language;

            if ($language == null) {
                throw new \PrestaShopException('No language context');
            }

            return [
                'jwt' => $this->psAccountsAdapterService->getOrRefreshToken(),
                'requiredConsents' => $requiredConsents,
                'optionalConsents' => $optionalConsents,
                'module' => array_merge([
                    'logoUrl' => \Tools::getHttpHost(true) . '/modules/' . $module->name . '/logo.png',
                ], $this->convertObjectToArray($module)),
                'shop' => [
                    /* @phpstan-ignore-next-line */
                    'id' => $this->psAccountsAdapterService->getShopUuid(),
                    'name' => \Configuration::get('PS_SHOP_NAME'),
                    'url' => \Tools::getHttpHost(true),
                    'lang' => $language->iso_code,
                ],
                'psEventbusModule' => $this->convertObjectToArray(\Module::getInstanceByName('ps_eventbus')),
            ];
        }
    }
}
