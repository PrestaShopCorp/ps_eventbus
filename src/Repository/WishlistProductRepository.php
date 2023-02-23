<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class WishlistProductRepository
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
    }

    /**
     * @param string $langIso
     *
     * @return \DbQuery
     */
    public function getBaseQuery($langIso)
    {
        $query = new \DbQuery();
        $query->from('wishlist_product', 'wp');

        return $query;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getWishlistProducts($offset, $limit, $langIso)
    {
        $query = $this->getBaseQuery($langIso);

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        return $this->db->executeS($query);
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('wp.id_wishlist_product, wp.id_wishlist, wp.id_product, wp.id_product_attribute,
      wp.quantity, wp.priority');
    }
}
