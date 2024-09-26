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

namespace PrestaShop\Module\PsEventbus\Repository;

class SpecificPriceRepository
{
    const TABLE_NAME = 'specific_price';

    /**
     * @var \Db
     */
    private $db;

    public function __construct()
    {
        $this->db = \Db::getInstance();
    }

    /**
     * @return \DbQuery
     */
    public function getBaseQuery()
    {
        $query = new \DbQuery();
        $query->from(self::TABLE_NAME, 'sp');

        return $query;
    }

    /**
     * @param int $specificPriceId
     *
     * @return array<mixed>|bool|false|object|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getSpecificPrice($specificPriceId)
    {
        if (!$specificPriceId) {
            return [];
        }

        $query = $this->getBaseQuery();
        $this->addSelectParameters($query);
        $query->where('sp.id_specific_price= ' . (int) $specificPriceId);

        return $this->db->getRow($query);
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('sp.id_specific_price, sp.id_specific_price_rule, sp.id_cart, sp.id_product, sp.id_shop, sp.id_shop_group, sp.id_currency, sp.id_country');
        $query->select('sp.id_country, sp.id_customer, sp.id_product_attribute, sp.price, sp.from_quantity, sp.reduction, sp.reduction_tax, sp.reduction_type, sp.from, sp.to');
    }
}
