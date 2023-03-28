<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class SpecificPriceRepository
{

    public const TABLE_NAME = 'specific_price';

    /**
     * @var \Db
     */
    private $db;

    public function __construct(\Db $db)
    {
        $this->db = $db;
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
     * @param int $specificPrice
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getSpecificPrice(int $specificPriceId)
    {
        if (!$specificPriceId) {
            return [];
        }

        $query = $this->getBaseQuery();
        $this->addSelectParameters($query);
        $query->where('ps.id_specific_price= ' . (int) $specificPriceId);

        return $this->db->executeS($query);
    }    


    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('ps.id_specific_price, ps.id_specific_price_rule, ps.id_cart, ps.id_product, ps.id_shop, ps.id_shop_group, ps.id_currency, ps.id_country, 
        ps.id_country, ps.id_customer, ps.id_product_attribute, ps.price, ps.from_quantity, ps.reduction, ps.reduction_tax, ps.reduction_type, ps.from, ps.to');
    }
}
