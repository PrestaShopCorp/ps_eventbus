<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use Context;
use Db;
use DbQuery;
use mysqli_result;
use PDOStatement;
use PrestaShopDatabaseException;

class CartRepository
{
    /**
     * @var Db
     */
    private $db;
    /**
     * @var Context
     */
    private $context;

    public function __construct(Db $db, Context $context)
    {
        $this->db = $db;
        $this->context = $context;
    }

    /**
     * @return DbQuery
     */
    private function getBaseQuery()
    {
        $query = new DbQuery();

        $query->from('cart', 'c')
            ->where('c.id_shop = ' . (int) $this->context->shop->id);

        return $query;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array|bool|mysqli_result|PDOStatement|resource|null
     *
     * @throws PrestaShopDatabaseException
     */
    public function getCarts($offset, $limit)
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
    public function getRemainingCartsCount($offset)
    {
        $query = $this->getBaseQuery();

        $query->select('(COUNT(c.id_cart) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param array $cartIds
     *
     * @return array
     *
     * @throws PrestaShopDatabaseException
     */
    public function getCartsIncremental($limit, $cartIds)
    {
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->where('c.id_cart IN(' . implode(',', array_map('intval', $cartIds)) . ')')
            ->limit($limit);

        $result = $this->db->executeS($query);

        return is_array($result) ? $result : [];
    }

    /**
     * @param DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(DbQuery $query)
    {
        $query->select('c.id_cart, date_add as created_at, date_upd as updated_at');
    }
}
