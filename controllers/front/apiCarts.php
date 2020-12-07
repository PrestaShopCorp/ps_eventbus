<?php

use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\CartDataProvider;

class ps_EventbusApiCartsModuleFrontController extends AbstractApiController
{
    public $type = 'carts';

    /**
     * @throws PrestaShopException
     *
     * @return void
     */
    public function postProcess()
    {
        $cartDataProvider = $this->module->getService(CartDataProvider::class);

        $response = $this->handleDataSync($cartDataProvider);

        $this->exitWithResponse($response);
    }
}
