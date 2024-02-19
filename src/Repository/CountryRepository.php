<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class CountryRepository
{
    /**
     * @var \PrestaShop\PrestaShop\Adapter\Entity\Db
     */
    private $db;

    /**
     * @var \PrestaShop\PrestaShop\Adapter\Entity\Context
     */
    private $context;

    /**
     * @var array
     */
    private $countryIsoCodeCache = [];

    public function __construct(\Db $db, \PrestaShop\PrestaShop\Adapter\Entity\Context $context)
    {
        $this->db = $db;
        $this->context = $context;
    }

    /**
     * @return \PrestaShop\PrestaShop\Adapter\Entity\DbQuery
     */
    private function getBaseQuery()
    {
        if ($this->context->shop == null) {
            throw new \PrestaShop\PrestaShop\Adapter\Entity\PrestaShopException('No shop context');
        }

        if ($this->context->language == null) {
            throw new \PrestaShop\PrestaShop\Adapter\Entity\PrestaShopException('No language context');
        }

        $query = new \PrestaShop\PrestaShop\Adapter\Entity\DbQuery();

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
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShop\PrestaShop\Adapter\Entity\PrestaShopDatabaseException
     */
    public function getCountyIsoCodesByZoneId($zoneId, $active = true)
    {
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
