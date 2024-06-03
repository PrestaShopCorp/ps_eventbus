<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class OrderHistoryRepository
{
    public const TABLE_NAME = 'order_history';

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

        $query->from(self::TABLE_NAME, 'oh');

        return $query;
    }

    /**
     * @param array $orderIds
     * @param int $langId
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getOrderHistoryStatuses(array $orderIds, $langId)
    {
        if (!$orderIds) {
            return [];
        }

        $query = $this->getBaseQuery();

        $query->select('oh.id_order_state, osl.name, osl.template, oh.date_add, oh.id_order, oh.id_order_history')
            ->select('os.logable, os.delivery,  os.shipped, os.paid, os.deleted')
            ->innerJoin('order_state', 'os', 'os.id_order_state = oh.id_order_State')
            ->innerJoin('order_state_lang', 'osl', 'osl.id_order_state = os.id_order_State AND osl.id_lang = ' . (int) $langId)
            ->where('oh.id_order IN (' . implode(',', array_map('intval', $orderIds)) . ')')
        ;

        return $this->db->executeS($query);
    }

    /**
     * @param array $orderIds
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getOrderHistoryStatuseIdsByOrderIds(array $orderIds)
    {
        if (!$orderIds) {
            return [];
        }

        $query = $this->getBaseQuery();

        $query->select('oh.id_order_state as id')
            ->where('oh.id_order IN (' . implode(',', array_map('intval', $orderIds)) . ')')
        ;

        $result = $this->db->executeS($query);

        return is_array($result) ? $result : [];
    }
}
