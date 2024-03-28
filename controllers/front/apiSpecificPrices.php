<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\CustomPriceDataProvider;

class ps_EventbusApiSpecificPricesModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_SPECIFIC_PRICES;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var CustomPriceDataProvider $productDataProvider */
        $productDataProvider = $this->module->getService(CustomPriceDataProvider::class);

        $response = $this->handleDataSync($productDataProvider);

        $this->exitWithResponse($response);
    }
}
