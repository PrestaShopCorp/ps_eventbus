<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class StoreRepository
{
    public const STORES_TABLE = 'store';

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
        $langId = (int) \Language::getIdByIso($langIso);

        $dbQuery = new \DbQuery();

        // https://github.com/PrestaShop/PrestaShop/commit/7dda2be62d8bd606edc269fa051c36ea68f81682#diff-e98d435095567c145b49744715fd575eaab7050328c211b33aa9a37158421ff4R2004
        if (version_compare(_PS_VERSION_, '1.7.3.0', '>=')) {
            $dbQuery->from(self::STORES_TABLE, 's')
                ->leftJoin('store_lang', 'sl', 's.id_store = sl.id_store')
                ->leftJoin('store_shop', 'ss', 's.id_store = ss.id_store')
                ->where('ss.id_shop = ' . (int) $shopId)
                ->where('sl.id_lang = ' . (int) $langId);
        } else {
            $dbQuery->from(self::STORES_TABLE, 's');
        }

        return $dbQuery;
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
    public function getStores($offset, $limit, $langIso)
    {
        $dbQuery = $this->getBaseQuery($langIso);

        $this->addSelectParameters($dbQuery);

        $dbQuery->limit((int) $limit, (int) $offset);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingStoreCount($offset, $langIso)
    {
        $stores = $this->getStores($offset, 1, $langIso);

        if (!is_array($stores) || $stores === []) {
            return 0;
        }

        return count($stores);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array $storeIds
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getStoresIncremental($limit, $langIso, $storeIds)
    {
        $dbQuery = $this->getBaseQuery($langIso);

        $this->addSelectParameters($dbQuery);

        $dbQuery->where('s.id_store IN(' . implode(',', array_map('intval', $storeIds)) . ')')
            ->limit($limit);

        $result = $this->db->executeS($dbQuery);

        return is_array($result) ? $result : [];
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
        $dbQuery = $this->getBaseQuery($langIso);

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
        $dbQuery->select('s.id_store');
        $dbQuery->select('s.id_country');
        $dbQuery->select('s.id_state');
        $dbQuery->select('s.city');
        $dbQuery->select('s.postcode');
        $dbQuery->select('s.active');
        $dbQuery->select('s.date_add as created_at');
        $dbQuery->select('s.date_upd as updated_at');

        // https://github.com/PrestaShop/PrestaShop/commit/7dda2be62d8bd606edc269fa051c36ea68f81682#diff-e98d435095567c145b49744715fd575eaab7050328c211b33aa9a37158421ff4R2004
        if (version_compare(_PS_VERSION_, '1.7.3.0', '>=')) {
            $dbQuery->select('sl.id_lang');
            $dbQuery->select('sl.name');
            $dbQuery->select('sl.address1');
            $dbQuery->select('sl.address2');
            $dbQuery->select('sl.hours');
            $dbQuery->select('ss.id_shop');
        } else {
            $dbQuery->select('s.name');
            $dbQuery->select('s.address1');
            $dbQuery->select('s.address2');
            $dbQuery->select('s.hours');
        }
    }
}
