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

        if (!$this->context->employee instanceof \Employee) {
            if (($employees = \Employee::getEmployees()) !== false) {
                $this->context->employee = new \Employee($employees[0]['id_employee']);
            }
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

        $query = new \DbQuery();

        $query->from('specific_price', 'sp')
            ->leftJoin('country', 'c', 'c.id_country = sp.id_country')
            ->leftJoin('currency', 'cur', 'cur.id_currency = sp.id_currency');

        $query->where('sp.id_shop = 0 OR sp.id_shop = ' . $shopId);

        return $query;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getSpecificPrices($offset, $limit)
    {
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        $result = $this->db->executeS($query);

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
        $query = $this->getBaseQuery();

        $query->select('(COUNT(sp.id_specific_price) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('sp.id_specific_price, sp.id_product, sp.id_shop, sp.id_shop_group, sp.id_currency');
        $query->select('sp.id_country, sp.id_group, sp.id_customer, sp.id_product_attribute, sp.price, sp.from_quantity');
        $query->select('sp.reduction, sp.reduction_tax, sp.from, sp.to, sp.reduction_type');
        $query->select('c.iso_code as country');
        $query->select('cur.iso_code as currency');
    }

    /**
     * @param int $limit
     * @param array<mixed> $specificPriceIds
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getSpecificPricesIncremental($limit, $specificPriceIds)
    {
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->where('sp.id_specific_price IN(' . implode(',', array_map('intval', $specificPriceIds)) . ')')
            ->limit($limit);

        $result = $this->db->executeS($query);

        return is_array($result) ? $result : [];
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
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
}
