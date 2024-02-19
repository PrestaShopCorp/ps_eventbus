<?php

namespace PrestaShop\Module\PsEventbus\Factory;

class ContextFactory
{
    /**
     * @return \PrestaShop\PrestaShop\Adapter\Entity\Context|null
     */
    public static function getContext()
    {
        return \PrestaShop\PrestaShop\Adapter\Entity\Context::getContext();
    }

    /**
     * @return \PrestaShop\PrestaShop\Adapter\Entity\Language|\PrestaShopBundle\Install\Language
     */
    public static function getLanguage()
    {
        $language = \PrestaShop\PrestaShop\Adapter\Entity\Context::getContext()->language;

        if ($language == null) {
            throw new \PrestaShop\PrestaShop\Adapter\Entity\PrestaShopException('Context is null');
        }

        return $language;
    }

    /**
     * @return \PrestaShop\PrestaShop\Adapter\Entity\Currency|null
     */
    public static function getCurrency()
    {
        return \PrestaShop\PrestaShop\Adapter\Entity\Context::getContext()->currency;
    }

    /**
     * @return \PrestaShop\PrestaShop\Adapter\Entity\Smarty
     */
    public static function getSmarty()
    {
        $smarty = \PrestaShop\PrestaShop\Adapter\Entity\Context::getContext()->smarty;

        if ($smarty == null) {
            throw new \PrestaShop\PrestaShop\Adapter\Entity\PrestaShopException('Context is null');
        }

        return $smarty;
    }

    /**
     * @return \PrestaShop\PrestaShop\Adapter\Entity\Shop
     */
    public static function getShop()
    {
        $shop = \PrestaShop\PrestaShop\Adapter\Entity\Context::getContext()->shop;

        if ($shop == null) {
            throw new \PrestaShop\PrestaShop\Adapter\Entity\PrestaShopException('Context is null');
        }

        return $shop;
    }

    /**
     * @return \PrestaShop\PrestaShop\Adapter\Entity\AdminController|\FrontController|\PrestaShopBundle\Bridge\AdminController\LegacyControllerBridgeInterface|null
     */
    public static function getController()
    {
        $controller = \PrestaShop\PrestaShop\Adapter\Entity\Context::getContext()->controller;

        if ($controller == null) {
            throw new \PrestaShop\PrestaShop\Adapter\Entity\PrestaShopException('Context is null');
        }

        return $controller;
    }

    /**
     * @return \PrestaShop\PrestaShop\Adapter\Entity\Cookie
     */
    public static function getCookie()
    {
        $cookie = \PrestaShop\PrestaShop\Adapter\Entity\Context::getContext()->cookie;

        if ($cookie == null) {
            throw new \PrestaShop\PrestaShop\Adapter\Entity\PrestaShopException('Context is null');
        }

        return $cookie;
    }

    /**
     * @return \PrestaShop\PrestaShop\Adapter\Entity\Link
     */
    public static function getLink()
    {
        $link = \PrestaShop\PrestaShop\Adapter\Entity\Context::getContext()->link;

        if ($link == null) {
            throw new \PrestaShop\PrestaShop\Adapter\Entity\PrestaShopException('Context is null');
        }

        return $link;
    }
}
