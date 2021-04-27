<?php

namespace PrestaShop\Module\PsEventbus\Adapter;

use Configuration;
use Shop;

class ConfigurationAdapter
{
    /**
     * @var Shop
     */
    private $shopId;

    /**
     * ConfigurationAdapter constructor.
     *
     * @param int $shopId
     */
    public function __construct($shopId)
    {
        $this->shopId = $shopId;
    }

    /**
     * @param string $key
     * @param int|null $idLang
     * @param int|null $idShopGroup
     * @param int|null $idShop
     * @param bool $default
     *
     * @return false|string
     */
    public function get($key, $idLang = null, $idShopGroup = null, $idShop = null, $default = false)
    {
        if ($idShop === null) {
            $idShop = $this->shopId;
        }

        return Configuration::get($key, $idLang, $idShopGroup, $idShop, $default);
    }

    /**
     * @param string $key
     * @param string|int $values
     * @param bool $html
     * @param int|null $idShopGroup
     * @param int|null $idShop
     *
     * @return bool
     */
    public function updateValue($key, $values, $html = false, $idShopGroup = null, $idShop = null)
    {
        if ($idShop === null) {
            $idShop = $this->shopId;
        }

        return Configuration::updateValue($key, $values, $html, $idShopGroup, $idShop);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function deleteByName($key)
    {
        return Configuration::deleteByName($key);
    }
}
