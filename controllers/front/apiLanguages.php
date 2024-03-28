<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\LanguageDataProvider;

class ps_EventbusApiLanguagesModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_LANGUAGES;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var LanguageDataProvider $languageDataProvider */
        $languageDataProvider = $this->module->getService(LanguageDataProvider::class);

        $response = $this->handleDataSync($languageDataProvider);

        $this->exitWithResponse($response);
    }
}
