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
     * @param array<mixed> $wishlistIds
     *
     * @return \DbQuery
     */
    public function getBaseQuery(&$wishlistIds)
    {
        $query = new \DbQuery();

        $query->from('wishlist_product', 'wp');
        $query->where('wp.id_wishlist IN(' . implode(',', array_map('intval', $wishlistIds)) . ')');

        return $query;
    }

    /**
     * @param array<mixed> $wishlistIds
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getWishlistProducts(&$wishlistIds)
    {
        // need this module for this table : https://addons.prestashop.com/en/undownloadable/9131-wishlist-block.html
        if (empty($this->checkIfPsWishlistIsInstalled())) {
            return [];
        }

        $query = $this->getBaseQuery($wishlistIds);

        $this->addSelectParameters($query);

        return $this->db->executeS($query);
    }

    /**
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    private function checkIfPsWishlistIsInstalled()
    {
        $moduleisInstalledQuery = 'SELECT * FROM information_schema.tables WHERE table_name LIKE \'%wishlist\' LIMIT 1;';

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
