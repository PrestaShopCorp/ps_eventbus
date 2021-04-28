<?php

use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\ShippingDataProvider;

class ps_EventbusApiShippingModuleFrontController extends AbstractApiController
{
    public $type = 'shipping';

    /**
     * @throws PrestaShopException
     *
     * @return void
     */
    public function postProcess()
    {
        $categoryDataProvider = $this->module->getService(ShippingDataProvider::class);

        $response = $this->handleDataSync($categoryDataProvider);

        $this->exitWithResponse($response);
    }
}
