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
        $query = new \DbQuery();

        $query->from('pack', 'pac')
            ->innerJoin('product', 'p', 'p.id_product = pac.id_product_item');

        $query->where('pac.id_product_pack = ' . (int) $productPackId);

        return $query;
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
        $query = $this->getBaseQuery($productPackId);

        $this->addSelectParameters($query);

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
        $query->select('pac.id_product_pack as id_bundle, pac.id_product_attribute_item as id_product_attribute');
        $query->select('p.id_product, pac.quantity');
    }
}
