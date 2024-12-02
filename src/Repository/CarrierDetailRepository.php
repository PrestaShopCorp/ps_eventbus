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
     * @return mixed
     *
     * @throws \PrestaShopException
     */
    public function generateFullQuery($langIso, $withSelecParameters)
    {
        $this->generateMinimalQuery(self::TABLE_NAME, 'ca');

        $this->query
            ->innerJoin('delivery', 'd', 'ca.id_carrier = d.id_carrier AND d.id_zone IS NOT NULL')
            ->innerJoin('country', 'co', 'd.id_zone = co.id_zone AND co.iso_code IS NOT NULL AND co.active = 1')
            ->leftJoin('range_weight', 'rw', 'ca.id_carrier = rw.id_carrier AND d.id_range_weight = rw.id_range_weight')
            ->leftJoin('range_price', 'rp', 'ca.id_carrier = rp.id_carrier AND d.id_range_price = rp.id_range_price')
            ->leftJoin('state', 's', 'co.id_zone = s.id_zone AND co.id_country = s.id_country AND s.active = 1')
            ->leftJoin('configuration', 'conf', 'conf.name = "PS_SHIPPING_METHOD"')
        ;

        if ($withSelecParameters) {
            $this->query
                ->select('ca.id_reference')
                ->select('d.id_zone')
                ->select('
                    CASE
                        WHEN d.id_range_weight IS NOT NULL AND d.id_range_weight != 0 THEN d.id_range_weight
                        WHEN d.id_range_price IS NOT NULL AND d.id_range_price != 0 THEN d.id_range_price
                    END AS id_range
                ')
                ->select('
                    CASE
                        WHEN ca.is_free = 1 THEN "free_shipping"
                        WHEN ca.shipping_method = 0 AND conf.value IS NULL THEN "range_price"
                        WHEN ca.shipping_method = 0 AND conf.value IS NOT NULL THEN "range_weight"
                        WHEN ca.shipping_method = 1 THEN "range_weight"
                        WHEN ca.shipping_method = 2 THEN "range_price"
                    END AS shipping_method
                ')
                ->select('
                    CASE
                        WHEN rw.delimiter1 IS NOT NULL THEN rw.delimiter1
                        WHEN rp.delimiter1 IS NOT NULL THEN rp.delimiter1
                    END AS delimiter1
                ')
                ->select('
                    CASE
                        WHEN rw.delimiter2 IS NOT NULL THEN rw.delimiter2
                        WHEN rp.delimiter2 IS NOT NULL THEN rp.delimiter2
                    END AS delimiter2
                ')
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
                ->select('
                    (
                        SELECT d2.price
                        FROM ps_delivery d2
                        WHERE d2.id_carrier = d.id_carrier
                        ORDER BY d2.id_delivery DESC
                        LIMIT 1
                    ) AS price
                ')
            ;

            $this->query->groupBy('ca.id_reference, co.id_zone, id_range');
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
        if ($contentIds == []) {
            return [];
        }

        $this->generateFullQuery($langIso, true);

        $this->query
            ->where('ca.id_carrier IN(' . implode(',', array_map('intval', $contentIds)) . ')')
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
            SELECT (COUNT(*) - ' . (int) $offset . ') AS count
                FROM (' . $this->query->build() . ') as subquery;
        ');

        return is_array($result) ? $result[0]['count'] : [];
    }
}
