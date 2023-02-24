<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Repository\ServerInformationRepository;

class ps_EventbusApiInfoModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_SHOPS;

    /**
     * @return void
     *
     * @throws PrestaShopException
     */
    public function postProcess()
    {
        $response = [];
        /** @var string $jobId */
        $jobId = Tools::getValue('job_id');

        /** @var ServerInformationRepository $serverInformationRepository */
        $serverInformationRepository = $this->module->getService(ServerInformationRepository::class);

        /** @var string $langIso */
        $langIso = Tools::getValue('lang_iso', '');
        $serverInfo = $serverInformationRepository->getServerInformation($langIso);

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
