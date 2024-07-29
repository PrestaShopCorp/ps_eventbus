<?php

use PrestaShop\Module\PsEventbus\Services\FrontApiService;

class ps_EventbusApiFrontModuleFrontController extends ModuleFrontController
{
    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var string $shopContent */
        $shopContent = \Tools::getValue('shopContent');

        /** @var string $jobId */
        $jobId = \Tools::getValue('job_id');

        /** @var string $langIso */
        $langIso = \Tools::getValue('lang_iso'); 

        /** @var int $limit */
        $limit = \Tools::getValue('limit', 50);

        /** @var bool $initFullSync */
        $isFull = \Tools::getValue('full', 0) == 1;

        /** @var bool $debug */
        $debug = \Tools::getValue('debug') == 1;

        /** @var FrontApiService $frontApiService */
        $frontApiService =  $this->module->getService('PrestaShop\Module\PsEventbusV4\Services\ApiService');

        $frontApiService->handleDataSync($shopContent, $jobId, $langIso, $limit, $isFull, $debug);
    }
}

