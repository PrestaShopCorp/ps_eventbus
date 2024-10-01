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

class StoreRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'store';

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
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForFull($offset, $limit, $langIso, $debug)
    {
        $this->generateFullQuery($langIso, true);

        $this->query->limit((int) $limit, (int) $offset);

        return $this->runQuery($debug);
    }

    /**
     * @param int $limit
     * @param array<mixed> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $this->generateFullQuery($langIso, true);

        $this->query
            ->where('s.id_store IN(' . implode(',', array_map('intval', $contentIds)) . ')')
            ->limit($limit)
        ;

        return $this->runQuery($debug);
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
        $this->generateFullQuery($langIso, false);

        $this->query->select('(COUNT(*) - ' . (int) $offset . ') as count');

        $result = $this->runQuery(false);

        return $result[0]['count'];
    }
}
