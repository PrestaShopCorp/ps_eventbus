<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class CartRuleRepository
{
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

        $query->from('cart_rule', 'cr');

        return $query;
    }

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCartRules($limit, $offset)
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

        $query->limit($limit, $offset);

        return $this->db->executeS($query);
    }

    /**
     * @param int $limit
     * @param array $cartRuleIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCartRulesIncremental($limit, $cartRuleIds)
    {
        $query = $this->getBaseQuery();

        $query->where('cr.id_cart_rule IN(' . implode(',', array_map('intval', $cartRuleIds)) . ')')
          ->limit($limit);

        return $this->db->executeS($query);
    }

    /**
     * @param int $offset
     *
     * @return int
     */
    public function getRemainingCartRulesCount($offset)
    {
        $query = $this->getBaseQuery();

        $query->select('(COUNT(cr.id_cart_rule) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($limit, $offset)
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

        $query->limit($limit, $offset);

        $queryStringified = preg_replace('/\s+/', ' ', $query->build());

        return array_merge(
            (array) $query,
            ['queryStringified' => $queryStringified]
        );
    }
}
