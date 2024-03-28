<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\ProductDataProvider;

class ps_EventbusApiProductsModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_PRODUCTS;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var ProductDataProvider $productDataProvider */
        $productDataProvider = $this->module->getService(ProductDataProvider::class);

        $response = $this->handleDataSync($productDataProvider);

        $this->exitWithResponse($response);
    }
}
