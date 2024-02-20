<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use \PrestaShop\PrestaShop\Adapter\Entity\Context;
use \PrestaShop\PrestaShop\Adapter\Entity\Db;
use \PrestaShop\PrestaShop\Adapter\Entity\PrestaShopException;
use \PrestaShop\PrestaShop\Adapter\Entity\PrestaShopDatabaseException;
use \PrestaShop\PrestaShop\Adapter\Entity\DbQuery;

class StateRepository
{
    /**
     * @var Db
     */
    private $db;

    /**
     * @var array
     */
    private $stateIsoCodeCache = [];

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    /**
     * @return DbQuery
     */
    private function getBaseQuery()
    {
        $query = new DbQuery();

        $query->from('state', 's');

        return $query;
    }

    /**
     * @param int $zoneId
     * @param bool $active
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws PrestaShopDatabaseException
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
