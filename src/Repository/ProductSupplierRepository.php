<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class ProductSupplierRepository
{
    /**
     * @var \Db
     */
    private $db;

    public function __construct(\Db $db)
    {
        $this->db = $db;
    }

    /**
     * @return \DbQuery
     */
    public function getBaseQuery()
    {
        $query = new \DbQuery();
        $query->from('product_supplier', 'ps')
        ->innerJoin('product', 'p', 'p.id_product = ps.id_product');

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
    public function getProductSuppliers($offset, $limit)
    {
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        return $this->db->executeS($query);
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
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->where('ps.id_product IN(' . implode(',', array_map('intval', $productIds)) . ')')
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
        $query->select('ps.id_product_supplier, ps.id_product, ps.id_product_attribute, ps.id_supplier, ps.product_supplier_reference,
        ps.product_supplier_price_te, ps.id_currency, p.date_add AS created_at, p.date_upd as updated_at');
    }
}
