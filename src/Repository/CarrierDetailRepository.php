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

        // Create temporary table to get the latest delivery prices
        $this->db->execute('
            CREATE TEMPORARY TABLE IF NOT EXISTS TEMP_TABLE_latest_delivery_prices (
                id_carrier INT UNSIGNED NOT NULL,
                price DECIMAL(20,6) NOT NULL,
                PRIMARY KEY (id_carrier)
            );
        ');

        // insert the latest delivery prices into the temporary table
        $this->db->execute('
            INSERT IGNORE INTO TEMP_TABLE_latest_delivery_prices (id_carrier, price)
            SELECT
                d.id_carrier,
                d.price
            FROM ' . _DB_PREFIX_ . 'delivery d
            INNER JOIN (
                SELECT id_carrier, MAX(id_delivery) AS max_delivery
                FROM ' . _DB_PREFIX_ . 'delivery
                WHERE price IS NOT NULL
                GROUP BY id_carrier
            ) latest ON d.id_carrier = latest.id_carrier AND d.id_delivery = latest.max_delivery
            WHERE d.price IS NOT NULL;
        ');

        $psShippingMethod = \Configuration::get('PS_SHIPPING_METHOD');

        // minimal query for countable query
        $this->query
            ->join('INNER JOIN TEMP_TABLE_latest_delivery_prices ldp ON ca.id_carrier = ldp.id_carrier')
            ->innerJoin('delivery', 'd', 'ca.id_carrier = d.id_carrier AND d.id_zone IS NOT NULL')
            ->innerJoin('country', 'co', 'd.id_zone = co.id_zone AND co.iso_code IS NOT NULL AND co.active = 1')
            ->leftJoin('range_weight', 'rw', 'ca.id_carrier = rw.id_carrier AND d.id_range_weight = rw.id_range_weight')
            ->leftJoin('range_price', 'rp', 'ca.id_carrier = rp.id_carrier AND d.id_range_price = rp.id_range_price')
            ->leftJoin('state', 's', 'co.id_zone = s.id_zone AND co.id_country = s.id_country AND s.active = 1')
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
                ->select("
                    CASE
                        WHEN ca.is_free = 1 THEN 'free_shipping'
                        WHEN ca.shipping_method = 0 AND {$psShippingMethod} = 0 THEN 'range_price'
                        WHEN ca.shipping_method = 0 AND {$psShippingMethod} = 1 THEN 'range_weight'
                        WHEN ca.shipping_method = 1 THEN 'range_weight'
                        WHEN ca.shipping_method = 2 THEN 'range_price'
                    END AS shipping_method
                ")
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
     * Seek per id_reference: one page emits every (id_zone, id_range) row for
     * the next $limit references after the cursor. Returns rows plus the max
     * reference id picked in this page — cursor must advance even when the
     * join produces zero rows for those refs (fixture / config edge case),
     * otherwise the sync loops forever.
     *
     * @param string|null $lastSeekKey
     * @param int $limit max number of references emitted in this page
     * @param string $langIso
     *
     * @return array{rows: array<mixed>, lastId: int|null}
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForFull($lastSeekKey, $limit, $langIso)
    {
        $this->generateFullQuery($langIso, true);

        $refs = $this->db->executeS('
            SELECT DISTINCT ca.id_reference
              FROM ' . _DB_PREFIX_ . self::TABLE_NAME . ' ca
             WHERE ca.id_reference > ' . (int) $lastSeekKey . '
             ORDER BY ca.id_reference ASC
             LIMIT ' . (int) $limit . '
        ');

        if (!is_array($refs) || empty($refs)) {
            return ['rows' => [], 'lastId' => null];
        }

        $ids = array_map('intval', array_column($refs, 'id_reference'));
        $this->query->where('ca.id_reference IN (' . implode(',', $ids) . ')');

        return ['rows' => $this->runQuery(), 'lastId' => max($ids)];
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
     * Count distinct references strictly after the cursor — pagination
     * granularity is per-reference, not per-row.
     *
     * @param string|null $lastSeekKey
     * @param string $langIso
     *
     * @return int
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function countFullSyncContentLeft($lastSeekKey, $langIso)
    {
        return (int) $this->db->getValue('
            SELECT COUNT(DISTINCT ca.id_reference)
              FROM ' . _DB_PREFIX_ . self::TABLE_NAME . ' ca
             WHERE ca.id_reference > ' . (int) $lastSeekKey . '
        ');
    }
}
