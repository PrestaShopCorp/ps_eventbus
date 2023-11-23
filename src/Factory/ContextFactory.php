<?php

namespace PrestaShop\Module\PsEventbus\Factory;

class ContextFactory
{
    /**
     * @return \Context|null
     */
    public static function getContext()
    {
        return \Context::getContext();
    }

    /**
     * @return \Language|\PrestaShopBundle\Install\Language
     */
    public static function getLanguage()
    {
        $language = \Context::getContext()->language;

        if ($language === null) {
            throw new \PrestaShopException('Context is null');
        }

        return $language;
    }

    /**
     * @return \Currency|null
     */
    public static function getCurrency()
    {
        return \Context::getContext()->currency;
    }

    /**
     * @return \Smarty
     */
    public static function getSmarty()
    {
        $smarty = \Context::getContext()->smarty;

        if ($smarty === null) {
            throw new \PrestaShopException('Context is null');
        }

        return $smarty;
    }

    /**
     * @return \Shop
     */
    public static function getShop()
    {
        $shop = \Context::getContext()->shop;

        if ($shop === null) {
            throw new \PrestaShopException('Context is null');
        }

        return $shop;
    }

    /**
     * @return \AdminController|\FrontController
     */
    public static function getController()
    {
        $controller = \Context::getContext()->controller;

        if ($controller === null) {
            throw new \PrestaShopException('Context is null');
        }

        if (!($controller instanceof \AdminController) && !($controller instanceof \FrontController)) {
            throw new \PrestaShopException('Controller is not an instance of AdminController or FrontController');
        }

        return $controller;
    }

    /**
     * @return \Cookie
     */
    public static function getCookie()
    {
        $cookie = \Context::getContext()->cookie;

        if ($cookie === null) {
            throw new \PrestaShopException('Context is null');
        }

        return $cookie;
    }

    /**
     * @return \Link
     */
    public static function getLink()
    {
        $link = \Context::getContext()->link;

        if ($link === null) {
            throw new \PrestaShopException('Context is null');
        }

        return $link;
    }
}
