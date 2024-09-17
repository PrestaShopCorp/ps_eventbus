<?php

use PrestaShop\Module\PsEventbus\Service\FrontApiService;

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
        $shopContent = Tools::getValue('shop_content');

        /** @var string $jobId */
        $jobId = Tools::getValue('job_id');

        /** @var string $langIso */
        $langIso = Tools::getValue('lang_iso');

        /** @var int $limit */
        $limit = Tools::getValue('limit', 50);

        /** @var bool $fullSyncRequested */
        $fullSyncRequested = Tools::getValue('full', 0) == 1;

        /** @var bool $debug */
        $debug = Tools::getValue('debug') == 1;

        /** @var bool $ise2e */
        $ise2e = Tools::getValue('is_e2e') == 1;

        /** @var Ps_eventbus $module */
        $module = Module::getInstanceByName('ps_eventbus');

        /** @var FrontApiService $frontApiService */
        $frontApiService = $module->getService('PrestaShop\Module\PsEventbus\Service\FrontApiService');

        // edit shopContent for matching Config.php const
        $shopContentEdited = str_replace('-', '_', $shopContent);

        $frontApiService->handleDataSync($shopContentEdited, $jobId, $langIso, $limit, $fullSyncRequested, $debug, $ise2e);
    }
}