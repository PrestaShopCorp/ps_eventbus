<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\StoreDataProvider;

class ps_EventbusApiStoresModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_STORES;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var StoreDataProvider $storeDataProvider */
        $storeDataProvider = $this->module->getService(StoreDataProvider::class);

        $response = $this->handleDataSync($storeDataProvider);

        $this->exitWithResponse($response);
    }
}
