<?php

namespace PrestaShop\Module\PsEventbus\Builder;

use Carrier;
use Currency;
use Language;
use PrestaShop\Module\PsEventbus\DTO\Carrier as EventBusCarrier;
use PrestaShop\Module\PsEventbus\DTO\CarrierDetail;
use PrestaShop\Module\PsEventbus\DTO\CarrierTax;
use PrestaShop\Module\PsEventbus\Repository\CarrierRepository;
use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;
use PrestaShop\Module\PsEventbus\Repository\CountryRepository;
use PrestaShop\Module\PsEventbus\Repository\StateRepository;
use PrestaShop\Module\PsEventbus\Repository\TaxRepository;
use RangePrice;
use RangeWeight;

class CarrierBuilder
{
    /**
     * @var CarrierRepository
     */
    private $carrierRepository;

    /**
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * @var StateRepository
     */
    private $stateRepository;

    /**
     * @var TaxRepository
     */
    private $taxRepository;

    /**
     * @var ConfigurationRepository
     */
    private $configurationRepository;

    public function __construct(
        CarrierRepository $carrierRepository,
        CountryRepository $countryRepository,
        StateRepository $stateRepository,
        TaxRepository $taxRepository,
        ConfigurationRepository $configurationRepository
    ) {
        $this->carrierRepository = $carrierRepository;
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
        $this->taxRepository = $taxRepository;
        $this->configurationRepository = $configurationRepository;
    }

    public function buildCarriers(array $carriers, Language $lang, Currency $currency, $weightUnit)
    {
        $eventBusCarriers = [];
        foreach ($carriers as $carrier) {
            $eventBusCarriers[] = self::build(
                $carrier['id_carrier'],
                $lang,
                $currency,
                $weightUnit
            );
        }

        $formattedCarriers = [];
        /** @var EventBusCarrier $eventBusCarrier */
        foreach ($eventBusCarriers as $eventBusCarrier) {
            $formattedCarriers = array_merge($formattedCarriers, $eventBusCarrier->jsonSerialize());
        }

        return $formattedCarriers;
    }

    /**
     * @param int $carrierId
     * @param Language $lang
     * @param Currency $currency
     * @param string $weightUnit
     *
     * @return EventBusCarrier
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function build($carrierId, Language $lang, Currency $currency, $weightUnit)
    {
        $eventBusCarrier = new EventBusCarrier();
        $carrier = new Carrier($carrierId, $lang->id);
        $freeShippingStartsAtPrice = (float) $this->configurationRepository->get('PS_SHIPPING_FREE_PRICE');
        $freeShippingStartsAtWeight = (float) $this->configurationRepository->get('PS_SHIPPING_FREE_WEIGHT');
        $eventBusCarrier->setFreeShippingStartsAtPrice($freeShippingStartsAtPrice);
        $eventBusCarrier->setFreeShippingStartsAtWeight($freeShippingStartsAtWeight);

        $eventBusCarrier->setShippingHandling($this->getShippingHandlePrice((bool) $carrier->shipping_handling));

        $eventBusCarrier
            ->setIdCarrier((int) $carrier->id)
            ->setIdReference((int) $carrier->id_reference)
            ->setName($carrier->name)
            ->setTaxesRatesGroupId((int) $carrier->getIdTaxRulesGroup())
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
            ->setCurrency($currency->iso_code)
            ->setWeightUnit($weightUnit);

        $deliveryPriceByRanges = $this->carrierRepository->getDeliveryPriceByRange($carrier);

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

                $carrierTax = $this->buildCarrierTaxes($carrier, $zone['id_zone']);
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
     * @param array $deliveryPriceByRange
     *
     * @return false|RangeWeight|RangePrice
     *
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    private function getCarrierRange(array $deliveryPriceByRange)
    {
        if (isset($deliveryPriceByRange['id_range_weight'])) {
            return new RangeWeight($deliveryPriceByRange['id_range_weight']);
        }
        if (isset($deliveryPriceByRange['id_range_price'])) {
            return new RangePrice($deliveryPriceByRange['id_range_price']);
        }

        return false;
    }

    /**
     * @param Carrier $carrier
     * @param RangeWeight|RangePrice $rangeWeight
     * @param array $zone
     *
     * @return false|CarrierDetail
     *
     * @throws \PrestaShopDatabaseException
     */
    private function buildCarrierDetails(Carrier $carrier, $rangeWeight, array $zone)
    {
        $carrierDetail = new CarrierDetail();
        $carrierDetail->setShippingMethod($carrier->getRangeTable());
        $carrierDetail->setCarrierDetailId($rangeWeight->id);
        $carrierDetail->setDelimiter1($rangeWeight->delimiter1);
        $carrierDetail->setDelimiter2($rangeWeight->delimiter2);
        $carrierDetail->setPrice($zone['price']);
        $carrierDetail->setCarrierReference($carrier->id_reference);
        $carrierDetail->setZoneId($zone['id_zone']);
        $carrierDetail->setRangeId($rangeWeight->id);

        $countryIsoCodes = $this->countryRepository->getCountyIsoCodesByZoneId($zone['id_zone']);
        if (!$countryIsoCodes) {
            return false;
        }
        $carrierDetail->setCountryIsoCodes($countryIsoCodes);

        $stateIsoCodes = $this->stateRepository->getStateIsoCodesByZoneId($zone['id_zone']);
        $carrierDetail->setStateIsoCodes($stateIsoCodes);

        return $carrierDetail;
    }

    /**
     * @param Carrier $carrier
     * @param int $zoneId
     *
     * @return CarrierTax|null
     *
     * @throws \PrestaShopDatabaseException
     */
    private function buildCarrierTaxes(Carrier $carrier, $zoneId)
    {
        $taxRulesGroupId = (int) $carrier->getIdTaxRulesGroup();
        $carrierTaxesByZone = $this->taxRepository->getCarrierTaxesByZone($zoneId, $taxRulesGroupId);

        if (!$carrierTaxesByZone[0]['country_iso_code']) {
            return null;
        }

        $carrierTaxesByZone = $carrierTaxesByZone[0];

        $carrierTax = new CarrierTax();
        $carrierTax->setCarrierReference($carrier->id_reference);
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
