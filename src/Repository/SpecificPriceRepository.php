<?php

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
