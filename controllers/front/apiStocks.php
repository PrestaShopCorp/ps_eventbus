<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\StockDataProvider;

class ps_EventbusApiStocksModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_STOCKS;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var StockDataProvider $stockDataProvider */
        $stockDataProvider = $this->module->getService(StockDataProvider::class);

        $response = $this->handleDataSync($stockDataProvider);

        $this->exitWithResponse($response);
    }
}
