<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Repository\ServerInformationRepository;
use PrestaShop\Module\PsEventbus\Service\CommonService;
use Ps_eventbus;

class HealthCheckService
{
    /** @var Ps_Eventbus $module */
    private $module;

    public function __construct(Ps_eventbus $module) 
    {
        $this->module = $module;
    }

    /**
     * @return void
     *
     * @throws PrestaShopException
     */
    public function getHealthCheck($isAuthentified = null)
    {
        if ($isAuthentified == null) {
            $isAuthentified = false;
        }

        /** @var ServerInformationRepository $serverInformationRepository */
        $serverInformationRepository = $this->module->getService('PrestaShop\Module\PsEventbus\Repository\ServerInformationRepository');

        $status = $serverInformationRepository->getHealthCheckData($isAuthentified);

        CommonService::exitWithResponse($status);
    }

}
