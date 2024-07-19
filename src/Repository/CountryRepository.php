<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class CountryRepository
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

        if ($this->context->language == null) {
            throw new \PrestaShopException('No language context');
        }

        $query = new \DbQuery();

        $query->from('country', 'c')
            ->innerJoin('country_shop', 'cs', 'cs.id_country = c.id_country')
            ->innerJoin('country_lang', 'cl', 'cl.id_country = c.id_country')
            ->where('cs.id_shop = ' . (int) $this->context->shop->id)
            ->where('cl.id_lang = ' . (int) $this->context->language->id);

        return $query;
    }

    /**
     * @param int $zoneId
     * @param bool $active
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCountyIsoCodesByZoneId($zoneId, $active = null)
    {
        if ($active == null) {
            $active = true;
        }

        $cacheKey = $zoneId . '-' . (int) $active;

        if (!isset($this->countryIsoCodeCache[$cacheKey])) {
            $query = $this->getBaseQuery();

            $query->select('iso_code');
            $query->where('id_zone = ' . (int) $zoneId);
            $query->where('active = ' . (bool) $active);

            $isoCodes = [];
            $result = $this->db->executeS($query);
            if (is_array($result)) {
                foreach ($result as $country) {
                    $isoCodes[] = $country['iso_code'];
                }
            }
            $this->countryIsoCodeCache[$cacheKey] = $isoCodes;
        }

        return $this->countryIsoCodeCache[$cacheKey];
    }
}
