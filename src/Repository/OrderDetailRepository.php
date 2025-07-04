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

class OrderDetailRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'order_detail';

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
        $context = \Context::getContext();

        if ($context == null) {
            throw new \PrestaShopException('Context is null');
        }

        if ($context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $this->generateMinimalQuery(self::TABLE_NAME, 'od');

        $this->query
            ->innerJoin('orders', 'o', 'od.id_order = o.id_order')
            ->leftJoin('product_shop', 'ps', 'od.product_id = ps.id_product AND ps.id_shop = ' . (int) $context->shop->id)
            ->leftJoin('currency', 'c', 'c.id_currency = o.id_currency')
            ->leftJoin('lang', 'l', 'o.id_lang = l.id_lang')
            ->select('od.id_order_detail')
        ;

        $refundRequest = '(SELECT osd.total_price_tax_incl
            FROM ' . _DB_PREFIX_ . 'order_slip_detail osd
            WHERE osd.id_order_detail = od.id_order_detail) AS refund';

        $refundTaxExclRequest = '(SELECT osd.total_price_tax_excl
            FROM ' . _DB_PREFIX_ . 'order_slip_detail osd
            WHERE osd.id_order_detail = od.id_order_detail) AS refund_tax_excl';

        if ($withSelecParameters) {
            $this->query
                ->select('od.id_order')
                ->select('od.product_id')
                ->select('od.product_attribute_id')
                ->select('od.product_quantity')
                ->select('od.unit_price_tax_incl')
                ->select('od.unit_price_tax_excl')
                ->select($refundRequest)
                ->select($refundTaxExclRequest)
                ->select('c.iso_code as currency')
                ->select('ps.id_category_default as category')
                ->select('l.iso_code')
                ->select('o.conversion_rate as conversion_rate')
            ;
        }
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForFull($offset, $limit, $langIso)
    {
        $this->generateFullQuery($langIso, true);

        $context = \Context::getContext();

        if ($context == null) {
            throw new \PrestaShopException('Context is null');
        }

        if ($context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $seekStartIdResult = $this->db->executeS(
            'SELECT id_order_detail
            FROM ' . _DB_PREFIX_ . self::TABLE_NAME . '
            WHERE id_shop = ' . (int) $context->shop->id . '
            ORDER BY id_order_detail
            LIMIT ' . (int) $offset . ', 1'
        );

        $seekStartId = 0;

        if (
            is_array($seekStartIdResult)
            && !empty($seekStartIdResult)
            && isset($seekStartIdResult[0]['id_order_detail'])
        ) {
            $seekStartId = (int) $seekStartIdResult[0]['id_order_detail'];
        }

        $this->query
            ->where('od.id_order_detail >=' . $seekStartId)
            ->limit((int) $limit);

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
            ->where("od.id_order_detail IN('" . implode("','", array_map('intval', $contentIds ?: [-1])) . "')")
            ->limit($limit)
        ;

        return $this->runQuery();
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
        $this->generateFullQuery($langIso, true);

        $result = $this->db->executeS('
            SELECT COUNT(*) - ' . (int) $offset . ' AS count
                FROM (' . $this->query->build() . ') as subquery;
        ');

        return is_array($result) ? $result[0]['count'] : 0;
    }
}
