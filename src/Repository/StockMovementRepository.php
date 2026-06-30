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

class StockMovementRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'stock_mvt';

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
        $this->generateMinimalQuery(self::TABLE_NAME, 'sm');

        $this->query
            ->innerJoin('stock_mvt_reason', 'smr', 'sm.id_stock_mvt_reason = smr.id_stock_mvt_reason')
            ->innerJoin('stock_mvt_reason_lang', 'smrl', 'sm.id_stock_mvt_reason = smrl.id_stock_mvt_reason AND smrl.id_lang = ' . (int) parent::getShopContext()->id);

        if ($withSelecParameters) {
            $this->query
                ->select('sm.id_stock_mvt')
                ->select('sm.id_stock')
                ->select('sm.id_order')
                ->select('sm.id_supply_order')
                ->select('sm.id_stock_mvt_reason')
                ->select('smrl.name')
                ->select('smrl.id_lang')
                ->select('sm.id_employee')
                ->select('sm.employee_lastname')
                ->select('sm.employee_firstname')
                ->select('sm.physical_quantity')
                ->select('sm.date_add')
                ->select('sm.sign')
                ->select('sm.price_te')
                ->select('sm.last_wa')
                ->select('sm.current_wa')
                ->select('sm.referer')
                ->select('smr.deleted')
                ->orderBy('sm.id_stock_mvt ASC')
            ;
        }
    }

    /**
     * Seek-based page: returns rows strictly after $lastSeekKey, ordered by sm.id_stock_mvt.
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
            $this->query->where('sm.id_stock_mvt > ' . (int) $lastSeekKey);
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

        $this->query->where("sm.id_stock_mvt IN('" . implode("','", array_map('intval', $contentIds ?: [-1])) . "')");

        return $this->runQuery();
    }

    /**
     * Count rows with sm.id_stock_mvt > cursor.
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
        $this->generateFullQuery($langIso, false);

        if ($lastSeekKey !== null) {
            $this->query->where('sm.id_stock_mvt > ' . (int) $lastSeekKey);
        }

        $this->query->select('COUNT(*) as count');

        $result = $this->runQuery(true);

        return !empty($result[0]['count']) ? (int) $result[0]['count'] : 0;
    }
}
