<?php

namespace PrestaShop\Module\PsEventbus\Config;

class Config
{
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

    const COLLECTION_BUNDLES = 'bundles';
    const COLLECTION_CARRIERS = 'carriers';
    const COLLECTION_CARTS = 'carts';
    const COLLECTION_CART_PRODUCTS = 'cart_products';
    const COLLECTION_CART_RULES = 'cart_rules';
    const COLLECTION_CATEGORIES = 'categories';
    const COLLECTION_CURRENCIES = 'currencies';
    const COLLECTION_CUSTOM_PRODUCT_CARRIERS = 'custom_product_carriers';
    const COLLECTION_CUSTOMERS = 'customers';
    const COLLECTION_DELETED = 'deleted';
    const COLLECTION_EMPLOYEES = 'employees';
    const COLLECTION_IMAGES = 'images';
    const COLLECTION_IMAGE_TYPES = 'image_types';
    const COLLECTION_LANGUAGES = 'languages';
    const COLLECTION_MANUFACTURERS = 'manufacturers';
    const COLLECTION_MODULES = 'modules';
    const COLLECTION_ORDERS = 'orders';
    const COLLECTION_ORDER_CART_RULES = 'order_cart_rules';
    const COLLECTION_ORDER_DETAILS = 'order_details';
    const COLLECTION_ORDER_STATUS_HISTORY = 'order_status_history';
    const COLLECTION_PRODUCTS = 'products';
    const COLLECTION_PRODUCT_ATTRIBUTES = 'attributes';
    const COLLECTION_PRODUCT_SUPPLIERS = 'product_suppliers';
    const COLLECTION_SHOPS = 'shops';
    const COLLECTION_SPECIFIC_PRICES = 'specific_prices';
    const COLLECTION_STOCKS = 'stocks';
    const COLLECTION_STOCK_MVTS = 'stock_movements';
    const COLLECTION_STORES = 'stores';
    const COLLECTION_SUPPLIERS = 'suppliers';
    const COLLECTION_TAXONOMIES = 'taxonomies';
    const COLLECTION_THEMES = 'themes';
    const COLLECTION_TRANSLATIONS = 'translations';
    const COLLECTION_WISHLISTS = 'wishlists';
    const COLLECTION_WISHLIST_PRODUCTS = 'wishlist_products';

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
