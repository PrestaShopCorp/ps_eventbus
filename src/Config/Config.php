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

namespace PrestaShop\Module\PsEventbus\Config;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Config
{
    const MYSQL_DATE_FORMAT = 'Y-m-d H:i:s';

    const INCREMENTAL_SYNC_TABLE_SIZE_CHECK_MOD = 20;
    const INCREMENTAL_SYNC_MAX_TABLE_SIZE = 1000000;
    const INCREMENTAL_TYPE_UPSERT = 'upsert';
    const INCREMENTAL_TYPE_DELETE = 'delete';

    const SYNC_SERVICE_NAME = 'PrestaShop\Module\PsEventbus\Service\SynchronizationService';

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

    const COLLECTION_BUNDLES = 'bundles';
    const COLLECTION_CARRIERS = 'carriers';
    const COLLECTION_CARRIER_DETAILS = 'carrier_details';
    const COLLECTION_CARRIER_TAXES = 'carrier_taxes';
    const COLLECTION_CARTS = 'carts';
    const COLLECTION_CART_PRODUCTS = 'cart_products';
    const COLLECTION_CART_RULES = 'cart_rules';
    const COLLECTION_CATEGORIES = 'categories';
    const COLLECTION_CURRENCIES = 'currencies';
    const COLLECTION_CUSTOMERS = 'customers';
    const COLLECTION_CUSTOM_PRODUCT_CARRIERS = 'custom_product_carriers';
    const COLLECTION_EMPLOYEES = 'employees';
    const COLLECTION_IMAGES = 'images';
    const COLLECTION_IMAGE_TYPES = 'image_types'; // NO INCREMENTAL
    const COLLECTION_LANGUAGES = 'languages';
    const COLLECTION_MANUFACTURERS = 'manufacturers';
    const COLLECTION_MODULES = 'modules'; // NO INCREMENTAL
    const COLLECTION_ORDERS = 'orders';
    const COLLECTION_ORDER_CARRIERS = 'order_carriers';
    const COLLECTION_ORDER_CART_RULES = 'order_cart_rules';
    const COLLECTION_ORDER_DETAILS = 'order_details';
    const COLLECTION_ORDER_STATUS_HISTORY = 'order_status_history';
    const COLLECTION_PRODUCTS = 'products';
    const COLLECTION_PRODUCT_SUPPLIERS = 'product_suppliers';
    const COLLECTION_INFO = 'info'; // NO INCREMENTAL
    const COLLECTION_SPECIFIC_PRICES = 'specific_prices';
    const COLLECTION_STOCKS = 'stocks';
    const COLLECTION_STOCK_MOVEMENTS = 'stock_movements';
    const COLLECTION_STORES = 'stores';
    const COLLECTION_SUPPLIERS = 'suppliers';
    const COLLECTION_TAXONOMIES = 'taxonomies'; // NO INCREMENTAL
    const COLLECTION_THEMES = 'themes'; // NO INCREMENTAL
    const COLLECTION_TRANSLATIONS = 'translations';
    const COLLECTION_WISHLISTS = 'wishlists';
    const COLLECTION_WISHLIST_PRODUCTS = 'wishlist_products';

    const SHOP_CONTENTS = [
        self::COLLECTION_BUNDLES,
        self::COLLECTION_CARRIERS,
        self::COLLECTION_CARRIER_DETAILS,
        self::COLLECTION_CARRIER_TAXES,
        self::COLLECTION_CARTS,
        self::COLLECTION_CART_PRODUCTS,
        self::COLLECTION_CART_RULES,
        self::COLLECTION_CATEGORIES,
        self::COLLECTION_CURRENCIES,
        self::COLLECTION_CUSTOMERS,
        self::COLLECTION_EMPLOYEES,
        self::COLLECTION_IMAGES,
        self::COLLECTION_IMAGE_TYPES,
        self::COLLECTION_LANGUAGES,
        self::COLLECTION_MANUFACTURERS,
        self::COLLECTION_MODULES,
        self::COLLECTION_ORDERS,
        self::COLLECTION_ORDER_CARRIERS,
        self::COLLECTION_ORDER_CART_RULES,
        self::COLLECTION_ORDER_DETAILS,
        self::COLLECTION_ORDER_STATUS_HISTORY,
        self::COLLECTION_PRODUCTS,
        self::COLLECTION_CUSTOM_PRODUCT_CARRIERS,
        self::COLLECTION_PRODUCT_SUPPLIERS,
        self::COLLECTION_INFO,
        self::COLLECTION_SPECIFIC_PRICES,
        self::COLLECTION_STOCKS,
        self::COLLECTION_STOCK_MOVEMENTS,
        self::COLLECTION_STORES,
        self::COLLECTION_SUPPLIERS,
        self::COLLECTION_TAXONOMIES,
        self::COLLECTION_THEMES,
        self::COLLECTION_TRANSLATIONS,
        self::COLLECTION_WISHLISTS,
        self::COLLECTION_WISHLIST_PRODUCTS,
    ];
}
