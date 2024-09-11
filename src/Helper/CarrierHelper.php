<?php

namespace PrestaShop\Module\PsEventbus\Helper;

use Carrier;
use PrestaShop\Module\PsEventbus\Repository\CountryRepository;
use PrestaShop\Module\PsEventbus\Repository\StateRepository;
use PrestaShop\Module\PsEventbus\Repository\TaxeRepository;

class CarrierHelper
{
    /**
     * Build a CarrierDetail from Carrier data
     *
     * @param array<mixed> $carrierData
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public static function buildCarrierDetails($carrierData)
    {
        /** @var \Ps_eventbus $module */
        $module = \Module::getInstanceByName('ps_eventbus');

        /** @var CountryRepository $countryRepository */
        $countryRepository = $module->getService('PrestaShop\Module\PsEventbus\Repository\CountryRepository');

        /** @var StateRepository $stateRepository */
        $stateRepository = $module->getService('PrestaShop\Module\PsEventbus\Repository\StateRepository');

        $carrier = new \Carrier($carrierData['id_reference']);

        $deliveryPriceByRanges = CarrierHelper::getDeliveryPriceByRange($carrier);

        if (!$deliveryPriceByRanges) {
            return [];
        }

        $carrierDetails = [];

        foreach ($deliveryPriceByRanges as $deliveryPriceByRange) {
            $range = CarrierHelper::getCarrierRange($deliveryPriceByRange);

            if (!$range) {
                continue;
            }

            foreach ($deliveryPriceByRange['zones'] as $zone) {
                /** @var array<mixed> $countryIsoCodes */
                $countryIsoCodes = $countryRepository->getCountyIsoCodesByZoneId($zone['id_zone'], true);

                /** @var array<mixed> $stateIsoCodes */
                $stateIsoCodes = $stateRepository->getStateIsoCodesByZoneId($zone['id_zone'], true);

                $carrierDetail = [];
                $carrierDetail['id_reference'] = $carrier->id_reference;
                $carrierDetail['id_zone'] = $zone['id_zone'];
                $carrierDetail['id_range'] = $range->id;
                $carrierDetail['id_carrier_detail'] = $range->id;
                $carrierDetail['shipping_method'] = $carrier->getRangeTable();
                $carrierDetail['delimiter1'] = $range->delimiter1;
                $carrierDetail['delimiter2'] = $range->delimiter2;
                $carrierDetail['country_ids'] = implode(',', $countryIsoCodes);
                $carrierDetail['state_ids'] = implode(',', $stateIsoCodes);
                $carrierDetail['price'] = $zone['price'];

                array_push($carrierDetails, $carrierDetail);
            }
        }

        return $carrierDetails;
    }

    /**
     * Build a CarrierTaxes from Carrier
     *
     * @param array<mixed> $carrierData
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public static function buildCarrierTaxes($carrierData)
    {
        /** @var \Ps_eventbus $module */
        $module = \Module::getInstanceByName('ps_eventbus');

        /** @var TaxeRepository $taxeRepository */
        $taxeRepository = $module->getService('PrestaShop\Module\PsEventbus\Repository\TaxeRepository');

        $carrier = new \Carrier($carrierData['id_reference']);

        $deliveryPriceByRanges = CarrierHelper::getDeliveryPriceByRange($carrier);

        if (!$deliveryPriceByRanges) {
            return [];
        }

        $carrierTaxes = [];

        foreach ($deliveryPriceByRanges as $deliveryPriceByRange) {
            $range = CarrierHelper::getCarrierRange($deliveryPriceByRange);

            if (!$range) {
                continue;
            }

            foreach ($deliveryPriceByRange['zones'] as $zone) {
                $taxRulesGroupId = (int) $carrier->getIdTaxRulesGroup();

                /** @var array<mixed> $carrierTaxesByZone */
                $carrierTaxesByZone = $taxeRepository->getCarrierTaxesByZone($zone['id_zone'], $taxRulesGroupId, true);

                if (!$carrierTaxesByZone[0]['country_iso_code']) {
                    continue;
                }

                $carrierTaxesByZone = $carrierTaxesByZone[0];

                $carrierTaxe = [];

                $carrierTaxe['id_reference'] = $carrier->id_reference;
                $carrierTaxe['id_zone'] = $zone['id_zone'];
                $carrierTaxe['id_range'] = $range->id;
                $carrierTaxe['id_carrier_tax'] = $taxRulesGroupId;
                $carrierTaxe['country_id'] = $carrierTaxesByZone['country_iso_code'];
                $carrierTaxe['state_ids'] = $carrierTaxesByZone['state_iso_code'];
                $carrierTaxe['tax_rate'] = $carrierTaxesByZone['rate'];

                array_push($carrierTaxes, $carrierTaxe);
            }
        }

        return $carrierTaxes;
    }

    /**
     * @param array<mixed> $deliveryPriceByRange
     *
     * @return false|\RangeWeight|\RangePrice
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    private static function getCarrierRange($deliveryPriceByRange)
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
     * @param \Carrier $carrierObj
     *
     * @return array<mixed>|false
     */
    private static function getDeliveryPriceByRange(\Carrier $carrierObj)
    {
        $rangeTable = $carrierObj->getRangeTable();

        switch ($rangeTable) {
            case 'range_weight':
                return CarrierHelper::getCarrierByWeightRange($carrierObj, 'range_weight');
            case 'range_price':
                return CarrierHelper::getCarrierByPriceRange($carrierObj, 'range_price');
            default:
                return false;
        }
    }

    /**
     * @param \Carrier $carrierObj
     * @param string $rangeTable
     *
     * @return array<mixed>
     */
    private static function getCarrierByWeightRange(\Carrier $carrierObj, $rangeTable)
    {
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
     * @param \Carrier $carrierObj
     * @param string $rangeTable
     *
     * @return array<mixed>
     */
    private static function getCarrierByPriceRange(\Carrier $carrierObj, $rangeTable)
    {
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
}
