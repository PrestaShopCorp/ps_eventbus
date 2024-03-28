<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\TranslationDataProvider;

class ps_EventbusApiTranslationsModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_TRANSLATIONS;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var TranslationDataProvider $translationDataProvider */
        $translationDataProvider = $this->module->getService(TranslationDataProvider::class);

        $response = $this->handleDataSync($translationDataProvider);

        $this->exitWithResponse($response);
    }
}
