<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use Context;
use Db;
use DbQuery;
use Employee;
use PrestaShopDatabaseException;
use Product;

class CustomPriceRepository
{
    /**
     * @var Context
     */
    private $context;
    /**
     * @var Db
     */
    private $db;

    public function __construct(Db $db, Context $context)
    {
        $this->db = $db;
        $this->context = $context;

        if (!$this->context->employee instanceof Employee) {
            if (($employees = Employee::getEmployees()) !== false) {
                $this->context->employee = new Employee($employees[0]['id_employee']);
            }
        }
    }

    /**
     * @param int $shopId
     *
     * @return DbQuery
     */
    private function getBaseQuery($shopId)
    {
        $query = new DbQuery();

        $query->from('specific_price', 'sp')
            ->leftJoin('country', 'c', 'c.id_country = sp.id_country')
            ->leftJoin('currency', 'cur', 'cur.id_currency = sp.id_currency')
//            ->leftJoin('specific_price_rule', 'spr', 'pas.id_product_attribute = pa.id_product_attribute')
//            ->leftJoin('specific_price_rule_condition', 'sprc', 'ps.id_category_default = cl.id_category AND ps.id_shop = cl.id_shop AND cl.id_lang = ' . (int) $langId)
//            ->leftJoin('specific_price_rule_condition_group', 'sprcg', 'sa.id_product = p.id_product AND sa.id_product_attribute = IFNULL(pas.id_product_attribute, 0) AND sa.id_shop = ps.id_shop')
        ;

        $query->where('sp.id_shop = 0 OR sp.id_shop = ' . (int) $shopId);

        return $query;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
     *
     * @throws PrestaShopDatabaseException
     */
    public function getSpecificPrices($offset, $limit)
    {
        $query = $this->getBaseQuery($this->context->shop->id);

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        $result = $this->db->executeS($query);

        return is_array($result) ? $result : [];
    }

    /**
     * @param int $offset
     *
     * @return int
     *
     * @throws PrestaShopDatabaseException
     */
    public function getRemainingSpecificPricesCount($offset)
    {
        $products = $this->getSpecificPrices($offset, 0);

        if (!is_array($products) || empty($products)) {
            return 0;
        }

        return count($products);
    }

    /**
     * @param DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(DbQuery $query)
    {
        $query->select('sp.id_specific_price, sp.id_product, sp.id_shop, sp.id_shop_group, sp.id_currency,
            sp.id_country, sp.id_group, sp.id_customer, sp.id_product_attribute, sp.price, sp.from_quantity, 
            sp.reduction, sp.reduction_tax, sp.from, sp.to, sp.reduction_type
        ');

        $query->select('c.iso_code as country');
        $query->select('cur.iso_code as currency');
    }
}
