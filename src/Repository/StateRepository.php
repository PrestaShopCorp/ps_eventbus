<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace PrestaShop\Module\PsEventbus\Repository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class StateRepository
{
    /**
     * @var \Db
     */
    private $db;

    /**
     * @var array<mixed>
     */
    private $stateIsoCodeCache = [];

    public function __construct()
    {
        $this->db = \Db::getInstance();
    }

    /**
     * @return \DbQuery
     */
    private function getBaseQuery()
    {
        $query = new \DbQuery();

        $query->from('state', 's');

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
    public function getStateIsoCodesByZoneId($zoneId, $active)
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
