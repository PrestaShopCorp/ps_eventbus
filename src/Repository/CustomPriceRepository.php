<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class CustomPriceRepository
{
    /**
     * @var \Context
     */
    private $context;
    /**
     * @var \Db
     */
    private $db;

    public function __construct(\Context $context)
    {
        $this->db = \Db::getInstance();
        $this->context = $context;

        if (!$this->context->employee instanceof \Employee && ($employees = \Employee::getEmployees()) !== false) {
            $this->context->employee = new \Employee($employees[0]['id_employee']);
        }
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

        $dbQuery->from('specific_price', 'sp')
            ->leftJoin('country', 'c', 'c.id_country = sp.id_country')
            ->leftJoin('currency', 'cur', 'cur.id_currency = sp.id_currency');

        $dbQuery->where('sp.id_shop = 0 OR sp.id_shop = ' . $shopId);

        return $dbQuery;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getSpecificPrices($offset, $limit)
    {
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->limit($limit, $offset);

        $result = $this->db->executeS($dbQuery);

        return is_array($result) ? $result : [];
    }

    /**
     * @param int $offset
     *
     * @return int
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getRemainingSpecificPricesCount($offset)
    {
        $dbQuery = $this->getBaseQuery();

        $dbQuery->select('(COUNT(sp.id_specific_price) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($dbQuery);
    }

    /**
     * @param \DbQuery $dbQuery
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $dbQuery)
    {
        $dbQuery->select('sp.id_specific_price, sp.id_product, sp.id_shop, sp.id_shop_group, sp.id_currency');
        $dbQuery->select('sp.id_country, sp.id_group, sp.id_customer, sp.id_product_attribute, sp.price, sp.from_quantity');
        $dbQuery->select('sp.reduction, sp.reduction_tax, sp.from, sp.to, sp.reduction_type');
        $dbQuery->select('c.iso_code as country');
        $dbQuery->select('cur.iso_code as currency');
    }

    /**
     * @param int $limit
     * @param array $specificPriceIds
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getSpecificPricesIncremental($limit, $specificPriceIds)
    {
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->where('sp.id_specific_price IN(' . implode(',', array_map('intval', $specificPriceIds)) . ')')
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
}
