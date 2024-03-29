<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\SupplierDataProvider;

class ps_EventbusApiSuppliersModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_SUPPLIERS;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var SupplierDataProvider $supplierDataProvider */
        $supplierDataProvider = $this->module->getService(SupplierDataProvider::class);

        $response = $this->handleDataSync($supplierDataProvider);

        $this->exitWithResponse($response);
    }
}
