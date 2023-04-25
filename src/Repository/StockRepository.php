<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class StockRepository
{
    /**
     * @var \Db
     */
    private $db;

    /**
     * @var \Context
     */
    private $context;

    public function __construct(\Db $db, \Context $context)
    {
        $this->db = $db;
        $this->context = $context;
    }

    /**
     * @param int $shopId
     *
     * @return \DbQuery
     */
    public function getBaseQuery($shopId)
    {
        $query = new \DbQuery();
        $query->from('stock_available', 'sa')
        ->innerJoin('product', 'p', 'p.id_product = sa.id_product')
        ->where('sa.id_shop = ' . (int) $shopId);

        return $query;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getStocks($offset, $limit)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId);

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        return $this->db->executeS($query);
    }

    /**
     * @param int $offset
     *
     * @return int
     */
    public function getRemainingStocksCount($offset)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId)
            ->select('(COUNT(sa.id_stock_available) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param array $productIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getStocksIncremental($limit, $productIds)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId);

        $this->addSelectParameters($query);

        $query->where('sa.id_product IN(' . implode(',', array_map('intval', $productIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($query);
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('sa.id_stock_available, sa.id_product, sa.id_product_attribute, sa.id_shop, sa.id_shop_group,
        sa.quantity, sa.physical_quantity, sa.reserved_quantity, sa.depends_on_stock, sa.out_of_stock, sa.location,
        p.date_add AS created_at, p.date_upd as updated_at');
    }
}
