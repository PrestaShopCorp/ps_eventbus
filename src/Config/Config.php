<?php

namespace PrestaShop\Module\PsEventbus\Config;

class Config
{
    const PROXY_TIMEOUT = 30;
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
    const COLLECTION_CARTS = 'carts';
    const COLLECTION_CART_PRODUCTS = 'cart_products';
    const COLLECTION_CATEGORIES = 'categories';
    const COLLECTION_SPECIFIC_PRICES = 'specific_prices';
    const COLLECTION_CUSTOM_PRODUCT_CARRIERS = 'custom_product_carriers';
    const COLLECTION_TAXONOMIES = 'taxonomies';
    const COLLECTION_MODULES = 'modules';
    const COLLECTION_ORDERS = 'orders';
    const COLLECTION_ORDER_DETAILS = 'order_details';
    const COLLECTION_PRODUCTS = 'products';
    const COLLECTION_PRODUCT_ATTRIBUTES = 'attributes';
    const COLLECTION_DELETED = 'deleted';
    const COLLECTION_SHOPS = 'shops';
    const COLLECTION_THEMES = 'themes';
    const COLLECTION_BUNDLES = 'bundles';
}
