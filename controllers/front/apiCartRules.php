<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Provider\CartRuleDataProvider;

class ps_EventbusApiCartRulesModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_CART_RULES;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var CartRuleDataProvider $cartRuleDataProvider */
        $cartRuleDataProvider = $this->module->getService(CartRuleDataProvider::class);

        $response = $this->handleDataSync($cartRuleDataProvider);

        $this->exitWithResponse($response);
    }
}
