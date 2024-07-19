<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class BundleRepository
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
     * @param int $productPackId
     *
     * @return \DbQuery
     */
    private function getBaseQuery($productPackId)
    {
        $dbQuery = new \DbQuery();

        $dbQuery->from('pack', 'pac')
            ->innerJoin('product', 'p', 'p.id_product = pac.id_product_item');

        $dbQuery->where('pac.id_product_pack = ' . (int) $productPackId);

        return $dbQuery;
    }

    /**
     * @param int $productPackId
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getBundleProducts($productPackId)
    {
        $dbQuery = $this->getBaseQuery($productPackId);

        $this->addSelectParameters($dbQuery);

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
        $dbQuery->select('pac.id_product_pack as id_bundle, pac.id_product_attribute_item as id_product_attribute');
        $dbQuery->select('p.id_product, pac.quantity');
    }
}
