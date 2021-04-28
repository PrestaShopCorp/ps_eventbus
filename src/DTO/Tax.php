<?php

namespace PrestaShop\Module\PsEventbus\DTO;

use JsonSerializable;

class Tax implements JsonSerializable
{
    /**
     * @var string
     */
    private $collection = 'tax';

    /**
     * @var int
     */
    private $taxId;

    /**
     * @var int
     */
    private $taxRulesGroupId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $rate;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var bool
     */
    private $deleted;

    /**
     * @return string
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param string $collection
     *
     * @return Tax
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * @return int
     */
    public function getTaxId()
    {
        return $this->taxId;
    }

    /**
     * @param int $taxId
     *
     * @return Tax
     */
    public function setTaxId($taxId)
    {
        $this->taxId = $taxId;

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
     * @return Tax
     */
    public function setTaxRulesGroupId($taxRulesGroupId)
    {
        $this->taxRulesGroupId = $taxRulesGroupId;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Tax
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     *
     * @return Tax
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return Tax
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     *
     * @return Tax
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function jsonSerialize()
    {
        return [
          'collection' => $this->getCollection(),
            'id' => (string) $this->getTaxId(),
            'parameters' => [
                'tax_id' => (string) $this->getTaxId(),
                'tax_rules_group_id' => (string) $this->getTaxRulesGroupId(),
                'name' => (string) $this->getName(),
                'rate' => (float) $this->getRate(),
                'active' => (bool) $this->isActive(),
                'deleted' => (bool) $this->isDeleted(),
            ],
        ];
    }
}
