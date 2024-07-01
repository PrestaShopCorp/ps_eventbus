<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Exception\UnauthorizedException;
use PrestaShop\Module\PsEventbus\Repository\ServerInformationRepository;

class ps_EventbusApiHealthCheckModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_SHOPS;

    /** @var bool */
    private $isAuthentifiedCall = true;

    /**
     * Override default method from AbstractApiController
     * Get another behavior for healthcheck
     *
     * @return void
     */
    public function init()
    {
        /*
        try {
            parent::init();
        } catch (UnauthorizedException $exception) {
            $this->isAuthentifiedCall = false;
        }
        */
    }

    /**
     * @return void
     *
     * @throws \PrestaShopException
     */
    public function postProcess()
    {
        /** @var ServerInformationRepository $serverInformationRepository */
        $serverInformationRepository = $this->module->getService(ServerInformationRepository::class);

        $status = $serverInformationRepository->getHealthCheckData($this->isAuthentifiedCall);

        $this->exitWithResponse($status);
    }
}
