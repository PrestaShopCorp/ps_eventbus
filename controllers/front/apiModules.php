<?php

use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\ModuleDataProvider;

class ps_EventbusApiModulesModuleFrontController extends AbstractApiController
{
    public $type = 'modules';

    /**
     * @throws PrestaShopException
     *
     * @return void
     */
    public function postProcess()
    {
        /** @var ModuleDataProvider $moduleDataProvider */
        $moduleDataProvider = $this->module->getService(ModuleDataProvider::class);

        $response = $this->handleDataSync($moduleDataProvider);

        $this->exitWithResponse($response);
    }
}
