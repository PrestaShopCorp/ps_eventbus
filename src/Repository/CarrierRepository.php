<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class CarrierRepository
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
     * @param \Carrier $carrier
     *
     * @return array|false
     */
    public function getDeliveryPriceByRange(\Carrier $carrier)
    {
        $rangeTable = $carrier->getRangeTable();
        switch ($rangeTable) {
            case 'range_weight':
                return $this->getCarrierByWeightRange($carrier, 'range_weight');
            case 'range_price':
                return $this->getCarrierByPriceRange($carrier, 'range_price');
            default:
                return false;
        }
    }

    /**
     * @param \Carrier $carrier
     * @param string $rangeTable
     *
     * @return array
     */
    private function getCarrierByPriceRange(
        \Carrier $carrier,
        $rangeTable
    ) {
        $deliveryPriceByRange = \Carrier::getDeliveryPriceByRanges($rangeTable, (int) $carrier->id);

        $filteredRanges = [];
        foreach ($deliveryPriceByRange as $deliveryPrice) {
            $filteredRanges[$deliveryPrice['id_range_price']]['id_range_price'] = $deliveryPrice['id_range_price'];
            $filteredRanges[$deliveryPrice['id_range_price']]['id_carrier'] = $deliveryPrice['id_carrier'];
            $filteredRanges[$deliveryPrice['id_range_price']]['zones'][$deliveryPrice['id_zone']]['id_zone'] = $deliveryPrice['id_zone'];
            $filteredRanges[$deliveryPrice['id_range_price']]['zones'][$deliveryPrice['id_zone']]['price'] = $deliveryPrice['price'];
        }

        return $filteredRanges;
    }

    /**
     * @param \Carrier $carrier
     * @param string $rangeTable
     *
     * @return array
     */
    private function getCarrierByWeightRange(
        \Carrier $carrier,
        $rangeTable
    ) {
        $deliveryPriceByRange = \Carrier::getDeliveryPriceByRanges($rangeTable, (int) $carrier->id);

        $filteredRanges = [];
        foreach ($deliveryPriceByRange as $deliveryPrice) {
            $filteredRanges[$deliveryPrice['id_range_weight']]['id_range_weight'] = $deliveryPrice['id_range_weight'];
            $filteredRanges[$deliveryPrice['id_range_weight']]['id_carrier'] = $deliveryPrice['id_carrier'];
            $filteredRanges[$deliveryPrice['id_range_weight']]['zones'][$deliveryPrice['id_zone']]['id_zone'] = $deliveryPrice['id_zone'];
            $filteredRanges[$deliveryPrice['id_range_weight']]['zones'][$deliveryPrice['id_zone']]['price'] = $deliveryPrice['price'];
        }

        return $filteredRanges;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param int $langId
     *
     * @return \DbQuery
     */
    private function getAllCarriersQuery($offset, $limit, $langId)
    {
        $dbQuery = new \DbQuery();
        $dbQuery->from('carrier', 'c');
        $dbQuery->select('c.id_carrier');
        $dbQuery->leftJoin('carrier_lang', 'cl', 'cl.id_carrier = c.id_carrier AND cl.id_lang = ' . (int) $langId);
        $dbQuery->leftJoin('carrier_shop', 'cs', 'cs.id_carrier = c.id_carrier');
        $dbQuery->where('cs.id_shop = ' . $this->shopId);
        $dbQuery->where('deleted=0');
        $dbQuery->limit($limit, $offset);

        return $dbQuery;
    }

    /**
     * @param string $type
     * @param string $langIso
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getShippingIncremental($type, $langIso)
    {
        $dbQuery = new \DbQuery();
        $dbQuery->from(IncrementalSyncRepository::INCREMENTAL_SYNC_TABLE, 'aic');
        $dbQuery->leftJoin(EventbusSyncRepository::TYPE_SYNC_TABLE_NAME, 'ts', 'ts.type = aic.type');
        $dbQuery->where('aic.type = "' . pSQL($type) . '"');
        $dbQuery->where('ts.id_shop = ' . $this->shopId);
        $dbQuery->where('ts.lang_iso = "' . pSQL($langIso) . '"');

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param array $deliveryPriceByRange
     *
     * @return false|\RangeWeight|\RangePrice
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function getCarrierRange(array $deliveryPriceByRange)
    {
        if (isset($deliveryPriceByRange['id_range_weight'])) {
            return new \RangeWeight($deliveryPriceByRange['id_range_weight']);
        }
        if (isset($deliveryPriceByRange['id_range_price'])) {
            return new \RangePrice($deliveryPriceByRange['id_range_price']);
        }

        return false;
    }

    /**
     * @param int[] $carrierIds
     * @param int $langId
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCarrierProperties($carrierIds, $langId)
    {
        if (!$carrierIds) {
            return [];
        }
        $dbQuery = new \DbQuery();
        $dbQuery->from('carrier', 'c');
        $dbQuery->select('c.*, cl.delay');
        $dbQuery->leftJoin('carrier_lang', 'cl', 'cl.id_carrier = c.id_carrier AND cl.id_lang = ' . (int) $langId);
        $dbQuery->leftJoin('carrier_shop', 'cs', 'cs.id_carrier = c.id_carrier');
        $dbQuery->where('c.id_carrier IN (' . implode(',', array_map('intval', $carrierIds)) . ')');
        $dbQuery->where('cs.id_shop = ' . $this->shopId);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param int $langId
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getAllCarrierProperties($offset, $limit, $langId)
    {
        return $this->db->executeS($this->getAllCarriersQuery($offset, $limit, $langId));
    }

    /**
     * @param int $offset
     * @param int $langId
     *
     * @return int
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getRemainingCarriersCount($offset, $langId)
    {
        $carriers = $this->getAllCarrierProperties($offset, 1, $langId);

        if (!is_array($carriers) || $carriers === []) {
            return 0;
        }

        return count($carriers);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param int $langId
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langId)
    {
        $dbQuery = $this->getAllCarriersQuery($offset, $limit, $langId);
        $queryStringified = preg_replace('/\s+/', ' ', $dbQuery->build());

        return array_merge(
            (array) $dbQuery,
            ['queryStringified' => $queryStringified]
        );
    }
}
