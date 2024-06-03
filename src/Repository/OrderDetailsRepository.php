<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class OrderDetailsRepository
{
    public const TABLE_NAME = 'order_detail';

    /**
     * @var \Db
     */
    private $db;
    /**
     * @var \Context
     */
    private $context;

    public function __construct(\Context $context)
    {
        $this->context = $context;
        $this->db = \Db::getInstance();
    }

    /**
     * @return \DbQuery
     */
    public function getBaseQuery()
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $shopId = (int) $this->context->shop->id;

        $query = new \DbQuery();

        $query->from(self::TABLE_NAME, 'od')
            ->where('od.id_shop = ' . $shopId);

        return $query;
    }

    /**
     * @param array $orderIds
     * @param int $shopId
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getOrderDetails(array $orderIds, $shopId)
    {
        if (!$orderIds) {
            return [];
        }

        $query = $this->getBaseQuery();

        $query->select('od.id_order_detail, od.id_order, od.product_id, od.product_attribute_id');
        $query->select('od.product_quantity, od.unit_price_tax_incl, od.unit_price_tax_excl, SUM(osd.total_price_tax_incl) as refund');
        $query->select('SUM(osd.total_price_tax_excl) as refund_tax_excl, c.iso_code as currency, ps.id_category_default as category');
        $query->select('l.iso_code, o.conversion_rate as conversion_rate')
            ->leftJoin('order_slip_detail', 'osd', 'od.id_order_detail = osd.id_order_detail')
            ->leftJoin('product_shop', 'ps', 'od.product_id = ps.id_product AND ps.id_shop = ' . (int) $shopId)
            ->innerJoin('orders', 'o', 'od.id_order = o.id_order')
            ->leftJoin('currency', 'c', 'c.id_currency = o.id_currency')
            ->leftJoin('lang', 'l', 'o.id_lang = l.id_lang')
            ->where('od.id_order IN (' . implode(',', array_map('intval', $orderIds)) . ')')
            ->groupBy('od.id_order_detail');

        return $this->db->executeS($query);
    }

    /**
     * @param array $orderIds
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getOrderDetailIdsByOrderIds(array $orderIds)
    {
        if (!$orderIds) {
            return [];
        }

        $query = $this->getBaseQuery();

        $query->select('od.id_order_detail as id')
            ->where('od.id_order IN (' . implode(',', array_map('intval', $orderIds)) . ')')
            ->groupBy('od.id_order_detail');

        $result = $this->db->executeS($query);

        return is_array($result) ? $result : [];
    }
}
