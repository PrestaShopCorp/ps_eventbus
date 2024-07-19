<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class ProductSupplierRepository
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
        $dbQuery->from('product_supplier', 'ps');

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
    public function getProductSuppliers($offset, $limit)
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
    public function getRemainingProductSuppliersCount($offset)
    {
        $query = $this->getBaseQuery()
            ->select('(COUNT(ps.id_product_supplier) - ' . (int) $offset . ') as count');

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
    public function getProductSuppliersIncremental($limit, $productIds)
    {
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->where('ps.id_product IN(' . implode(',', array_map('intval', $productIds)) . ')')
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
     * @param \DbQuery $dbQuery
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $dbQuery)
    {
        $dbQuery->select('ps.id_product_supplier, ps.id_product, ps.id_product_attribute, ps.id_supplier, ps.product_supplier_reference');
        $dbQuery->select('ps.product_supplier_price_te, ps.id_currency');
    }
}
