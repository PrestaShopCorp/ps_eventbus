<?php

namespace PrestaShop\Module\PsEventbus\DTO;

use JsonSerializable;

class TaxGroup implements JsonSerializable
{
    /**
     * @var string
     */
    private $collection = 'tax_group';

    /**
     * @var int
     */
    private $taxRulesGroupId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var bool
     */
    private $deleted;

    /**
     * @var int
     */
    private $shopId;

    /**
     * @var Tax[]
     */
    private $taxes = [];

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
     * @return TaxGroup
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;

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
     * @return TaxGroup
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
     * @return TaxGroup
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * @return TaxGroup
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
     * @return TaxGroup
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * @return int
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * @param int $shopId
     *
     * @return TaxGroup
     */
    public function setShopId($shopId)
    {
        $this->shopId = $shopId;

        return $this;
    }

    /**
     * @return Tax[]
     */
    public function getTaxes()
    {
        return $this->taxes;
    }

    /**
     * @param Tax[] $taxes
     *
     * @return TaxGroup
     */
    public function setTaxes($taxes)
    {
        $this->taxes = $taxes;

        return $this;
    }

    public function jsonSerialize()
    {
        $return = [];

        $return[] = [
            'collection' => $this->getCollection(),
            'id' => (string) $this->getTaxRulesGroupId(),
            'parameters' => [
                'tax_rules_group_id' => (string) $this->getTaxRulesGroupId(),
                'name' => (string) $this->getName(),
                'active' => (bool) $this->isActive(),
                'deleted' => (bool) $this->isDeleted(),
                'shop_id' => (int) $this->getShopId(),
            ],
        ];

        $taxes = [];
        foreach ($this->getTaxes() as $tax) {
            $taxes[] = $tax->jsonSerialize();
        }

        return array_merge($return, $taxes);
    }
}
