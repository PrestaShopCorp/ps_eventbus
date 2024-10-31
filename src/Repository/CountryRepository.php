<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\PsEventbus\Repository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CountryRepository extends AbstractRepository
{
    const TABLE_NAME = 'country';

    /**
     * @param int $zoneId
     * @param bool $active
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCountryIsoCodesByZoneId($zoneId, $active)
    {
        $isoCodes = [];

        $this->generateMinimalQuery(self::TABLE_NAME, 'c');

        $this->query
            ->innerJoin('country_shop', 'cs', 'cs.id_country = c.id_country')
            ->innerJoin('country_lang', 'cl', 'cl.id_country = c.id_country')
            ->where('cs.id_shop = ' . (int) parent::getShopContext()->id)
            ->where('cl.id_lang = ' . (int) parent::getLanguageContext()->id)
            ->where('id_zone = ' . (int) $zoneId)
            ->where('active = ' . (bool) $active)
        ;

        $this->query->select('iso_code');

        $result = $this->runQuery(true);

        foreach ($result as $country) {
            $isoCodes[] = $country['iso_code'];
        }

        return $isoCodes;
    }
}
