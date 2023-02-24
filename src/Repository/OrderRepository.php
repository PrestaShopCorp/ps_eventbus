<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class OrderRepository
{
    public const ORDERS_TABLE = 'orders';

    /**
     * @var \Db
     */
    private $db;

    public function __construct(\Db $db)
    {
        $this->db = $db;
    }

    /**
     * @param int $shopId
     *
     * @return \DbQuery
     */
    public function getBaseQuery($shopId)
    {
        $query = new \DbQuery();
        $query->from(self::ORDERS_TABLE, 'o')
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

        return $query;
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
        $query = $this->getBaseQuery($shopId);

        $this->addSelectParameters($query);

        $query->limit((int) $limit, (int) $offset);

        return $this->db->executeS($query);
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

        if (!is_array($orders) || empty($orders)) {
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
        $query = $this->getBaseQuery($shopId);

        $this->addSelectParameters($query);

        $query->where('o.id_order IN(' . implode(',', array_map('intval', $orderIds)) . ')')
            ->limit($limit);

        $result = $this->db->executeS($query);

        return is_array($result) ? $result : [];
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('o.id_order, o.reference, o.id_customer, o.id_cart, o.current_state,
         o.conversion_rate, o.total_paid_tax_excl, o.total_paid_tax_incl,
         IF((SELECT so.id_order FROM `' . _DB_PREFIX_ . 'orders` so WHERE so.id_customer = o.id_customer AND so.id_order < o.id_order LIMIT 1) > 0, 0, 1) as new_customer,
         c.iso_code as currency, SUM(os.total_products_tax_incl + os.total_shipping_tax_incl) as refund,
         SUM(os.total_products_tax_excl + os.total_shipping_tax_excl) as refund_tax_excl, o.module as payment_module,
         o.payment as payment_mode, o.total_paid_real, o.total_shipping as shipping_cost, o.date_add as created_at,
         o.date_upd as updated_at, o.id_carrier,
         o.payment as payment_name,
         CONCAT(CONCAT("delivery", ":", cntd.iso_code), ",", CONCAT("invoice", ":", cnti.iso_code)) as address_iso,
         o.valid as is_validated,
         ost.paid as is_paid,
         ost.shipped as is_shipped,
         osl.name as status_label,
         o.module as payment_name'
        );
    }
}
