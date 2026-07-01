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

class CartProductRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'cart_product';

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
        $this->generateMinimalQuery(self::TABLE_NAME, 'cp');

        $this->query->where('cp.id_shop = ' . (int) parent::getShopContext()->id);

        if ($withSelecParameters) {
            $this->query
                ->select('cp.id_cart')
                ->select('cp.id_product')
                ->select('cp.id_product_attribute')
                ->select('cp.quantity')
                ->select('cp.date_add as created_at')
                ->orderBy('cp.id_cart ASC')
            ;
        }
    }

    /**
     * Seek per id_cart: one page emits every (id_product, id_product_attribute)
     * row for the next $limit carts after the cursor. $limit applies to the
     * cart count, not the row count — paginating per row would split a cart
     * across pages and the seek cursor (id_cart) would skip the remainder.
     *
     * @param string|null $lastSeekKey
     * @param int $limit max number of carts emitted in this page
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

        $shopId = (int) parent::getShopContext()->id;

        $carts = $this->db->executeS('
            SELECT DISTINCT cp.id_cart
              FROM ' . _DB_PREFIX_ . self::TABLE_NAME . ' cp
             WHERE cp.id_shop = ' . $shopId . '
               AND cp.id_cart > ' . (int) $lastSeekKey . '
             ORDER BY cp.id_cart ASC
             LIMIT ' . (int) $limit . '
        ');

        if (!is_array($carts) || empty($carts)) {
            return ['rows' => [], 'lastId' => null];
        }

        $ids = array_map('intval', array_column($carts, 'id_cart'));
        $this->query->where('cp.id_cart IN (' . implode(',', $ids) . ')');

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
            ->where("cp.id_cart IN('" . implode("','", array_map('intval', $contentIds ?: [-1])) . "')")
            // ->limit($limit) Sub shop content depend from another, temporary disabled
        ;

        return $this->runQuery();
    }

    /**
     * Count distinct carts strictly after the cursor — pagination granularity
     * is per-cart, not per-row.
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
        $shopId = (int) parent::getShopContext()->id;

        return (int) $this->db->getValue('
            SELECT COUNT(DISTINCT cp.id_cart)
              FROM ' . _DB_PREFIX_ . self::TABLE_NAME . ' cp
             WHERE cp.id_shop = ' . $shopId . '
               AND cp.id_cart > ' . (int) $lastSeekKey . '
        ');
    }
}
