<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class CartRepository
{
    /**
     * @var \Db
     */
    private $db;
    /**
     * @var \Context
     */
    private $context;

    public function __construct(\Context $context)
    {
        $this->db = \Db::getInstance();
        $this->context = $context;
    }

    /**
     * @return \DbQuery
     */
    private function getBaseQuery()
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $shopId = (int) $this->context->shop->id;

        $dbQuery = new \DbQuery();

        $dbQuery->from('cart', 'c')
            ->where('c.id_shop = ' . $shopId);

        return $dbQuery;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCarts($offset, $limit)
    {
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->limit($limit, $offset);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param int $offset
     *
     * @return int
     */
    public function getRemainingCartsCount($offset)
    {
        $dbQuery = $this->getBaseQuery();

        $dbQuery->select('(COUNT(c.id_cart) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($dbQuery);
    }

    /**
     * @param int $limit
     * @param array $cartIds
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCartsIncremental($limit, $cartIds)
    {
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->where('c.id_cart IN(' . implode(',', array_map('intval', $cartIds)) . ')')
            ->limit($limit);

        $result = $this->db->executeS($dbQuery);

        return is_array($result) ? $result : [];
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit)
    {
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->limit($limit, $offset);

        $queryStringified = preg_replace('/\s+/', ' ', $dbQuery->build());

        return array_merge(
            (array) $dbQuery,
            ['queryStringified' => $queryStringified]
        );
    }

    /**
     * @param \DbQuery $dbQuery
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $dbQuery)
    {
        $dbQuery->select('c.id_cart, date_add as created_at, date_upd as updated_at');
    }
}
