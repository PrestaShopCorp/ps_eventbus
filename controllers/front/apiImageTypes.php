<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\ImageTypeDataProvider;

class ps_EventbusApiImageTypesModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_IMAGE_TYPES;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var ImageTypeDataProvider $imageTypeDataProvider */
        $imageTypeDataProvider = $this->module->getService(ImageTypeDataProvider::class);

        $response = $this->handleDataSync($imageTypeDataProvider);

        $this->exitWithResponse($response);
    }
}
