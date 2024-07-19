<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class ProductCarrierRepository
{
    /**
     * @var \Db
     */
    private $db;
    /**
     * @var \Context
     */
    private $context;

    /**
     * @var int
     */
    private $shopId;

    public function __construct(\Context $context)
    {
        $this->db = \Db::getInstance();
        $this->context = $context;

        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $this->shopId = (int) $this->context->shop->id;
    }

    /**
     * @return \DbQuery
     */
    private function getBaseQuery()
    {
        $dbQuery = new \DbQuery();

        $dbQuery->from('product_carrier', 'pc');
        $dbQuery->where('pc.id_shop = ' . $this->shopId);

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
    public function getProductCarriers($offset, $limit)
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
    public function getRemainingProductCarriersCount($offset)
    {
        $productCarriers = $this->getProductCarriers($offset, 1);

        if (!is_array($productCarriers) || $productCarriers === []) {
            return 0;
        }

        return count($productCarriers);
    }

    /**
     * @param string $type
     * @param string $langIso
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getProductCarrierIncremental($type, $langIso)
    {
        $dbQuery = new \DbQuery();
        $dbQuery->from(IncrementalSyncRepository::INCREMENTAL_SYNC_TABLE, 'aic');
        $dbQuery->leftJoin(EventbusSyncRepository::TYPE_SYNC_TABLE_NAME, 'ts', 'ts.type = aic.type');
        $dbQuery->where('aic.type = "' . (string) $type . '"');
        $dbQuery->where('ts.id_shop = ' . $this->shopId);
        $dbQuery->where('ts.lang_iso = "' . (string) $langIso . '"');

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param array $productIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getProductCarriersProperties(array $productIds)
    {
        if ($productIds === []) {
            return [];
        }
        $dbQuery = new \DbQuery();

        $dbQuery->select('pc.*')
            ->from('product_carrier', 'pc')
            ->where('pc.id_product IN (' . implode(',', array_map('intval', $productIds)) . ')');

        return $this->db->executeS($dbQuery);
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
     * @param array $productIds
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getProductCarrierIdsByProductIds(array $productIds)
    {
        if ($productIds === []) {
            return [];
        }

        $dbQuery = $this->getBaseQuery();

        $dbQuery->select('pc.id_carrier_reference as id');
        $dbQuery->where('pc.id_product IN (' . implode(',', array_map('intval', $productIds)) . ')');

        $result = $this->db->executeS($dbQuery);

        return is_array($result) ? $result : [];
    }

    /**
     * @param \DbQuery $dbQuery
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $dbQuery)
    {
        $dbQuery->select('pc.id_carrier_reference, pc.id_product');
    }
}
