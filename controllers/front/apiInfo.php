<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Repository\ServerInformationRepository;

class ps_EventbusApiInfoModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_SHOPS;

    /**
     * @throws PrestaShopException
     *
     * @return void
     */
    public function postProcess()
    {
        $response = [];

        $jobId = Tools::getValue('job_id');

        /** @var ServerInformationRepository $serverInformationRepository */
        $serverInformationRepository = $this->module->getService(ServerInformationRepository::class);

        $serverInfo = $serverInformationRepository->getServerInformation(Tools::getValue('lang_iso', ''));

        try {
            $response = $this->proxyService->upload($jobId, $serverInfo, $this->startTime);
        } catch (EnvVarException|Exception $exception) {
            $this->exitWithExceptionMessage($exception);
        }

        $this->exitWithResponse(
            array_merge(
                [
                    'remaining_objects' => 0,
                    'total_objects' => 1,
                ],
                $response
            )
        );
    }
}
