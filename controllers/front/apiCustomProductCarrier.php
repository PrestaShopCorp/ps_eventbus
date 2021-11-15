<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\CustomProductCarrierDataProvider;

class ps_EventbusApiCustomProductCarrierModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_CUSTOM_PRODUCT_CARRIER;

    /**
     * @throws PrestaShopException
     *
     * @return void
     */
    public function postProcess()
    {
        $categoryDataProvider = $this->module->getService(CustomProductCarrierDataProvider::class);

        $response = $this->handleDataSync($categoryDataProvider);

        $this->exitWithResponse($response);
    }
}
