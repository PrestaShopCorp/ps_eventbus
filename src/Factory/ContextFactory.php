<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

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
     * @return mixed
     */
    public static function getLanguage()
    {
        $language = \Context::getContext()->language;

        if ($language == null) {
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

        if ($smarty == null) {
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

        if ($shop == null) {
            throw new \PrestaShopException('Context is null');
        }

        return $shop;
    }

    /**
     * @return \AdminController|\FrontController|\PrestaShopBundle\Bridge\AdminController\LegacyControllerBridgeInterface|null
     */
    public static function getController()
    {
        $controller = \Context::getContext()->controller;

        if ($controller == null) {
            throw new \PrestaShopException('Context is null');
        }

        return $controller;
    }

    /**
     * @return \Cookie
     */
    public static function getCookie()
    {
        $cookie = \Context::getContext()->cookie;

        if ($cookie == null) {
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

        if ($link == null) {
            throw new \PrestaShopException('Context is null');
        }

        return $link;
    }
}
