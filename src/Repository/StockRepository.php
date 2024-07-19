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

    public function __construct(\Context $context)
    {
        $this->db = \Db::getInstance();
        $this->context = $context;
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

        $dbQuery = new \DbQuery();
        $dbQuery->from('stock_available', 'sa')
            ->where('sa.id_shop = ' . (int) $shopId);

        return $dbQuery;
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
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->limit($limit, $offset);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param int $offset
     *
     * @return int
     */
    public function getRemainingStocksCount($offset)
    {
        $query = $this->getBaseQuery()
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
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->where('sa.id_product IN(' . implode(',', array_map('intval', $productIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit)
    {
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->limit($limit, $offset);

        $queryStringified = preg_replace('/\s+/', ' ', $dbQuery->build());

        return array_merge(
            (array) $dbQuery,
            ['queryStringified' => $queryStringified]
        );
    }

    /**
     * @param array $productIds
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getStocksIdsByProductIds(array $productIds)
    {
        if ($productIds === []) {
            return [];
        }

        $dbQuery = $this->getBaseQuery();

        $dbQuery->select('sa.id_stock_available as id');
        $dbQuery->where('sa.id_product IN (' . implode(',', array_map('intval', $productIds)) . ')');

        $result = $this->db->executeS($dbQuery);

        return is_array($result) ? $result : [];
    }

    /**
     * @param \DbQuery $dbQuery
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $dbQuery)
    {
        $dbQuery->select('sa.id_stock_available, sa.id_product, sa.id_product_attribute, sa.id_shop, sa.id_shop_group');
        $dbQuery->select('sa.quantity, sa.depends_on_stock, sa.out_of_stock');

        // https://github.com/PrestaShop/PrestaShop/commit/2a3269ad93b1985f2615d6604458061d4989f0ea#diff-e98d435095567c145b49744715fd575eaab7050328c211b33aa9a37158421ff4R2186
        if (version_compare(_PS_VERSION_, '1.7.2.0', '>=')) {
            $dbQuery->select('sa.physical_quantity, sa.reserved_quantity');
        }
        // https://github.com/PrestaShop/PrestaShop/commit/4c7d58a905dfb61c7fb2ef4a1f9b4fab2a8d8ecb#diff-e57fb1deeaab9e9079505333394d58f0bf7bb40280b4382aad1278c08c73e2e8R58
        if (version_compare(_PS_VERSION_, '1.7.5.0', '>=')) {
            $dbQuery->select('sa.location');
        }
    }
}
