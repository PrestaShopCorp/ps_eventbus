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
        $dbQuery = new \DbQuery();

        $dbQuery->from('wishlist_product', 'wp');
        $dbQuery->where('wp.id_wishlist IN(' . implode(',', array_map('intval', $wishlistIds)) . ')');

        return $dbQuery;
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
        // need this module for this table : https://addons.prestashop.com/en/undownloadable/9131-wishlist-block.html
        if (empty($this->checkIfPsWishlistIsInstalled())) {
            return [];
        }

        $dbQuery = $this->getBaseQuery($wishlistIds);

        $this->addSelectParameters($dbQuery);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    private function checkIfPsWishlistIsInstalled()
    {
        $moduleisInstalledQuery = 'SELECT * FROM information_schema.tables WHERE table_name LIKE \'%wishlist\' LIMIT 1;';

        return $this->db->executeS($moduleisInstalledQuery);
    }

    /**
     * @param \DbQuery $dbQuery
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $dbQuery)
    {
        $dbQuery->select('wp.id_wishlist_product, wp.id_wishlist, wp.id_product, wp.id_product_attribute');
        $dbQuery->select('wp.quantity, wp.priority');
    }
}
