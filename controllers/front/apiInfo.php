<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Repository\ServerInformationRepository;

class ps_EventbusApiInfoModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_SHOPS;

    /**
     * @return void
     *
     * @throws\PrestaShopException
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

        /** @var bool $initFullSync */
        $initFullSync = Tools::getValue('full', 0) == 1;

        try {
            $response = $this->proxyService->upload($jobId, $serverInfo, $this->startTime, $initFullSync);
        } catch (Exception $exception) {
            $this->exitWithExceptionMessage($exception);
        }

        $this->exitWithResponse(
            array_merge(
                [
                    'remaining_objects' => 0,
                    'total_objects' => 1,
                    'job_id' => $jobId,
                    'object_type' => $this->type,
                    'syncType' => 'full',
                ],
                $response
            )
        );
    }
}
