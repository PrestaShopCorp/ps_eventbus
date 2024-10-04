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

class CategoryRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'category_shop';

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
        $this->generateMinimalQuery(self::TABLE_NAME, 'cs');

        $this->query
            ->innerJoin('category', 'c', 'cs.id_category = c.id_category')
            ->leftJoin('category_lang', 'cl', 'cl.id_category = cs.id_category')
            ->leftJoin('lang', 'l', 'l.id_lang = cl.id_lang')
            ->where('cs.id_shop = ' . parent::getShopContext()->id)
            ->where('cl.id_shop = cs.id_shop')
            ->where('l.iso_code = "' . pSQL($langIso) . '"')
        ;

        if ($withSelecParameters) {
            $this->query
                ->select('CONCAT(cs.id_category, "-", l.iso_code) as unique_category_id')
                ->select('cs.id_category')
                ->select('c.id_parent')
                ->select('cl.name')
                ->select('cl.description')
                ->select('cl.link_rewrite')
                ->select('cl.meta_title')
                ->select('cl.meta_keywords')
                ->select('cl.meta_description')
                ->select('l.iso_code')
                ->select('c.date_add as created_at')
                ->select('c.date_upd as updated_at')
            ;
        }
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $explainSql
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForFull($offset, $limit, $langIso, $explainSql)
    {
        $this->generateFullQuery($langIso, true);

        $this->query->limit((int) $limit, (int) $offset);

        return $this->runQuery($explainSql);
    }

    /**
     * @param int $limit
     * @param array<mixed> $contentIds
     * @param string $langIso
     * @param bool $explainSql
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForIncremental($limit, $contentIds, $langIso, $explainSql)
    {
        $this->generateFullQuery($langIso, true);

        $this->query
            ->where('cs.id_category IN(' . implode(',', array_map('intval', $contentIds)) . ')')
            ->limit($limit)
        ;

        return $this->runQuery($explainSql);
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

    /**
     * @param int $langId
     * @param int $shopId
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCategoriesWithParentInfo($langId, $shopId)
    {
        $this->generateMinimalQuery('category', 'c');

        $this->query
            ->leftJoin('category_lang', 'cl', 'cl.id_category = c.id_category AND cl.id_shop = ' . (int) $shopId)
            ->where('cl.id_lang = ' . (int) $langId)
            ->orderBy('cl.id_category')
        ;

        $this->query
            ->select('c.id_category')
            ->select('cl.name')
            ->select('c.id_parent')
        ;

        return $this->runQuery(false);
    }
}
