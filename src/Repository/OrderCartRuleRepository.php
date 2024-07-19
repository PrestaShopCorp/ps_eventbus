<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class OrderCartRuleRepository
{
    public const TABLE_NAME = 'order_cart_rule';

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

        $dbQuery->from(self::TABLE_NAME, 'ocr');

        return $dbQuery;
    }

    /**
     * @param array $orderIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getOrderCartRules(array $orderIds)
    {
        if ($orderIds === []) {
            return [];
        }

        $dbQuery = $this->getBaseQuery();

        $dbQuery->select('ocr.id_order_cart_rule,ocr.id_order,ocr.id_cart_rule,ocr.id_order_invoice,ocr.name,ocr.value,ocr.value_tax_excl, ocr.free_shipping');

        if (\Tools::version_compare(_PS_VERSION_, '1.7.7.0', '>=')) {
            $dbQuery->select('ocr.deleted');
        }
        $dbQuery->where('ocr.id_order IN (' . implode(',', array_map('intval', $orderIds)) . ')');

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param array $orderIds
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getOrderCartRuleIdsByOrderIds(array $orderIds)
    {
        if ($orderIds === []) {
            return [];
        }

        $dbQuery = $this->getBaseQuery();

        $dbQuery->select('ocr.id_order_cart_rule as id');
        $dbQuery->where('ocr.id_order IN (' . implode(',', array_map('intval', $orderIds)) . ')');

        $result = $this->db->executeS($dbQuery);

        return is_array($result) ? $result : [];
    }
}
