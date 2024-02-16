<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class WishlistRepository
{
    /**
     * @var PrestaShop\PrestaShop\Adapter\Entity\Db
     */
    private $db;

    /**
     * @var PrestaShop\PrestaShop\Adapter\Entity\Context
     */
    private $context;

    public function __construct(\Db $db, PrestaShop\PrestaShop\Adapter\Entity\Context $context)
    {
        $this->db = $db;
        $this->context = $context;
    }

    /**
     * @return PrestaShop\PrestaShop\Adapter\Entity\DbQuery
     */
    public function getBaseQuery()
    {
        if ($this->context->shop === null) {
            throw new PrestaShop\PrestaShop\Adapter\Entity\PrestaShopException('No shop context');
        }

        $shopId = (int) $this->context->shop->id;

        $query = new PrestaShop\PrestaShop\Adapter\Entity\DbQuery();
        $query->from('wishlist', 'w')
            ->where('w.id_shop = ' . $shopId);

        return $query;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws PrestaShop\PrestaShop\Adapter\Entity\PrestaShopDatabaseException
     */
    public function getWishlists($offset, $limit)
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
    public function getRemainingWishlistsCount($offset)
    {
        $query = $this->getBaseQuery()
            ->select('(COUNT(w.id_wishlist) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param array $wishlistIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws PrestaShop\PrestaShop\Adapter\Entity\PrestaShopDatabaseException
     */
    public function getWishlistsIncremental($limit, $wishlistIds)
    {
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->where('w.id_wishlist IN(' . implode(',', array_map('intval', $wishlistIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($query);
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
     *
     * @throws PrestaShop\PrestaShop\Adapter\Entity\PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit)
    {
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        $queryStringified = preg_replace('/\s+/', ' ', $query->build());

        return array_merge(
            (array) $query,
            ['queryStringified' => $queryStringified]
        );
    }

    /**
     * @param PrestaShop\PrestaShop\Adapter\Entity\DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('w.id_wishlist, w.id_customer, w.id_shop, w.id_shop_group, w.token, w.name, w.counter');
        $query->select('w.date_add AS created_at, w.date_upd as updated_at, w.default');
    }
}
