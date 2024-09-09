<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Repository\ServerInformationRepository;

class HealthCheckService
{
    /** @var \Ps_eventbus */
    private $module;

    public function __construct(\Ps_eventbus $module)
    {
        $this->module = $module;
    }

    /**
     * @param bool $isAuthentified
     *
     * @return void
     *
     * @throws \PrestaShopException
     */
    public function getHealthCheck($isAuthentified)
    {
        /** @var ServerInformationRepository $serverInformationRepository */
        $serverInformationRepository = $this->module->getService('PrestaShop\Module\PsEventbus\Repository\ServerInformationRepository');

        $status = $serverInformationRepository->getHealthCheckData($isAuthentified);

        CommonService::exitWithResponse($status);
    }
}
