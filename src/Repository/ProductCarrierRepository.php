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
        $query = new \DbQuery();

        $query->from('product_carrier', 'pc');
        $query->where('pc.id_shop = ' . $this->shopId);

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
    public function getProductCarriers($offset, $limit)
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
    public function getRemainingProductCarriersCount($offset)
    {
        $productCarriers = $this->getProductCarriers($offset, 1);

        if (!is_array($productCarriers) || empty($productCarriers)) {
            return 0;
        }

        return count($productCarriers);
    }

    /**
     * @param string $type
     * @param string $langIso
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getProductCarrierIncremental($type, $langIso)
    {
        $query = new \DbQuery();
        $query->from(IncrementalSyncRepository::INCREMENTAL_SYNC_TABLE, 'aic');
        $query->leftJoin(EventbusSyncRepository::TYPE_SYNC_TABLE_NAME, 'ts', 'ts.type = aic.type');
        $query->where('aic.type = "' . (string) $type . '"');
        $query->where('ts.id_shop = ' . $this->shopId);
        $query->where('ts.lang_iso = "' . (string) $langIso . '"');

        return $this->db->executeS($query);
    }

    /**
     * @param array<mixed> $productIds
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getProductCarriersProperties($productIds)
    {
        if (!$productIds) {
            return [];
        }
        $query = new \DbQuery();

        $query->select('pc.*')
            ->from('product_carrier', 'pc')
            ->where('pc.id_product IN (' . implode(',', array_map('intval', $productIds)) . ')');

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
     * @param array<mixed> $productIds
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getProductCarrierIdsByProductIds($productIds)
    {
        if (!$productIds) {
            return [];
        }

        $query = $this->getBaseQuery();

        $query->select('pc.id_carrier_reference as id');
        $query->where('pc.id_product IN (' . implode(',', array_map('intval', $productIds)) . ')');

        $result = $this->db->executeS($query);

        return is_array($result) ? $result : [];
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        $query->select('pc.id_carrier_reference, pc.id_product');
    }
}
