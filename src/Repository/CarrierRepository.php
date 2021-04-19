<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use Carrier;
use Db;
use DbQuery;

class CarrierRepository
{
    /**
     * @var Db
     */
    private $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
    }

    public function getCarriers($langId)
    {
        $carriers = Carrier::getCarriers($langId);
        foreach ($carriers as $key => $carrier) {
            $carrierObj = new Carrier($carrier['id_carrier']);
            $deliveryPriceByRange = self::getDeliveryPriceByRange($carrierObj);
            $carriers[$key]['deliveryPriceByRange'] = $deliveryPriceByRange;
        }

        return $carriers;
    }

    private function getDeliveryPriceByRange(Carrier $carrierObj)
    {
        switch ($carrierObj->getRangeTable()) {
            case 'range_weight':
                return self::getCarrierByWeightRange($carrierObj);
            case 'range_price':
                return self::getCarrierByPriceRange($carrierObj);
            default:
                return false;
        }
    }

    private function getCarrierByPriceRange(
        Carrier $carrierObj
    ) {
        $deliveryPriceByRange = Carrier::getDeliveryPriceByRanges($carrierObj->getRangeTable(), (int)$carrierObj->id);

        $filteredRanges = [];
        foreach ($deliveryPriceByRange as $range) {
            $filteredRanges[$range['id_range_price']]['id_range_price'] = $range['id_range_price'];
            $filteredRanges[$range['id_range_price']]['id_carrier'] = $range['id_carrier'];
            $filteredRanges[$range['id_range_price']]['zone'][$range['id_zone']]['id_zone'] = $range['id_zone'];
            $filteredRanges[$range['id_range_price']]['zone'][$range['id_zone']]['price'] = $range['price'];
        }

        return $filteredRanges;
    }

    private function getCarrierByWeightRange(
        Carrier $carrierObj
    ) {
        $deliveryPriceByRange = Carrier::getDeliveryPriceByRanges($carrierObj->getRangeTable(), (int)$carrierObj->id);

        $filteredRanges = [];
        foreach ($deliveryPriceByRange as $range) {
            $filteredRanges[$range['id_range_weight']]['id_range_weight'] = $range['id_range_weight'];
            $filteredRanges[$range['id_range_weight']]['id_carrier'] = $range['id_carrier'];
            $filteredRanges[$range['id_range_weight']]['zone'][$range['id_zone']]['id_zone'] = $range['id_zone'];
            $filteredRanges[$range['id_range_weight']]['zone'][$range['id_zone']]['price'] = $range['price'];
        }

        return $filteredRanges;
    }
}
