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

class BundleRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'pack';

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
        $this->generateMinimalQuery(self::TABLE_NAME, 'pac');

        $this->query
            ->innerJoin('product', 'p', 'p.id_product = pac.id_product_pack')
            ->innerJoin('product_shop', 'ps', 'ps.id_product = p.id_product AND ps.id_shop = ' . parent::getShopContext()->id)
            ->leftJoin('product_attribute_shop', 'pas', 'pas.id_product = p.id_product AND pas.id_shop = ps.id_shop')
            ->where('p.cache_is_pack=1')
        ;

        if ($withSelecParameters) {
            $this->query
                ->select('pac.id_product_item as id_product')
                ->select("CONCAT(p.id_product, '-', IFNULL(pas.id_product_attribute, 0), '-', '" . pSQL($langIso) . "') as unique_product_id")
                ->select('pac.id_product_pack as id_bundle')
                ->select('pac.id_product_attribute_item as id_product_attribute')
                ->select('pac.quantity')
                ->orderBy('pac.id_product_pack ASC')
            ;
        }
    }

    /**
     * Seek-based page: returns rows strictly after $lastSeekKey, ordered by pac.id_product_pack.
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
            $this->query->where('pac.id_product_pack > ' . (int) $lastSeekKey);
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
            ->where("pac.id_product_pack IN('" . implode("','", array_map('intval', $contentIds ?: [-1])) . "')")
            ->limit($limit)
        ;

        return $this->runQuery();
    }

    /**
     * Count rows with pac.id_product_pack > cursor.
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
            $this->query->where('pac.id_product_pack > ' . (int) $lastSeekKey);
        }

        $this->query->select('COUNT(*) as count');

        $result = $this->runQuery(true);

        return !empty($result[0]['count']) ? (int) $result[0]['count'] : 0;
    }
}
