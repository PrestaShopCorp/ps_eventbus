<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\ManufacturerDataProvider;

class ps_EventbusApiManufacturersModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_MANUFACTURERS;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var ManufacturerDataProvider $manufacturerDataProvider */
        $manufacturerDataProvider = $this->module->getService(ManufacturerDataProvider::class);

        $response = $this->handleDataSync($manufacturerDataProvider);

        $this->exitWithResponse($response);
    }
}
