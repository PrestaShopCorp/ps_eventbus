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

class ImageRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'image';

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
        $this->generateMinimalQuery(self::TABLE_NAME, 'i');

        $this->query
            ->leftJoin('image_lang', 'il', 'il.id_image = i.id_image')
            ->leftJoin('image_shop', 'is', 'is.id_image = i.id_image');

        if ($withSelecParameters) {
            $this->query
                ->select('i.id_image')
                ->select('i.id_product')
                ->select('i.position')
                ->select('i.cover')
                ->select('il.id_lang')
                ->select('il.legend')
                ->select('is.id_shop')
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
            ->where('i.id_image IN(' . implode(',', array_map('intval', $contentIds)) . ')')
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
}
