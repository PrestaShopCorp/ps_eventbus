<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\CartDataProvider;

class ps_EventbusApiCartsModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_CARTS;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var CartDataProvider $cartDataProvider */
        $cartDataProvider = $this->module->getService(CartDataProvider::class);

        $response = $this->handleDataSync($cartDataProvider);

        $this->exitWithResponse($response);
    }
}
