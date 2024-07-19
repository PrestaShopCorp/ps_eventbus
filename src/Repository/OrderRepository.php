<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class OrderRepository
{
    public const ORDERS_TABLE = 'orders';

    /**
     * @var \Db
     */
    private $db;

    public function __construct()
    {
        $this->db = \Db::getInstance();
    }

    /**
     * @param int $shopId
     *
     * @return \DbQuery
     */
    public function getBaseQuery($shopId)
    {
        $dbQuery = new \DbQuery();
        $dbQuery->from(self::ORDERS_TABLE, 'o')
            ->leftJoin('currency', 'c', 'o.id_currency = c.id_currency')
            ->leftJoin('order_slip', 'os', 'o.id_order = os.id_order')
            ->leftJoin('address', 'ad', 'ad.id_address = o.id_address_delivery')
            ->leftJoin('address', 'ai', 'ai.id_address = o.id_address_invoice')
            ->leftJoin('country', 'cntd', 'cntd.id_country = ad.id_country')
            ->leftJoin('country', 'cnti', 'cnti.id_country = ai.id_country')
            ->leftJoin('order_state_lang', 'osl', 'o.current_state = osl.id_order_state')
            ->leftJoin('order_state', 'ost', 'o.current_state = ost.id_order_state')
            ->where('o.id_shop = ' . (int) $shopId)
            ->groupBy('o.id_order');

        return $dbQuery;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param int $shopId
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getOrders($offset, $limit, $shopId)
    {
        $dbQuery = $this->getBaseQuery($shopId);

        $this->addSelectParameters($dbQuery);

        $dbQuery->limit((int) $limit, (int) $offset);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param int $offset
     * @param int $shopId
     *
     * @return int
     */
    public function getRemainingOrderCount($offset, $shopId)
    {
        $orders = $this->getOrders($offset, 1, $shopId);

        if (!is_array($orders) || $orders === []) {
            return 0;
        }

        return count($orders);
    }

    /**
     * @param int $limit
     * @param int $shopId
     * @param array $orderIds
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getOrdersIncremental($limit, $shopId, $orderIds)
    {
        $dbQuery = $this->getBaseQuery($shopId);

        $this->addSelectParameters($dbQuery);

        $dbQuery->where('o.id_order IN(' . implode(',', array_map('intval', $orderIds)) . ')')
            ->limit($limit);

        $result = $this->db->executeS($dbQuery);

        return is_array($result) ? $result : [];
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param int $shopId
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $shopId)
    {
        $dbQuery = $this->getBaseQuery($shopId);

        $this->addSelectParameters($dbQuery);

        $dbQuery->limit((int) $limit, (int) $offset);

        $queryStringified = preg_replace('/\s+/', ' ', $dbQuery->build());

        return array_merge(
            (array) $dbQuery,
            ['queryStringified' => $queryStringified]
        );
    }

    /**
     * @param \DbQuery $dbQuery
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $dbQuery)
    {
        $dbQuery->select('o.id_order, o.reference, o.id_customer, o.id_cart, o.current_state');
        $dbQuery->select('o.conversion_rate, o.total_paid_tax_excl, o.total_paid_tax_incl');
        $dbQuery->select('IF((SELECT so.id_order FROM `' . _DB_PREFIX_ . 'orders` so WHERE so.id_customer = o.id_customer AND so.id_order < o.id_order LIMIT 1) > 0, 0, 1) as new_customer');
        $dbQuery->select('c.iso_code as currency, SUM(os.total_products_tax_incl + os.total_shipping_tax_incl) as refund');
        $dbQuery->select('SUM(os.total_products_tax_excl + os.total_shipping_tax_excl) as refund_tax_excl, o.module as payment_module');
        $dbQuery->select('o.payment as payment_mode, o.total_paid_real, o.total_shipping as shipping_cost, o.date_add as created_at');
        $dbQuery->select('o.date_upd as updated_at, o.id_carrier');
        $dbQuery->select('o.payment as payment_name');
        $dbQuery->select('CONCAT(CONCAT("delivery", ":", cntd.iso_code), ",", CONCAT("invoice", ":", cnti.iso_code)) as address_iso');
        $dbQuery->select('o.valid as is_validated');
        $dbQuery->select('ost.paid as is_paid');
        $dbQuery->select('ost.shipped as is_shipped');
        $dbQuery->select('osl.name as status_label');
        $dbQuery->select('o.module as payment_name');
    }
}
