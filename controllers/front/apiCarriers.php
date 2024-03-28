<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\CarrierDataProvider;

class ps_EventbusApiCarriersModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_CARRIERS;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var CarrierDataProvider $carrierDataProvider */
        $carrierDataProvider = $this->module->getService(CarrierDataProvider::class);

        $response = $this->handleDataSync($carrierDataProvider);

        $this->exitWithResponse($response);
    }
}
