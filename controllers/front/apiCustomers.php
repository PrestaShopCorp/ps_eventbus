<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\CustomerDataProvider;

class ps_EventbusApiCustomersModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_CUSTOMERS;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var CustomerDataProvider $customerDataProvider */
        $customerDataProvider = $this->module->getService(CustomerDataProvider::class);

        $response = $this->handleDataSync($customerDataProvider);

        $this->exitWithResponse($response);
    }
}
