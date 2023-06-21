<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use PrestaShop\Module\PsEventbus\Config\Config;

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

    public function __construct(\Db $db, \Context $context)
    {
        $this->db = $db;
        $this->context = $context;
    }

    /**
     * @param \Carrier $carrierObj
     *
     * @return array|false
     */
    public function getDeliveryPriceByRange(\Carrier $carrierObj)
    {
        $rangeTable = $carrierObj->getRangeTable();
        switch ($rangeTable) {
            case 'range_weight':
                return $this->getCarrierByWeightRange($carrierObj, 'range_weight');
            case 'range_price':
                return $this->getCarrierByPriceRange($carrierObj, 'range_price');
            default:
                return false;
        }
    }

    /**
     * @param \Carrier $carrierObj
     * @param string $rangeTable
     *
     * @return array
     */
    private function getCarrierByPriceRange(
        \Carrier $carrierObj,
        $rangeTable
    ) {
        $deliveryPriceByRange = \Carrier::getDeliveryPriceByRanges($rangeTable, (int) $carrierObj->id);

        $filteredRanges = [];
        foreach ($deliveryPriceByRange as $range) {
            $filteredRanges[$range['id_range_price']]['id_range_price'] = $range['id_range_price'];
            $filteredRanges[$range['id_range_price']]['id_carrier'] = $range['id_carrier'];
            $filteredRanges[$range['id_range_price']]['zones'][$range['id_zone']]['id_zone'] = $range['id_zone'];
            $filteredRanges[$range['id_range_price']]['zones'][$range['id_zone']]['price'] = $range['price'];
        }

        return $filteredRanges;
    }

    /**
     * @param \Carrier $carrierObj
     * @param string $rangeTable
     *
     * @return array
     */
    private function getCarrierByWeightRange(
        \Carrier $carrierObj,
        $rangeTable
    ) {
        $deliveryPriceByRange = \Carrier::getDeliveryPriceByRanges($rangeTable, (int) $carrierObj->id);

        $filteredRanges = [];
        foreach ($deliveryPriceByRange as $range) {
            $filteredRanges[$range['id_range_weight']]['id_range_weight'] = $range['id_range_weight'];
            $filteredRanges[$range['id_range_weight']]['id_carrier'] = $range['id_carrier'];
            $filteredRanges[$range['id_range_weight']]['zones'][$range['id_zone']]['id_zone'] = $range['id_zone'];
            $filteredRanges[$range['id_range_weight']]['zones'][$range['id_zone']]['price'] = $range['price'];
        }

        return $filteredRanges;
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
        $query = new \DbQuery();
        $query->from(IncrementalSyncRepository::INCREMENTAL_SYNC_TABLE, 'aic');
        $query->leftJoin(EventbusSyncRepository::TYPE_SYNC_TABLE_NAME, 'ts', 'ts.type = aic.type');
        $query->where('aic.type = "' . pSQL($type) . '"');
        $query->where('ts.id_shop = ' . (int) $this->context->shop->id);
        $query->where('ts.lang_iso = "' . pSQL($langIso) . '"');

        return $this->db->executeS($query);
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
        $query = new \DbQuery();
        $query->from('carrier', 'c');
        $query->select('c.*, cl.delay, eis.created_at as update_date');
        $query->leftJoin('carrier_lang', 'cl', 'cl.id_carrier = c.id_carrier AND cl.id_lang = ' . (int) $langId);
        $query->leftJoin('carrier_shop', 'cs', 'cs.id_carrier = c.id_carrier');
        $query->leftJoin(
            'eventbus_incremental_sync',
            'eis',
            'eis.id_object = c.id_carrier AND eis.type = "' . Config::COLLECTION_CARRIERS . '" AND eis.id_shop = cs.id_shop AND eis.lang_iso = cl.id_lang'
        );
        $query->where('c.id_carrier IN (' . implode(',', array_map('intval', $carrierIds)) . ')');
        $query->where('cs.id_shop = ' . (int) $this->context->shop->id);
        $query->groupBy('c.id_reference, c.id_carrier HAVING c.id_carrier=(select max(id_carrier) FROM ' . _DB_PREFIX_ . 'carrier c2 WHERE c2.id_reference=c.id_reference)');

        return $this->db->executeS($query);
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
        $query = new \DbQuery();
        $query->from('carrier', 'c');
        $query->select('c.id_carrier, IFNULL(eis.created_at, CURRENT_DATE()) as update_date');
        $query->leftJoin('carrier_lang', 'cl', 'cl.id_carrier = c.id_carrier AND cl.id_lang = ' . (int) $langId);
        $query->leftJoin('carrier_shop', 'cs', 'cs.id_carrier = c.id_carrier');
        $query->leftJoin(
            'eventbus_incremental_sync',
            'eis',
            'eis.id_object = c.id_carrier AND eis.type = "' . Config::COLLECTION_CARRIERS . '" AND eis.id_shop = cs.id_shop AND eis.lang_iso = cl.id_lang'
        );
        $query->where('cs.id_shop = ' . (int) $this->context->shop->id);
        $query->where('deleted=0');
        $query->limit($limit, $offset);

        return $this->db->executeS($query);
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

        if (!is_array($carriers) || empty($carriers)) {
            return 0;
        }

        return count($carriers);
    }
}
