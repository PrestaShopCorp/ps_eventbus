<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use Db;
use DbQuery;

class OrderStateHistoryRepository
{
    const TABLE_NAME = 'order_history';

    /**
     * @var Db
     */
    private $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    /**
     * @return DbQuery
     */
    public function getBaseQuery($orderId)
    {
        $query = new DbQuery();

        $query->select('oh.id_order, oh.id_order_history, oh.date_add, osl.name')
            ->from(self::TABLE_NAME, 'oh')
            ->innerJoin('order_state_lang', 'osl', 'osl.id_order_state = oh.id_order_state')
            ->where('oh.id_order = ' . (int) $orderId)
            ->groupBy('oh.id_order');

        return $query;
    }

    /**
     * @param $offset
     * @param $limit
     * @param $orderId
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getOrderStateHistory($offset, $limit, $orderId)
    {
        $query = $this->getBaseQuery($orderId);

        $query->limit((int) $limit, (int) $offset);

        return $this->db->executeS($query);
    }
}
