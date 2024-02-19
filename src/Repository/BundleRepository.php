<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class BundleRepository
{
    /**
     * @var \PrestaShop\PrestaShop\Adapter\Entity\Db
     */
    private $db;

    public function __construct(\Db $db)
    {
        $this->db = $db;
    }

    /**
     * @param int $productPackId
     *
     * @return \PrestaShop\PrestaShop\Adapter\Entity\DbQuery
     */
    private function getBaseQuery($productPackId)
    {
        $query = new \PrestaShop\PrestaShop\Adapter\Entity\DbQuery();

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
     * @throws \PrestaShop\PrestaShop\Adapter\Entity\PrestaShopDatabaseException
     */
    public function getBundleProducts($productPackId)
    {
        $query = $this->getBaseQuery($productPackId);

        $this->addSelectParameters($query);

        $result = $this->db->executeS($query);

        return is_array($result) ? $result : [];
    }

    /**
     * @param \PrestaShop\PrestaShop\Adapter\Entity\DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('pac.id_product_pack as id_bundle, pac.id_product_attribute_item as id_product_attribute');
        $query->select('p.id_product, pac.quantity');
    }
}
