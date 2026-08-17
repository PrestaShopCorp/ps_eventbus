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
                // Ordered by the (id_cart, id_product, id_product_attribute)
                // triple, a prefix of the PK, so seek pages stay index-ordered.
                ->orderBy('cp.id_cart ASC, cp.id_product ASC, cp.id_product_attribute ASC')
            ;
        }
    }

    /**
     * Seek-based page: returns rows strictly after the (id_cart, id_product,
     * id_product_attribute) triple encoded in $lastSeekKey.
     *
     * Was offset-based (LIMIT n OFFSET k), which scans and discards k rows on
     * every page: O(offset) cost that degrades to a timeout on shops with a
     * large cart_product table (abandoned/guest carts). Seek on the PK-prefix
     * triple instead so each page is an index range scan bounded to n rows.
     *
     * @param string|null $lastSeekKey "{id_cart}-{id_product}-{id_product_attribute}"
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

        if ($lastSeekKey !== null && $lastSeekKey !== '') {
            $this->query->where($this->buildSeekWhere($lastSeekKey));
        }

        $this->query->limit((int) $limit);

        return $this->runQuery();
    }

    /**
     * Explicit OR form of the composite-key comparison, kept so the PK prefix
     * (id_cart, id_product, id_product_attribute) stays usable for the seek.
     *
     * @param string $lastSeekKey
     *
     * @return string
     */
    private function buildSeekWhere($lastSeekKey)
    {
        list($lastCart, $lastProduct, $lastAttribute) = $this->decodeTripleSeekKey($lastSeekKey);

        return '('
            . 'cp.id_cart > ' . $lastCart
            . ' OR (cp.id_cart = ' . $lastCart . ' AND cp.id_product > ' . $lastProduct . ')'
            . ' OR (cp.id_cart = ' . $lastCart . ' AND cp.id_product = ' . $lastProduct
                . ' AND cp.id_product_attribute > ' . $lastAttribute . ')'
            . ')';
    }

    /**
     * @param string $seekKey "{id_cart}-{id_product}-{id_product_attribute}"
     *
     * @return array{0: int, 1: int, 2: int}
     */
    private function decodeTripleSeekKey($seekKey)
    {
        $parts = explode('-', $seekKey, 3);

        return [
            (int) $parts[0],
            isset($parts[1]) ? (int) $parts[1] : 0,
            isset($parts[2]) ? (int) $parts[2] : 0,
        ];
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
     * Count rows strictly after the seek-key triple.
     *
     * @param string|null $lastSeekKey "{id_cart}-{id_product}-{id_product_attribute}"
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

        $sql = '
            SELECT COUNT(*)
              FROM ' . _DB_PREFIX_ . self::TABLE_NAME . ' cp
             WHERE cp.id_shop = ' . $shopId;

        if ($lastSeekKey !== null && $lastSeekKey !== '') {
            $sql .= ' AND ' . $this->buildSeekWhere($lastSeekKey);
        }

        return (int) $this->db->getValue($sql);
    }
}
