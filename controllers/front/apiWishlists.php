<?php

use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\WishlistDataProvider;

class ps_EventbusApiWishlistsModuleFrontController extends AbstractApiController
{
    /**
     * @return void
     *
     * @throws PrestaShopException
     */
    public function postProcess()
    {
        /** @var WishlistDataProvider $wishlistDataProvider */
        $wishlistDataProvider = $this->module->getService(WishlistDataProvider::class);

        $response = $this->handleDataSync($wishlistDataProvider);

        $this->exitWithResponse($response);
    }
}
