<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use Carrier;
use Context;
use Db;
use DbQuery;
use RangePrice;
use RangeWeight;

class CarrierRepository
{
    /**
     * @var Db
     */
    private $db;

    /**
     * @var Context
     */
    private $context;

    public function __construct(Db $db, Context $context)
    {
        $this->db = $db;
        $this->context = $context;
    }

    /**
     * @param int $langId
     * @param array $carrierIds
     *
     * @return array
     */
    public function getCarriers($langId, array $carrierIds)
    {
        $data = [];
        foreach ($carrierIds as $carrierId) {
            $carrierObj = new Carrier($carrierId);

            $data[$carrierId]['collection'] = 'carriers';
            $data[$carrierId]['id'] = $carrierObj->id;
            $data[$carrierId]['properties'] = $carrier;

            $deliveryPriceByRanges = self::getDeliveryPriceByRange($carrierObj);
            foreach ($deliveryPriceByRanges as $deliveryPriceByRange) {
                $data[$carrierId]['collection'] = 'carriers_details';
                $data[$carrierId]['id'] = $deliveryPriceByRange['id_range_weight'];
                $data[$carrierId]['properties'] = $deliveryPriceByRange;
            }
        }

        return $data;
    }

    /**
     * @param Carrier $carrierObj
     *
     * @return array|false
     */
    public function getDeliveryPriceByRange(Carrier $carrierObj)
    {
        $rangeTable = $carrierObj->getRangeTable();
        switch ($rangeTable) {
            case 'range_weight':
                return self::getCarrierByWeightRange($carrierObj, 'range_weight');
            case 'range_price':
                return self::getCarrierByPriceRange($carrierObj, 'range_price');
            default:
                return false;
        }
    }

    /**
     * @param Carrier $carrierObj
     * @param string $rangeTable
     *
     * @return array
     */
    private function getCarrierByPriceRange(
        Carrier $carrierObj,
        $rangeTable
    ) {
        $deliveryPriceByRange = Carrier::getDeliveryPriceByRanges($rangeTable, (int) $carrierObj->id);

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
     * @param Carrier $carrierObj
     * @param string $rangeTable
     *
     * @return array
     */
    private function getCarrierByWeightRange(
        Carrier $carrierObj,
        $rangeTable
    ) {
        $deliveryPriceByRange = Carrier::getDeliveryPriceByRanges($rangeTable, (int) $carrierObj->id);

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
        $query = new DbQuery();
        $query->from(IncrementalSyncRepository::INCREMENTAL_SYNC_TABLE, 'aic');
        $query->leftJoin(EventbusSyncRepository::TYPE_SYNC_TABLE_NAME, 'ts', 'ts.type = aic.type');
        $query->where('aic.type = "' . (string) $type . '"');
        $query->where('ts.id_shop = ' . (string) $this->context->shop->id);
        $query->where('ts.lang_iso = "' . (string) $langIso . '"');

        return $this->db->executeS($query);
    }

    /**
     * @param array $deliveryPriceByRange
     *
     * @return false|RangeWeight|RangePrice
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function getCarrierRange(array $deliveryPriceByRange)
    {
        if (isset($deliveryPriceByRange['id_range_weight'])) {
            return new RangeWeight($deliveryPriceByRange['id_range_weight']);
        }
        if (isset($deliveryPriceByRange['id_range_price'])) {
            return new RangePrice($deliveryPriceByRange['id_range_price']);
        }

        return false;
    }

    public function getCarrierProperties($carrierIds, $langId)
    {
        $query = new DbQuery();
        $query->from('carrier', 'c');
        $query->select('c.*, cl.delay');
        $query->leftJoin('carrier_lang', 'cl', 'cl.id_carrier = c.id_carrier AND cl.id_lang = ' . (int) $langId);
        $query->leftJoin('carrier_zone', 'cz', 'cz.id_carrier = c.id_carrier');
        $query->leftJoin('carrier_shop', 'cs', 'cs.id_carrier = c.id_carrier');
        $query->where('c.id_carrier IN (' . implode(',', array_map('intval', $carrierIds)) . ')');
        $query->where('cs.id_shop = ' . (int) $this->context->shop->id);
        $query->where('c.deleted = 0');

        return $this->db->executeS($query);
    }
}
