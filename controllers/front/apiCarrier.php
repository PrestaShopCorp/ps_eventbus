<?php

use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\CarrierDataProvider;

class ps_EventbusApiCarrierModuleFrontController extends AbstractApiController
{
    public $type = 'carrier';

    /**
     * @throws PrestaShopException
     *
     * @return void
     */
    public function postProcess()
    {
        $categoryDataProvider = $this->module->getService(CarrierDataProvider::class);

        $response = $this->handleDataSync($categoryDataProvider);

        $this->exitWithResponse($response);
    }
}
