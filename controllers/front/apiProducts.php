<?php

use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\ProductDataProvider;

class ps_EventbusApiProductsModuleFrontController extends AbstractApiController
{
    public $type = 'products';

    /**
     * @throws PrestaShopException
     *
     * @return void
     */
    public function postProcess()
    {
        $productDataProvider = $this->module->getService(ProductDataProvider::class);

        $response = $this->handleDataSync($productDataProvider);

        $this->exitWithResponse($response);
    }
}
