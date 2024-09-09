<?php

namespace PrestaShop\Module\PsEventbus\Builder;

use PrestaShop\Module\PsEventbus\DTO\Carrier as EventBusCarrier;
use PrestaShop\Module\PsEventbus\DTO\CarrierDetail;
use PrestaShop\Module\PsEventbus\DTO\CarrierTax;
use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;
use PrestaShop\Module\PsEventbus\Repository\CountryRepository;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;
use PrestaShop\Module\PsEventbus\Repository\StateRepository;
use PrestaShop\Module\PsEventbus\Repository\TaxRepository;
use PrestaShopDatabaseException;
use PrestaShopException;

class CarrierBuilder
{
    /** @var CountryRepository */
    private $countryRepository;

    /** @var StateRepository */
    private $stateRepository;

    /** @var TaxRepository */
    private $taxRepository;

    /** @var ConfigurationRepository */
    private $configurationRepository;

    /** @var LanguageRepository */
    private $languageRepository;

    public function __construct(
        CountryRepository $countryRepository,
        StateRepository $stateRepository,
        TaxRepository $taxRepository,
        ConfigurationRepository $configurationRepository,
        LanguageRepository $languageRepository
    ) {
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
        $this->taxRepository = $taxRepository;
        $this->configurationRepository = $configurationRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     * @param array<mixed> $carriers
     * @param string $langIso
     * @param \Currency $currency
     * @param string $weightUnit
     *
     * @return array<mixed>
     *
     * @@throws PrestaShopDatabaseException
     * @@throws PrestaShopException
     */
    public function buildCarriers($carriers, $langIso, \Currency $currency, $weightUnit)
    {
        $langId = $this->languageRepository->getLanguageIdByIsoCode($langIso);

        $eventBusCarriers = [];
        foreach ($carriers as $carrier) {
            $eventBusCarriers[] = $this->buildCarrier(
                new \Carrier($carrier['id_carrier'], $langId),
                $currency->iso_code,
                $weightUnit
            );
        }

        return array_map(function ($eventBusCarrier) {
            return $eventBusCarrier->jsonSerialize();
        }, $eventBusCarriers);
    }

    /**
     * @param \Carrier $carrier
     * @param string $currencyIsoCode
     * @param string $weightUnit
     *
     * @return EventBusCarrier
     *
     * @@throws PrestaShopDatabaseException
     * @@throws PrestaShopException
     */
    public function buildCarrier(\Carrier $carrier, $currencyIsoCode, $weightUnit)
    {
        $eventBusCarrier = new EventBusCarrier();
        $freeShippingStartsAtPrice = (float) $this->configurationRepository->get('PS_SHIPPING_FREE_PRICE');
        $freeShippingStartsAtWeight = (float) $this->configurationRepository->get('PS_SHIPPING_FREE_WEIGHT');
        $eventBusCarrier->setFreeShippingStartsAtPrice($freeShippingStartsAtPrice);
        $eventBusCarrier->setFreeShippingStartsAtWeight($freeShippingStartsAtWeight);

        $eventBusCarrier->setShippingHandling($this->getShippingHandlePrice((bool) $carrier->shipping_handling));

        $eventBusCarrier
            ->setIdCarrier((int) $carrier->id)
            ->setIdReference((int) $carrier->id_reference)
            ->setName($carrier->name)
            ->setTaxesRatesGroupId((int) $carrier->getIdTaxRulesGroup()) // TODO
            ->setUrl($carrier->url)
            ->setActive($carrier->active)
            ->setDeleted($carrier->deleted)
            ->setDisableCarrierWhenOutOfRange((bool) $carrier->range_behavior)
            ->setIsModule($carrier->is_module)
            ->setIsFree($carrier->is_free)
            ->setShippingExternal($carrier->shipping_external)
            ->setNeedRange($carrier->need_range)
            ->setExternalModuleName($carrier->external_module_name)
            ->setMaxWidth($carrier->max_width)
            ->setMaxHeight($carrier->max_height)
            ->setMaxDepth($carrier->max_depth)
            ->setMaxWeight($carrier->max_weight)
            ->setGrade($carrier->grade)
            ->setDelay($carrier->delay)
            ->setCurrency($currencyIsoCode)
            ->setWeightUnit($weightUnit);

        $deliveryPriceByRanges = $this->getDeliveryPriceByRange($carrier);

        if (!$deliveryPriceByRanges) {
            return $eventBusCarrier;
        }

        $carrierDetails = [];
        $carrierTaxes = [];
        foreach ($deliveryPriceByRanges as $deliveryPriceByRange) {
            $range = $this->getCarrierRange($deliveryPriceByRange);
            if (!$range) {
                continue;
            }
            foreach ($deliveryPriceByRange['zones'] as $zone) {
                $carrierDetail = $this->buildCarrierDetails($carrier, $range, $zone);
                if ($carrierDetail) {
                    $carrierDetails[] = $carrierDetail;
                }

                /** @var int $rangeId */
                $rangeId = $range->id;
                $carrierTax = $this->buildCarrierTaxes($carrier, $zone['id_zone'], $rangeId);
                if ($carrierTax) {
                    $carrierTaxes[] = $carrierTax;
                }
            }
        }

        $eventBusCarrier->setCarrierDetails($carrierDetails);
        $eventBusCarrier->setCarrierTaxes($carrierTaxes);

        return $eventBusCarrier;
    }

    /**
     * @param \Carrier $carrierObj
     *
     * @return array<mixed>|false
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
     * @return array<mixed>
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
     * @return array<mixed>
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
     * @param array<mixed> $deliveryPriceByRange
     *
     * @return false|\RangeWeight|RangePrice
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function getCarrierRange($deliveryPriceByRange)
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
     * @param \Carrier $carrier
     * @param \RangeWeight|RangePrice $range
     * @param array<mixed> $zone
     *
     * @return false|CarrierDetail
     *
     * @@throws PrestaShopDatabaseException
     */
    private function buildCarrierDetails(\Carrier $carrier, $range, $zone)
    {
        /** @var int $rangeId */
        $rangeId = $range->id;
        $carrierDetail = new CarrierDetail();
        $carrierDetail->setShippingMethod($carrier->getRangeTable());
        $carrierDetail->setCarrierDetailId($rangeId);
        $carrierDetail->setDelimiter1($range->delimiter1);
        $carrierDetail->setDelimiter2($range->delimiter2);
        $carrierDetail->setPrice($zone['price']);
        $carrierDetail->setCarrierReference($carrier->id_reference);
        $carrierDetail->setZoneId($zone['id_zone']);
        $carrierDetail->setRangeId($rangeId);

        /** @var array<mixed> $countryIsoCodes */
        $countryIsoCodes = $this->countryRepository->getCountyIsoCodesByZoneId($zone['id_zone'], true);
        if (!$countryIsoCodes) {
            return false;
        }
        $carrierDetail->setCountryIsoCodes($countryIsoCodes);

        /** @var array<mixed> $stateIsoCodes */
        $stateIsoCodes = $this->stateRepository->getStateIsoCodesByZoneId($zone['id_zone'], true);
        $carrierDetail->setStateIsoCodes($stateIsoCodes);

        return $carrierDetail;
    }

    /**
     * @param \Carrier $carrier
     * @param int $zoneId
     * @param int $rangeId
     *
     * @return CarrierTax|null
     *
     * @@throws PrestaShopDatabaseException
     */
    private function buildCarrierTaxes(\Carrier $carrier, $zoneId, $rangeId)
    {
        $taxRulesGroupId = (int) $carrier->getIdTaxRulesGroup();
        /** @var array<mixed> $carrierTaxesByZone */
        $carrierTaxesByZone = $this->taxRepository->getCarrierTaxesByZone($zoneId, $taxRulesGroupId, true);

        if (!$carrierTaxesByZone[0]['country_iso_code']) {
            return null;
        }

        $carrierTaxesByZone = $carrierTaxesByZone[0];

        $carrierTax = new CarrierTax();
        $carrierTax->setCarrierReference($carrier->id_reference);
        $carrierTax->setRangeId($rangeId);
        $carrierTax->setTaxRulesGroupId($taxRulesGroupId);
        $carrierTax->setZoneId($zoneId);
        $carrierTax->setCountryIsoCode($carrierTaxesByZone['country_iso_code']);
        $carrierTax->setStateIsoCodes($carrierTaxesByZone['state_iso_code']);
        $carrierTax->setTaxRate($carrierTaxesByZone['rate']);

        return $carrierTax;
    }

    /**
     * @param bool $shippingHandling
     *
     * @return float
     */
    private function getShippingHandlePrice($shippingHandling)
    {
        if ($shippingHandling) {
            return (float) $this->configurationRepository->get('PS_SHIPPING_HANDLING');
        }

        return 0.0;
    }
}
