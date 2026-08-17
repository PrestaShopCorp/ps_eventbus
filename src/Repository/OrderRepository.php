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

class OrderRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'orders';

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
        $this->generateMinimalQuery(self::TABLE_NAME, 'o');

        // minimal query for countable query
        $this->query
            ->leftJoin('currency', 'c', 'o.id_currency = c.id_currency')
            ->leftJoin('order_slip', 'os', 'o.id_order = os.id_order')
            ->leftJoin('address', 'ad', 'ad.id_address = o.id_address_delivery')
            ->leftJoin('address', 'ai', 'ai.id_address = o.id_address_invoice')
            ->leftJoin('country', 'cntd', 'cntd.id_country = ad.id_country')
            ->leftJoin('country', 'cnti', 'cnti.id_country = ai.id_country')
            // FIXME: join is not filtered by language ($langIso is ignored here).
            // order_state_lang has one row per installed language, so on multi-lang
            // shops this fans out; combined with the 1:n order_slip join it multiplies
            // the refund SUM by the language count and makes status_label arbitrary.
            // Fix: "AND osl.id_lang = <id from $langIso>" (per-language sync, like the
            // other *_lang joins), collapsing osl to one row.
            ->leftJoin('order_state_lang', 'osl', 'o.current_state = osl.id_order_state')
            ->leftJoin('order_state', 'ost', 'o.current_state = ost.id_order_state')
            ->where('o.id_shop = ' . (int) parent::getShopContext()->id)
            ->select('o.id_order')
            ->groupBy('o.id_order')
        ;

        if ($withSelecParameters) {
            $this->query
                ->select('o.reference')
                ->select('o.id_customer')
                ->select('o.id_cart')
                ->select('o.current_state')
                ->select('o.conversion_rate')
                ->select('o.total_paid_tax_excl')
                ->select('o.total_paid_tax_incl')
                ->select('c.iso_code as currency')
                ->select('o.module as payment_module')
                ->select('o.payment as payment_mode')
                ->select('o.total_paid_real')
                ->select('o.total_shipping as shipping_cost')
                ->select('o.date_add as created_at')
                ->select('o.date_upd as updated_at')
                ->select('o.id_carrier')
                ->select('o.valid as is_validated')
                ->select('ost.paid as is_paid')
                ->select('ost.shipped as is_shipped')
                ->select('osl.name as status_label')
                ->select('o.module as payment_name')
                ->select('o.id_shop_group')
                ->select('o.id_shop')
                ->select('o.id_lang')
                ->select('o.id_currency')
                ->select('o.recyclable')
                ->select('o.gift')
                ->select('o.total_discounts')
                ->select('o.total_discounts_tax_incl')
                ->select('o.total_discounts_tax_excl')
                ->select('o.total_products')
                ->select('o.total_products_wt')
                ->select('o.total_shipping_tax_incl')
                ->select('o.total_shipping_tax_excl')
                ->select('o.carrier_tax_rate')
                ->select('o.total_wrapping')
                ->select('o.total_wrapping_tax_incl')
                ->select('o.total_wrapping_tax_excl')
                ->select('o.round_mode')
                ->select('o.round_type')
                ->select('o.invoice_number')
                ->select('o.delivery_number')
                ->select('o.invoice_date')
                ->select('o.delivery_date')
                ->select('o.valid')
                ->select('SUM(os.total_products_tax_incl + os.total_shipping_tax_incl) as refund')
                ->select('SUM(os.total_products_tax_excl + os.total_shipping_tax_excl) as refund_tax_excl')
                ->select('CONCAT(CONCAT("delivery", ":", cntd.iso_code), ",", CONCAT("invoice", ":", cnti.iso_code)) as address_iso')
                ->select('IF((SELECT so.id_order FROM `' . _DB_PREFIX_ . 'orders` so WHERE so.id_customer = o.id_customer AND so.id_order < o.id_order LIMIT 1) > 0, 0, 1) as new_customer')
                ->orderBy('o.id_order ASC')
            ;
        }
    }

    /**
     * Seek-based page: returns rows strictly after $lastSeekKey, ordered by o.id_order.
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
        // Two-step (deferred join) pagination.
        //
        // The full query LEFT-joins 8 tables, aggregates (SUM over order_slip)
        // and runs a correlated subquery (new_customer) per row. If we paginate
        // it directly with "id_order > seek ... LIMIT n", the optimizer sees a
        // range estimate of ~all orders in the shop and can pick a plan with
        // "Using filesort"/temp table that materializes the whole range BEFORE
        // applying LIMIT. Cost then scales with total orders, not the page size,
        // so even limit=1 times out on shops with >1M orders.
        //
        // Instead: first pick the page's ids with a bare, covering index range
        // scan (id_shop index = (id_shop, id_order)) that LIMIT bounds to n rows,
        // then run the heavy query filtered on those ids. The joins/aggregate/
        // subquery then run for exactly n rows whatever plan the optimizer picks.
        $pageIds = $this->getFullSyncPageIds($lastSeekKey, (int) $limit);

        if (empty($pageIds)) {
            return [];
        }

        $this->generateFullQuery($langIso, true);

        $this->query->where('o.id_order IN (' . implode(',', $pageIds) . ')');

        return $this->runQuery();
    }

    /**
     * Bare, covering index range scan to select the next page of order ids.
     *
     * @param string|null $lastSeekKey
     * @param int $limit
     *
     * @return array<int>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    private function getFullSyncPageIds($lastSeekKey, $limit)
    {
        $this->generateMinimalQuery(self::TABLE_NAME, 'o');

        $this->query
            ->select('o.id_order')
            ->where('o.id_shop = ' . (int) parent::getShopContext()->id)
            ->orderBy('o.id_order ASC')
            ->limit($limit)
        ;

        if ($lastSeekKey !== null) {
            $this->query->where('o.id_order > ' . (int) $lastSeekKey);
        }

        $result = $this->db->executeS($this->query->build());

        if (!is_array($result)) {
            return [];
        }

        return array_map('intval', array_column($result, 'id_order'));
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
            ->where("o.id_order IN('" . implode("','", array_map('intval', $contentIds ?: [-1])) . "')")
            ->limit($limit)
        ;

        return $this->runQuery();
    }

    /**
     * Count rows with o.id_order > cursor.
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
        // full query only LEFT-joins and filters on o.*, grouping by the PK, so
        // none of its joins/aggregates change the set of counted orders. Count
        // the table directly (id_shop index + PK) instead of materializing the
        // joins and per-row aggregates for every remaining order.
        $this->generateMinimalQuery(self::TABLE_NAME, 'o');

        $this->query
            ->select('COUNT(*) AS count')
            ->where('o.id_shop = ' . (int) parent::getShopContext()->id)
        ;

        if ($lastSeekKey !== null) {
            $this->query->where('o.id_order > ' . (int) $lastSeekKey);
        }

        $result = $this->db->executeS($this->query->build());

        return is_array($result) && isset($result[0]['count']) ? (int) $result[0]['count'] : 0;
    }
}
