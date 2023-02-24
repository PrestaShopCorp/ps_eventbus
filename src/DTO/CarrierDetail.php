<?php

namespace PrestaShop\Module\PsEventbus\DTO;

class CarrierDetail implements \JsonSerializable
{
    /**
     * @var string
     */
    private $collection = 'carrier_details';

    /**
     * @var string|bool
     */
    private $shippingMethod;

    /**
     * @var int
     */
    private $carrierReference;

    /**
     * @var int
     */
    private $CarrierDetailId;

    /**
     * @var int
     */
    private $zoneId;

    /**
     * @var int
     */
    private $rangeId;

    /**
     * @var float
     */
    private $delimiter1;

    /**
     * @var float
     */
    private $delimiter2;

    /**
     * @var array
     */
    private $countryIsoCodes;

    /**
     * @var array
     */
    private $stateIsoCodes;

    /**
     * @var float
     */
    private $price;

    /**
     * @return string
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @return string|bool
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    /**
     * @param bool|string $shippingMethod
     *
     * @return CarrierDetail
     */
    public function setShippingMethod($shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;

        return $this;
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
     * @return CarrierDetail
     */
    public function setCarrierReference($carrierReference)
    {
        $this->carrierReference = $carrierReference;

        return $this;
    }

    /**
     * @return int
     */
    public function getCarrierDetailId()
    {
        return $this->CarrierDetailId;
    }

    /**
     * @param int $CarrierDetailId
     *
     * @return CarrierDetail
     */
    public function setCarrierDetailId($CarrierDetailId)
    {
        $this->CarrierDetailId = $CarrierDetailId;

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
     * @return CarrierDetail
     */
    public function setZoneId($zoneId)
    {
        $this->zoneId = $zoneId;

        return $this;
    }

    /**
     * @return int
     */
    public function getRangeId()
    {
        return $this->rangeId;
    }

    /**
     * @param int $rangeId
     *
     * @return CarrierDetail
     */
    public function setRangeId($rangeId)
    {
        $this->rangeId = $rangeId;

        return $this;
    }

    /**
     * @return float
     */
    public function getDelimiter1()
    {
        return $this->delimiter1;
    }

    /**
     * @param float $delimiter1
     *
     * @return CarrierDetail
     */
    public function setDelimiter1($delimiter1)
    {
        $this->delimiter1 = $delimiter1;

        return $this;
    }

    /**
     * @return float
     */
    public function getDelimiter2()
    {
        return $this->delimiter2;
    }

    /**
     * @param float $delimiter2
     *
     * @return CarrierDetail
     */
    public function setDelimiter2($delimiter2)
    {
        $this->delimiter2 = $delimiter2;

        return $this;
    }

    /**
     * @return array
     */
    public function getCountryIsoCodes()
    {
        return $this->countryIsoCodes;
    }

    /**
     * @param array $countryIsoCodes
     *
     * @return CarrierDetail
     */
    public function setCountryIsoCodes($countryIsoCodes)
    {
        $this->countryIsoCodes = $countryIsoCodes;

        return $this;
    }

    /**
     * @return array
     */
    public function getStateIsoCodes()
    {
        return $this->stateIsoCodes;
    }

    /**
     * @param array $stateIsoCodes
     *
     * @return CarrierDetail
     */
    public function setStateIsoCodes($stateIsoCodes)
    {
        $this->stateIsoCodes = $stateIsoCodes;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return CarrierDetail
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function jsonSerialize()
    {
        $countryIds = implode(',', $this->getCountryIsoCodes());
        $stateIds = implode(',', $this->getStateIsoCodes());

        return [
            'collection' => $this->getCollection(),
            'id' => $this->getCarrierReference() . '-' . $this->getZoneId() . '-' . $this->getShippingMethod() . '-' . $this->getRangeId(),
            'properties' => [
                'id_reference' => (string) $this->getCarrierReference(),
                'id_zone' => (string) $this->getZoneId(),
                'id_range' => (string) $this->getRangeId(),
                'id_carrier_detail' => (string) $this->getCarrierDetailId(),
                'shipping_method' => (string) $this->getShippingMethod(),
                'delimiter1' => (float) $this->getDelimiter1(),
                'delimiter2' => (float) $this->getDelimiter2(),
                'country_ids' => (string) $countryIds,
                'state_ids' => (string) $stateIds,
                'price' => (float) $this->getPrice(),
            ],
        ];
    }
}
