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

class StoreRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'store';

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
        $this->generateMinimalQuery(self::TABLE_NAME, 's');
        $langId = (int) \Language::getIdByIso($langIso);

        // https://github.com/PrestaShop/PrestaShop/commit/7dda2be62d8bd606edc269fa051c36ea68f81682#diff-e98d435095567c145b49744715fd575eaab7050328c211b33aa9a37158421ff4R2004
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.3.0', '>=')) {
            $this->query
                ->leftJoin('store_lang', 'sl', 's.id_store = sl.id_store')
                ->leftJoin('store_shop', 'ss', 's.id_store = ss.id_store')
                ->where('ss.id_shop = ' . (int) parent::getShopContext()->id)
                ->where('sl.id_lang = ' . (int) $langId)
            ;
        }

        if ($withSelecParameters) {
            $this->query
                ->select('s.id_store')
                ->select('s.id_country')
                ->select('s.id_state')
                ->select('s.city')
                ->select('s.postcode')
                ->select('s.active')
                ->select('s.date_add as created_at')
                ->select('s.date_upd as updated_at')
                ->orderBy('s.id_store ASC')
            ;

            // https://github.com/PrestaShop/PrestaShop/commit/7dda2be62d8bd606edc269fa051c36ea68f81682#diff-e98d435095567c145b49744715fd575eaab7050328c211b33aa9a37158421ff4R2004
            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.3.0', '>=')) {
                $this->query
                    ->select('sl.id_lang')
                    ->select('sl.name')
                    ->select('sl.address1')
                    ->select('sl.address2')
                    ->select('sl.hours')
                    ->select('ss.id_shop')
                ;
            } else {
                $this->query
                    ->select('s.name')
                    ->select('s.address1')
                    ->select('s.address2')
                    ->select('s.hours')
                ;
            }
        }
    }

    /**
     * Seek-based page: returns rows strictly after $lastSeekKey, ordered by s.id_store.
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
            $this->query->where('s.id_store > ' . (int) $lastSeekKey);
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
            ->where("s.id_store IN('" . implode("','", array_map('intval', $contentIds ?: [-1])) . "')")
            ->limit($limit)
        ;

        return $this->runQuery();
    }

    /**
     * Count rows with s.id_store > cursor.
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
            $this->query->where('s.id_store > ' . (int) $lastSeekKey);
        }

        $this->query->select('COUNT(*) as count');

        $result = $this->runQuery(true);

        return !empty($result[0]['count']) ? (int) $result[0]['count'] : 0;
    }
}
