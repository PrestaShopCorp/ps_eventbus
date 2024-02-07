<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class CartRuleRepository
{
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

        $query->from('cart_rule', 'cr');

        return $query;
    }

    /**
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCartRules()
    {
        $query = $this->getBaseQuery();

        $query->select('cr.id_cart_rule,cr.id_customer, cr.code, cr.date_from AS "from",cr.date_to AS "to",cr.description,cr.quantity');
        $query->select('cr.quantity_per_user,cr.priority,cr.partial_use,cr.minimum_amount,cr.minimum_amount_tax,cr.minimum_amount_currency');
        $query->select('cr.minimum_amount_shipping,cr.country_restriction,cr.carrier_restriction,cr.group_restriction,cr.cart_rule_restriction');
        $query->select('cr.product_restriction,cr.shop_restriction,cr.free_shipping,cr.reduction_percent,cr.reduction_amount,cr.reduction_tax');
        $query->select('cr.reduction_currency,cr.reduction_product,cr.gift_product,cr.gift_product_attribute');
        $query->select('cr.highlight,cr.active,cr.date_add AS created_at,cr.date_upd AS updated_at');

        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $query->select('cr.reduction_exclude_special');
        }

        return $this->db->executeS($query);
    }
}
