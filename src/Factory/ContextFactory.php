<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\PsEventbus\Factory;

if (!defined('_PS_VERSION_')) {
    exit;
}

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
