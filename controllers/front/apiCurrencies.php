<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\CurrencyDataProvider;

class ps_EventbusApiCurrenciesModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_CURRENCIES;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var CurrencyDataProvider $currencyDataProvider */
        $currencyDataProvider = $this->module->getService(CurrencyDataProvider::class);

        $response = $this->handleDataSync($currencyDataProvider);

        $this->exitWithResponse($response);
    }
}
