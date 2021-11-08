<?php

use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\CategoryDataProvider;

class ps_EventbusApiCategoriesModuleFrontController extends AbstractApiController
{
    public $type = 'categories';

    /**
     * @throws PrestaShopException
     *
     * @return void
     */
    public function postProcess()
    {
        $categoryDataProvider = $this->module->getService(CategoryDataProvider::class);

        $response = $this->handleDataSync($categoryDataProvider);

        $this->exitWithResponse($response);
    }
}
