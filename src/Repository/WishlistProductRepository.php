<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class WishlistProductRepository
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
     * @param array $wishlistIds
     *
     * @return \DbQuery
     */
    public function getBaseQuery(array &$wishlistIds)
    {
        $query = new \DbQuery();

        $query->from('wishlist_product', 'wp');
        $query->where('wp.id_wishlist IN(' . implode(',', array_map('intval', $wishlistIds)) . ')');

        return $query;
    }

    /**
     * @param array $wishlistIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getWishlistProducts(array &$wishlistIds)
    {
        if (empty($this->checkIfPsWishlistIsInstalled())) {
            return [];
        }

        $query = $this->getBaseQuery($wishlistIds);

        $this->addSelectParameters($query);

        return $this->db->executeS($query);
    }

    private function checkIfPsWishlistIsInstalled() 
    {
        $moduleisInstalledQuery = new \DbQuery();

        $moduleisInstalledQuery->select('*');
        $moduleisInstalledQuery->from('information_schema.tables');
        $moduleisInstalledQuery->where('table_name LIKE \'%wishlist\'');
        $moduleisInstalledQuery->limit(1);

        return $this->db->executeS($moduleisInstalledQuery);
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('wp.id_wishlist_product, wp.id_wishlist, wp.id_product, wp.id_product_attribute');
        $query->select('wp.quantity, wp.priority');
    }
}
