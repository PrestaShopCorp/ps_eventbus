<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class SupplierRepository
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
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getSuppliers($offset, $limit, $langIso)
    {
        $query = $this->getBaseQuery($langIso);

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
    public function getRemainingSuppliersCount($offset, $langIso)
    {
        $query = $this->getBaseQuery($langIso)
            ->select('(COUNT(su.id_supplier) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array $supplierIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getSuppliersIncremental($limit, $langIso, $supplierIds)
    {
        $query = $this->getBaseQuery($langIso);

        $this->addSelectParameters($query);

        $query->where('su.id_supplier IN(' . implode(',', array_map('intval', $supplierIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($query);
    }

    /**
     * @param string $langIso
     *
     * @return \DbQuery
     */
    public function getBaseQuery($langIso)
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $shopId = (int) $this->context->shop->id;

        /** @var int $langId */
        $langId = (int) \Language::getIdByIso($langIso);
        $query = new \DbQuery();
        $query->from('supplier', 'su')
            ->innerJoin('supplier_lang', 'sul', 'su.id_supplier = sul.id_supplier AND sul.id_lang = ' . (int) $langId)
            ->innerJoin('supplier_shop', 'sus', 'su.id_supplier = sus.id_supplier AND sus.id_shop = ' . $shopId);

        return $query;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        $query = $this->getBaseQuery($langIso);

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
        $query->select('su.id_supplier, su.name, su.date_add as created_at, su.date_upd as updated_at, su.active, sul.id_lang');
        $query->select('sul.description, sul.meta_title, sul.meta_keywords, sul.meta_description, sus.id_shop');
    }
}
