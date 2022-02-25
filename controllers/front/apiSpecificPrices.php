<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\CustomPriceDataProvider;

class ps_EventbusApiSpecificPricesModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_SPECIFIC_PRICES;

    /**
     * @throws PrestaShopException
     *
     * @return void
     */
    public function postProcess()
    {
        $productDataProvider = $this->module->getService(CustomPriceDataProvider::class);

        $response = $this->handleDataSync($productDataProvider);

        $this->exitWithResponse($response);
    }
}
