<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\GoogleTaxonomyDataProvider;

class ps_EventbusApiGoogleTaxonomiesModuleFrontController extends AbstractApiController
{
    public $type = 'taxonomies';

    /**
     * @throws PrestaShopException
     *
     * @return void
     */
    public function postProcess()
    {
        if (!Module::isInstalled('ps_facebook')) {
            $this->exitWithExceptionMessage(new Exception('Facebook module is not installed', Config::PS_FACEBOOK_NOT_INSTALLED));
        }

        $categoryDataProvider = $this->module->getService(GoogleTaxonomyDataProvider::class);

        $response = $this->handleDataSync($categoryDataProvider);

        $this->exitWithResponse($response);
    }
}
