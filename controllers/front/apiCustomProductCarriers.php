<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\CustomProductCarrierDataProvider;

class ps_EventbusApiCustomProductCarriersModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_CUSTOM_PRODUCT_CARRIERS;

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
