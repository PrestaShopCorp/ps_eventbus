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

class CarrierTaxeRepository extends AbstractRepository implements RepositoryInterface
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

        // minimal query for countable query
        $this->query
            ->innerJoin('carrier_tax_rules_group_shop', 'ctrgs', 'ca.id_carrier = ctrgs.id_carrier')
            ->innerJoin('tax_rule', 'tr', 'ctrgs.id_tax_rules_group = tr.id_tax_rules_group')
            ->innerJoin('country', 'co', 'tr.id_country = co.id_country AND co.iso_code IS NOT NULL AND co.active = 1')
            ->innerJoin('delivery', 'd', 'ca.id_carrier = d.id_carrier AND d.id_zone IS NOT NULL')
            ->innerJoin('tax', 't', 'tr.id_tax = t.id_tax AND t.active = 1')
            ->leftJoin('state', 's', 'tr.id_state = s.id_state AND s.active = 1')
            ->where('(co.id_zone = d.id_zone OR s.id_zone = d.id_zone)')
            ->select('ca.id_reference')
            ->select('ca.id_carrier')
            ->groupBy('ca.id_carrier, ca.id_reference, co.id_zone, id_range, country_id')
        ;

        if ($withSelecParameters) {
            $this->query
                ->select('co.id_zone')
                ->select('
                    CASE
                        WHEN d.id_range_weight IS NOT NULL AND d.id_range_weight != 0 THEN d.id_range_weight
                        WHEN d.id_range_price IS NOT NULL AND d.id_range_price != 0 THEN d.id_range_price
                    END AS id_range
                ')
                ->select('ctrgs.id_tax_rules_group AS id_carrier_tax')
                ->select('co.iso_code as country_id')
                ->select('
                    GROUP_CONCAT(
                        DISTINCT
                        s.iso_code
                        ORDER BY s.iso_code ASC
                        SEPARATOR \',\'
                    ) AS state_ids
                ')
                ->select('t.rate AS tax_rate')
                ->orderBy('ca.id_carrier ASC')
            ;
        }
    }

    /**
     * Seek-based page: returns rows strictly after $lastSeekKey, ordered by ca.id_carrier.
     * The outbox id_object for carrier_taxes is the parent id_carrier, so pagination
     * is also by id_carrier — a page may include multiple rows per carrier and
     * $limit is therefore approximate.
     *
     * @param string|null $lastSeekKey
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForFull($lastSeekKey, $limit, $langIso)
    {
        $this->generateFullQuery($langIso, true);

        if ($lastSeekKey !== null) {
            $this->query->where('ca.id_carrier > ' . (int) $lastSeekKey);
        }

        $this->query->limit((int) $limit);

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
     * Count rows with ca.id_carrier > cursor. Uses a subquery wrapper because
     * the underlying query has a GROUP BY and aggregate selects.
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
        $this->generateFullQuery($langIso, true);

        if ($lastSeekKey !== null) {
            $this->query->where('ca.id_carrier > ' . (int) $lastSeekKey);
        }

        $result = $this->db->executeS('
            SELECT COUNT(*) AS count
                FROM (' . $this->query->build() . ') as subquery;
        ');

        return is_array($result) && isset($result[0]['count']) ? (int) $result[0]['count'] : 0;
    }
}
