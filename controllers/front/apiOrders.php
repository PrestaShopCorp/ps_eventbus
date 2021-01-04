<?php

use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\OrderDataProvider;

class ps_EventbusApiOrdersModuleFrontController extends AbstractApiController
{
    public $type = 'orders';

    /**
     * @throws PrestaShopException
     *
     * @return void
     */
    public function postProcess()
    {
        $orderDataProvider = $this->module->getService(OrderDataProvider::class);

        $response = $this->handleDataSync($orderDataProvider);

        $this->exitWithResponse($response);
    }
}
