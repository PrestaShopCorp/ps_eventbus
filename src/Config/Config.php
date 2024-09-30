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

namespace PrestaShop\Module\PsEventbus\Config;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Config
{
    const MYSQL_DATE_FORMAT = 'Y-m-d H:i:s';

    const RANDOM_SYNC_CHECK_MAX = 20;
    const INCREMENTAL_SYNC_MAX_ITEMS_PER_SHOP_CONTENT = 100000;

    const SYNC_API_MAX_TIMEOUT = 5;
    const COLLECTOR_MAX_TIMEOUT = 30;
    const COLLECTOR_MULTIPART_BOUNDARY = 'ps_eventbus_boundary';
    const REFRESH_TOKEN_ERROR_CODE = 452;
    const ENV_MISCONFIGURED_ERROR_CODE = 453;
    const DATABASE_QUERY_ERROR_CODE = 454;
    const DATABASE_INSERT_ERROR_CODE = 455;
    const PS_FACEBOOK_NOT_INSTALLED = 456;
    const INVALID_URL_QUERY = 458;
    const INVALID_PS_ACCOUNTS_VERSION = 459;
    const PS_ACCOUNTS_NOT_INSTALLED = 460;

    const HTTP_STATUS_MESSAGES = [
        self::REFRESH_TOKEN_ERROR_CODE => 'Cannot refresh token',
        self::ENV_MISCONFIGURED_ERROR_CODE => 'Environment misconfigured',
        self::DATABASE_QUERY_ERROR_CODE => 'Database syntax error',
        self::DATABASE_INSERT_ERROR_CODE => 'Failed to write to database',
        self::PS_FACEBOOK_NOT_INSTALLED => 'Cannot sync Taxonomies without Facebook module',
        self::INVALID_URL_QUERY => 'Invalid URL query',
        self::INVALID_PS_ACCOUNTS_VERSION => 'Invalid PsAccounts version',
        self::PS_ACCOUNTS_NOT_INSTALLED => 'PsAccounts not installed',
    ];

    const COLLECTION_CARRIERS = 'carriers';
    const COLLECTION_CARRIER_DETAILS = 'carrier_details';
    const COLLECTION_CARRIER_TAXES = 'carrier_taxes';
    const COLLECTION_CARTS = 'carts';
    const COLLECTION_CART_PRODUCTS = 'cart_products';
    const COLLECTION_CART_RULES = 'cart_rules';
    const COLLECTION_CATEGORIES = 'categories';
    const COLLECTION_CURRENCIES = 'currencies';
    const COLLECTION_CUSTOMERS = 'customers';
    const COLLECTION_DELETED = 'deleted';
    const COLLECTION_EMPLOYEES = 'employees';
    const COLLECTION_HEALTHCHECK = 'healthcheck';
    const COLLECTION_IMAGES = 'images';
    const COLLECTION_IMAGE_TYPES = 'image_types';
    const COLLECTION_LANGUAGES = 'languages';
    const COLLECTION_MANUFACTURERS = 'manufacturers';
    const COLLECTION_MODULES = 'modules';
    const COLLECTION_ORDERS = 'orders';
    const COLLECTION_ORDER_CART_RULES = 'order_cart_rules';
    const COLLECTION_ORDER_DETAILS = 'order_details';
    const COLLECTION_ORDER_HISTORIES = 'order_histories';
    const COLLECTION_PRODUCTS = 'products';
    const COLLECTION_PRODUCT_ATTRIBUTES = 'attributes';
    const COLLECTION_PRODUCT_BUNDLES = 'product_bundles';
    const COLLECTION_PRODUCT_CARRIERS = 'product_carriers';
    const COLLECTION_PRODUCT_SUPPLIERS = 'product_suppliers';
    const COLLECTION_SHOP_DETAILS = 'shop_details';
    const COLLECTION_SPECIFIC_PRICES = 'specific_prices';
    const COLLECTION_STOCKS = 'stocks';
    const COLLECTION_STOCK_MVTS = 'stock_mvts';
    const COLLECTION_STORES = 'stores';
    const COLLECTION_SUPPLIERS = 'suppliers';
    const COLLECTION_TAXONOMIES = 'taxonomies';
    const COLLECTION_THEMES = 'themes';
    const COLLECTION_TRANSLATIONS = 'translations';
    const COLLECTION_WISHLISTS = 'wishlists';
    const COLLECTION_WISHLIST_PRODUCTS = 'wishlist_products';

    const SHOP_CONTENTS = [
        self::COLLECTION_CARRIERS,
        self::COLLECTION_CARRIER_DETAILS,
        self::COLLECTION_CARRIER_TAXES,
        self::COLLECTION_CARTS,
        self::COLLECTION_CART_PRODUCTS,
        self::COLLECTION_CART_RULES,
        self::COLLECTION_CATEGORIES,
        self::COLLECTION_CURRENCIES,
        self::COLLECTION_CUSTOMERS,
        self::COLLECTION_DELETED,
        self::COLLECTION_EMPLOYEES,
        self::COLLECTION_IMAGES,
        self::COLLECTION_IMAGE_TYPES,
        self::COLLECTION_LANGUAGES,
        self::COLLECTION_MANUFACTURERS,
        self::COLLECTION_MODULES,
        self::COLLECTION_ORDERS,
        self::COLLECTION_ORDER_CART_RULES,
        self::COLLECTION_ORDER_DETAILS,
        self::COLLECTION_ORDER_HISTORIES,
        self::COLLECTION_PRODUCTS,
        self::COLLECTION_PRODUCT_ATTRIBUTES,
        self::COLLECTION_PRODUCT_BUNDLES,
        self::COLLECTION_PRODUCT_CARRIERS,
        self::COLLECTION_PRODUCT_SUPPLIERS,
        self::COLLECTION_SHOP_DETAILS,
        self::COLLECTION_SPECIFIC_PRICES,
        self::COLLECTION_STOCKS,
        self::COLLECTION_STOCK_MVTS,
        self::COLLECTION_STORES,
        self::COLLECTION_SUPPLIERS,
        self::COLLECTION_TAXONOMIES,
        self::COLLECTION_THEMES,
        self::COLLECTION_TRANSLATIONS,
        self::COLLECTION_WISHLISTS,
        self::COLLECTION_WISHLIST_PRODUCTS,
    ];

    const INCREMENTAL_TYPE_ADD = 'add';
    const INCREMENTAL_TYPE_UPDATE = 'update';
    const INCREMENTAL_TYPE_DELETE = 'delete';

    /**
     * @param mixed $message
     *
     * @return void
     */
    public static function dev_log($message)
    {
        file_put_contents('/var/www/html/php.log', $message . PHP_EOL, FILE_APPEND);
    }
}
