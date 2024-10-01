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

class CountryRepository extends AbstractRepository
{
    const TABLE_NAME = 'country';

    /**
     * @var array<mixed>
     */
    private $countryIsoCodeCache = [];

    /**
     * @param int $zoneId
     * @param bool $active
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCountyIsoCodesByZoneId($zoneId, $active)
    {
        $cacheKey = $zoneId . '-' . (int) $active;
        $isoCodes = [];

        if (!isset($this->countryIsoCodeCache[$cacheKey])) {
            $this->generateMinimalQuery(self::TABLE_NAME, 'c');
        
            $this->query
                ->innerJoin('country_shop', 'cs', 'cs.id_country = c.id_country')
                ->innerJoin('country_lang', 'cl', 'cl.id_country = c.id_country')
                ->where('cs.id_shop = ' . (int) parent::getShopContext()->id)
                ->where('cl.id_lang = ' . (int) parent::getContext()->language->id)
                ->where('id_zone = ' . (int) $zoneId)
                ->where('active = ' . (bool) $active)
            ;

            $this->query->select('iso_code');

            
            $result = $this->runQuery(false);

            foreach ($result as $country) {
                $isoCodes[] = $country['iso_code'];
            }

            $this->countryIsoCodeCache[$cacheKey] = $isoCodes;
        }

        return $this->countryIsoCodeCache[$cacheKey];
    }
}
