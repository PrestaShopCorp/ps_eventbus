<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class CustomerRepository
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
    public function getBaseQuery()
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $shopId = (int) $this->context->shop->id;

        $query = new \DbQuery();
        $query->from('customer', 'c')
            ->where('c.id_shop = ' . $shopId);

        return $query;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCustomers($offset, $limit)
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
    public function getRemainingCustomersCount($offset)
    {
        $query = $this->getBaseQuery()
            ->select('(COUNT(c.id_customer) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param array<mixed> $customerIds
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCustomersIncremental($limit, $customerIds)
    {
        $query = $this->getBaseQuery();

        $this->addSelectParameters($query);

        $query->where('c.id_customer IN(' . implode(',', array_map('intval', $customerIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($query);
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

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('c.id_customer, c.id_lang, c.email, c.newsletter, c.newsletter_date_add');
        $query->select('c.optin, c.active, c.is_guest, c.deleted, c.date_add as created_at, c.date_upd as updated_at');
    }
}
