<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\CategoryDataProvider;

class ps_EventbusApiCategoriesModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_CATEGORIES;

    /**
     * @throws PrestaShopException
     *
     * @return void
     */
    public function postProcess()
    {
        /** @var CategoryDataProvider $categoryDataProvider */
        $categoryDataProvider = $this->module->getService(CategoryDataProvider::class);

        $response = $this->handleDataSync($categoryDataProvider);

        $this->exitWithResponse($response);
    }
}
