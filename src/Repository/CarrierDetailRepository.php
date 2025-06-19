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

class CarrierDetailRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'carrier';

    /**
     * @param string $langIso
     * @param bool $withSelecParameters
     *
     * @return void
     *
     * @throws \PrestaShopException
     */
    public function generateFullQuery($langIso, $withSelecParameters)
    {
        $this->generateMinimalQuery(self::TABLE_NAME, 'ca');

        $latestDeliveryPriceQueryJoin = '
            INNER JOIN (
                SELECT
                    id_carrier,
                    price
                FROM ps_delivery d1
                WHERE price IS NOT NULL
                AND id_delivery = (
                    SELECT MAX(id_delivery)
                    FROM ps_delivery d2
                    WHERE d2.id_carrier = d1.id_carrier AND d2.price IS NOT NULL
                )
            ) ldp ON ca.id_carrier = ldp.id_carrier
        ';

        $configQueryJoin = '
            CROSS JOIN (
                SELECT value AS shipping_method_config
                FROM ps_configuration
                WHERE name = \'PS_SHIPPING_METHOD\'
                LIMIT 1
            ) conf
        ';

        // minimal query for countable query
        $this->query
            ->join($latestDeliveryPriceQueryJoin)
            ->innerJoin('delivery', 'd', 'ca.id_carrier = d.id_carrier AND d.id_zone IS NOT NULL')
            ->innerJoin('country', 'co', 'd.id_zone = co.id_zone AND co.iso_code IS NOT NULL AND co.active = 1')
            ->leftJoin('range_weight', 'rw', 'ca.id_carrier = rw.id_carrier AND d.id_range_weight = rw.id_range_weight')
            ->leftJoin('range_price', 'rp', 'ca.id_carrier = rp.id_carrier AND d.id_range_price = rp.id_range_price')
            ->leftJoin('state', 's', 'co.id_zone = s.id_zone AND co.id_country = s.id_country AND s.active = 1')
            ->join($configQueryJoin)
            ->select('ca.id_reference')
            ->groupBy('ca.id_reference, co.id_zone, id_range')
        ;

        if ($withSelecParameters) {
            $this->query
                ->select('d.id_zone')
                ->select('ldp.price')
                ->select('
                    CASE
                        WHEN d.id_range_weight IS NOT NULL AND d.id_range_weight != 0 THEN d.id_range_weight
                        WHEN d.id_range_price IS NOT NULL AND d.id_range_price != 0 THEN d.id_range_price
                    END AS id_range
                ')
                ->select('
                    CASE
                        WHEN ca.is_free = 1 THEN "free_shipping"
                        WHEN ca.shipping_method = 0 AND conf.shipping_method_config IS NULL THEN "range_price"
                        WHEN ca.shipping_method = 0 AND conf.shipping_method_config IS NOT NULL THEN "range_weight"
                        WHEN ca.shipping_method = 1 THEN "range_weight"
                        WHEN ca.shipping_method = 2 THEN "range_price"
                    END AS shipping_method
                ')
                ->select('COALESCE(rw.delimiter1, rp.delimiter1) AS delimiter1')
                ->select('COALESCE(rw.delimiter2, rp.delimiter2) AS delimiter2')
                ->select('
                    GROUP_CONCAT(
                        DISTINCT co.iso_code
                        ORDER BY co.iso_code ASC
                        SEPARATOR \',\'
                    ) AS country_ids
                ')
                ->select('
                    GROUP_CONCAT(
                        DISTINCT
                        s.iso_code
                        ORDER BY s.iso_code ASC
                        SEPARATOR \',\'
                    ) AS state_ids
                ')
            ;
        }
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForFull($offset, $limit, $langIso)
    {
        $this->generateFullQuery($langIso, true);

        $this->query->limit((int) $limit, (int) $offset);

        return $this->runQuery();
    }

    /**
     * @param int $limit
     * @param array<mixed> $contentIds
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForIncremental($limit, $contentIds, $langIso)
    {
        $this->generateFullQuery($langIso, true);

        $this->query
            ->where("ca.id_carrier IN('" . implode("','", array_map('intval', $contentIds ?: [-1])) . "')")
            // ->limit($limit) Sub shop content depend from another, temporary disabled
        ;

        return $this->runQuery();
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return int
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function countFullSyncContentLeft($offset, $limit, $langIso)
    {
        $this->generateFullQuery($langIso, true);

        $result = $this->db->executeS('
            SELECT COUNT(*) - ' . (int) $offset . ' AS count
                FROM (' . $this->query->build() . ') as subquery;
        ');

        return is_array($result) ? $result[0]['count'] : 0;
    }
}
