<?php

use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\ModuleDataProvider;
use PrestaShop\Module\PsEventbus\Repository\ModuleRepository;

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
        $moduleDataProvider = new ModuleDataProvider(
            new ModuleRepository(Db::getInstance())
        );

        $response = $this->handleDataSync($moduleDataProvider);

        $this->exitWithResponse($response);
    }
}
