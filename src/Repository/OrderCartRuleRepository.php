<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class OrderCartRuleRepository
{
    const TABLE_NAME = 'order_cart_rule';

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

        $query->from(self::TABLE_NAME, 'ocr');

        return $query;
    }

    /**
     * @param array<mixed> $orderIds
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getOrderCartRules($orderIds)
    {
        if (!$orderIds) {
            return [];
        }

        $query = $this->getBaseQuery();

        $query->select('ocr.id_order_cart_rule,ocr.id_order,ocr.id_cart_rule,ocr.id_order_invoice,ocr.name,ocr.value,ocr.value_tax_excl, ocr.free_shipping');

        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.7.0', '>=')) {
            $query->select('ocr.deleted');
        }
        $query->where('ocr.id_order IN (' . implode(',', array_map('intval', $orderIds)) . ')');

        return $this->db->executeS($query);
    }

    /**
     * @param array<mixed> $orderIds
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getOrderCartRuleIdsByOrderIds($orderIds)
    {
        if (!$orderIds) {
            return [];
        }

        $query = $this->getBaseQuery();

        $query->select('ocr.id_order_cart_rule as id');
        $query->where('ocr.id_order IN (' . implode(',', array_map('intval', $orderIds)) . ')');

        $result = $this->db->executeS($query);

        return is_array($result) ? $result : [];
    }
}
