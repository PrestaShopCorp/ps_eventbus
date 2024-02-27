<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\ImageDataProvider;

class ps_EventbusApiImagesModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_IMAGES;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var ImageDataProvider $imageDataProvider */
        $imageDataProvider = $this->module->getService(ImageDataProvider::class);

        $response = $this->handleDataSync($imageDataProvider);

        $this->exitWithResponse($response);
    }
}
