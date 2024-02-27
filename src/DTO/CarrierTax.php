<?php

namespace PrestaShop\Module\PsEventbus\DTO;

class CarrierTax implements \JsonSerializable
{
    /**
     * @var string
     */
    private $collection = 'carrier_taxes';

    /**
     * @var int
     */
    private $carrierReference;

    /**
     * @var int
     */
    private $rangeId;

    /**
     * @var int
     */
    private $taxRulesGroupId;

    /**
     * @var int
     */
    private $zoneId;

    /**
     * @var string
     */
    private $countryIsoCode;

    /**
     * @var string
     */
    private $stateIsoCodes;

    /**
     * @var float
     */
    private $taxRate;

    /**
     * @return string
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @return int
     */
    public function getCarrierReference()
    {
        return $this->carrierReference;
    }

    /**
     * @param int $carrierReference
     *
     * @return CarrierTax
     */
    public function setCarrierReference($carrierReference)
    {
        $this->carrierReference = $carrierReference;

        return $this;
    }

    public function getRangeId(): int
    {
        return $this->rangeId;
    }

    /**
     * @param int $rangeId
     *
     * @return CarrierTax
     */
    public function setRangeId(int $rangeId): CarrierTax
    {
        $this->rangeId = $rangeId;

        return $this;
    }

    /**
     * @return int
     */
    public function getTaxRulesGroupId()
    {
        return $this->taxRulesGroupId;
    }

    /**
     * @param int $taxRulesGroupId
     *
     * @return CarrierTax
     */
    public function setTaxRulesGroupId($taxRulesGroupId)
    {
        $this->taxRulesGroupId = $taxRulesGroupId;

        return $this;
    }

    /**
     * @return int
     */
    public function getZoneId()
    {
        return $this->zoneId;
    }

    /**
     * @param int $zoneId
     *
     * @return CarrierTax
     */
    public function setZoneId($zoneId)
    {
        $this->zoneId = $zoneId;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountryIsoCode()
    {
        return $this->countryIsoCode;
    }

    /**
     * @param string $countryIsoCode
     *
     * @return CarrierTax
     */
    public function setCountryIsoCode($countryIsoCode)
    {
        $this->countryIsoCode = $countryIsoCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getStateIsoCodes()
    {
        return $this->stateIsoCodes;
    }

    /**
     * @param string $stateIsoCodes
     *
     * @return CarrierTax
     */
    public function setStateIsoCodes($stateIsoCodes)
    {
        $this->stateIsoCodes = $stateIsoCodes;

        return $this;
    }

    /**
     * @return float
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * @param float $taxRate
     *
     * @return CarrierTax
     */
    public function setTaxRate($taxRate)
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'collection' => $this->getCollection(),
            'id' => $this->getCarrierReference() . '-' . $this->getZoneId() . '-' . $this->getRangeId(),
            'properties' => [
                'id_reference' => (string) $this->getCarrierReference(),
                'id_zone' => (string) $this->getZoneId(),
                'id_range' => (string) $this->getRangeId(),
                'id_carrier_tax' => (string) $this->getTaxRulesGroupId(),
                'country_id' => (string) $this->getCountryIsoCode(),
                'state_ids' => (string) $this->getStateIsoCodes(),
                'tax_rate' => (float) $this->getTaxRate(),
            ],
        ];
    }
}
