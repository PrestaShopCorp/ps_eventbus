<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\EmployeeDataProvider;

class ps_EventbusApiEmployeesModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_EMPLOYEES;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var EmployeeDataProvider $employeeDataProvider */
        $employeeDataProvider = $this->module->getService(EmployeeDataProvider::class);

        $response = $this->handleDataSync($employeeDataProvider);

        $this->exitWithResponse($response);
    }
}
