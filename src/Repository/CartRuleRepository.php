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
        $dbQuery = new \DbQuery();

        $dbQuery->from('cart_rule', 'cr');

        return $dbQuery;
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
        $dbQuery = $this->getBaseQuery();

        $dbQuery->select('cr.id_cart_rule,cr.id_customer, cr.code, cr.date_from AS "from",cr.date_to AS "to",cr.description,cr.quantity');
        $dbQuery->select('cr.quantity_per_user,cr.priority,cr.partial_use,cr.minimum_amount,cr.minimum_amount_tax,cr.minimum_amount_currency');
        $dbQuery->select('cr.minimum_amount_shipping,cr.country_restriction,cr.carrier_restriction,cr.group_restriction,cr.cart_rule_restriction');
        $dbQuery->select('cr.product_restriction,cr.shop_restriction,cr.free_shipping,cr.reduction_percent,cr.reduction_amount,cr.reduction_tax');
        $dbQuery->select('cr.reduction_currency,cr.reduction_product,cr.gift_product,cr.gift_product_attribute');
        $dbQuery->select('cr.highlight,cr.active,cr.date_add AS created_at,cr.date_upd AS updated_at');

        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $dbQuery->select('cr.reduction_exclude_special');
        }

        $dbQuery->limit($limit, $offset);

        return $this->db->executeS($dbQuery);
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
        $dbQuery = $this->getBaseQuery();

        $dbQuery->where('cr.id_cart_rule IN(' . implode(',', array_map('intval', $cartRuleIds)) . ')')
          ->limit($limit);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param int $offset
     *
     * @return int
     */
    public function getRemainingCartRulesCount($offset)
    {
        $dbQuery = $this->getBaseQuery();

        $dbQuery->select('(COUNT(cr.id_cart_rule) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($dbQuery);
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
        $dbQuery = $this->getBaseQuery();

        $dbQuery->select('cr.id_cart_rule,cr.id_customer, cr.code, cr.date_from AS "from",cr.date_to AS "to",cr.description,cr.quantity');
        $dbQuery->select('cr.quantity_per_user,cr.priority,cr.partial_use,cr.minimum_amount,cr.minimum_amount_tax,cr.minimum_amount_currency');
        $dbQuery->select('cr.minimum_amount_shipping,cr.country_restriction,cr.carrier_restriction,cr.group_restriction,cr.cart_rule_restriction');
        $dbQuery->select('cr.product_restriction,cr.shop_restriction,cr.free_shipping,cr.reduction_percent,cr.reduction_amount,cr.reduction_tax');
        $dbQuery->select('cr.reduction_currency,cr.reduction_product,cr.gift_product,cr.gift_product_attribute');
        $dbQuery->select('cr.highlight,cr.active,cr.date_add AS created_at,cr.date_upd AS updated_at');

        if (version_compare(_PS_VERSION_, '1.7', '>=')) {
            $dbQuery->select('cr.reduction_exclude_special');
        }

        $dbQuery->limit($limit, $offset);

        $queryStringified = preg_replace('/\s+/', ' ', $dbQuery->build());

        return array_merge(
            (array) $dbQuery,
            ['queryStringified' => $queryStringified]
        );
    }
}
