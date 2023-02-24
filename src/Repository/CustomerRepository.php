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
        $query->from('customer', 'c')
            ->where('c.id_shop = ' . (int) $shopId);

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
    public function getCustomers($offset, $limit, $langIso)
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
    public function getRemainingCustomersCount($offset, $langIso)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId, $langIso)
            ->select('(COUNT(c.id_customer) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array $customerIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCustomersIncremental($limit, $langIso, $customerIds)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId, $langIso);

        $this->addSelectParameters($query);

        $query->where('c.id_customer IN(' . implode(',', array_map('intval', $customerIds)) . ')')
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
        $query->select('c.id_customer, c.id_lang, c.email, c.newsletter, c.newsletter_date_add,
         c.optin, c.active, c.is_guest, c.deleted, c.date_add as created_at, c.date_upd as updated_at');
    }
}
