<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class StateRepository
{
    /**
     * @var \PrestaShop\PrestaShop\Adapter\Entity\Db
     */
    private $db;

    /**
     * @var array
     */
    private $stateIsoCodeCache = [];

    public function __construct(\Db $db)
    {
        $this->db = $db;
    }

    /**
     * @return \PrestaShop\PrestaShop\Adapter\Entity\DbQuery
     */
    private function getBaseQuery()
    {
        $query = new \PrestaShop\PrestaShop\Adapter\Entity\DbQuery();

        $query->from('state', 's');

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
    public function getStateIsoCodesByZoneId($zoneId, $active = true)
    {
        $cacheKey = $zoneId . '-' . (int) $active;

        if (!isset($this->stateIsoCodeCache[$cacheKey])) {
            $query = $this->getBaseQuery();

            $query->select('s.iso_code');
            $query->innerJoin('country', 'c', 'c.id_country = s.id_country');
            $query->where('s.id_zone = ' . (int) $zoneId);
            $query->where('s.active = ' . (bool) $active);
            $query->where('c.active = ' . (bool) $active);

            $isoCodes = [];

            $result = $this->db->executeS($query);
            if (is_array($result)) {
                foreach ($result as $state) {
                    $isoCodes[] = $state['iso_code'];
                }
            }
            $this->stateIsoCodeCache[$cacheKey] = $isoCodes;
        }

        return $this->stateIsoCodeCache[$cacheKey];
    }
}
