<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class WishlistRepository
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
        $this->context = $context;
    }

    /**
     * @param int $shopId
     * @param string $langIso
     *
     * @return \DbQuery
     */
    public function getBaseQuery($shopId, $langIso)
    {
        $query = new \DbQuery();
        $query->from('wishlist', 'w')
            ->where('w.id_shop = ' . (int) $shopId);

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
    public function getWishlists($offset, $limit, $langIso)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId, $langIso);

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        return $this->db->executeS($query);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingWishlistsCount($offset, $langIso)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId, $langIso)
            ->select('(COUNT(w.id_wishlist) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array $wishlistIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getWishlistsIncremental($limit, $langIso, $wishlistIds)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId, $langIso);

        $this->addSelectParameters($query);

        $query->where('w.id_wishlist IN(' . implode(',', array_map('intval', $wishlistIds)) . ')')
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
        $query->select('w.id_wishlist, w.id_customer, w.id_shop, w.id_shop_group, w.token, w.name, w.counter,
      w.date_add AS created_at, w.date_upd as updated_at, w.default');
    }
}
