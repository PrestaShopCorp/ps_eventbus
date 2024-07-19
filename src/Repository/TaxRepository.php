<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class TaxRepository
{
    /**
     * @var \Db
     */
    private $db;

    /**
     * @var \Context
     */
    private $context;

    /**
     * @var array<mixed>
     */
    private $countryIsoCodeCache = [];

    public function __construct(\Context $context)
    {
        $this->db = \Db::getInstance();
        $this->context = $context;
    }

    /**
     * @return \DbQuery
     */
    private function getBaseQuery()
    {
        if ($this->context->shop == null) {
            throw new \PrestaShopException('No shop context');
        }

        $shopId = (int) $this->context->shop->id;

        if ($this->context->language == null) {
            throw new \PrestaShopException('No language context');
        }

        $language = (int) $this->context->language->id;

        $query = new \DbQuery();

        $query->from('tax', 't')
            ->innerJoin('tax_rule', 'tr', 'tr.id_tax = t.id_tax')
            ->innerJoin('tax_rules_group', 'trg', 'trg.id_tax_rules_group = tr.id_tax_rules_group')
            ->innerJoin('tax_rules_group_shop', 'trgs', 'trgs.id_tax_rules_group = tr.id_tax_rules_group')
            ->innerJoin('tax_lang', 'tl', 'tl.id_tax = t.id_tax')
            ->where('trgs.id_shop = ' . $shopId)
            ->where('tl.id_lang = ' . $language);

        return $query;
    }

    /**
     * @param int $zoneId
     * @param int $taxRulesGroupId
     * @param bool $active
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCarrierTaxesByZone($zoneId, $taxRulesGroupId, $active = null)
    {
        if ($active == null) {
            $active = true;
        }

        $cacheKey = $zoneId . '-' . (int) $active;

        if (!isset($this->countryIsoCodeCache[$cacheKey])) {
            $query = $this->getBaseQuery();

            $query->select('rate, c.iso_code as country_iso_code, GROUP_CONCAT(s.iso_code SEPARATOR ",") as state_iso_code');
            $query->leftJoin('country', 'c', 'c.id_country = tr.id_country');
            $query->leftJoin('state', 's', 's.id_state = tr.id_state');
            $query->where('tr.id_tax_rules_group = ' . (int) $taxRulesGroupId);
            $query->where('c.active = ' . (bool) $active);
            $query->where('s.active = ' . (bool) $active . ' OR s.active IS NULL');
            $query->where('t.active = ' . (bool) $active);
            $query->where('c.id_zone = ' . (int) $zoneId . ' OR s.id_zone = ' . (int) $zoneId);
            $query->where('c.iso_code IS NOT NULL');

            $this->countryIsoCodeCache[$cacheKey] = $this->db->executeS($query);
        }

        return $this->countryIsoCodeCache[$cacheKey];
    }
}
