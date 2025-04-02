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

class SpecificPriceRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'specific_price';

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
        $this->generateMinimalQuery(self::TABLE_NAME, 'sp');

        $this->query
            ->leftJoin('country', 'c', 'c.id_country = sp.id_country')
            ->leftJoin('currency', 'cur', 'cur.id_currency = sp.id_currency')
        ;

        $this->query->where('sp.id_shop = 0 OR sp.id_shop = ' . (int) parent::getShopContext()->id);

        if ($withSelecParameters) {
            $this->query
                ->select('sp.id_specific_price')
                ->select('sp.id_product')
                ->select('sp.id_shop')
                ->select('sp.id_shop_group')
                ->select('sp.id_currency')
                ->select('sp.id_country')
                ->select('sp.id_group') // different
                ->select('sp.id_customer')
                ->select('sp.id_product_attribute')
                ->select('sp.price')
                ->select('sp.from_quantity')
                ->select('sp.reduction')
                ->select('sp.reduction_tax')
                ->select('sp.from')
                ->select('sp.to')
                ->select('sp.reduction_type')
                ->select('c.iso_code as country') // different
                ->select('cur.iso_code as currency') // different
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

        $this->query->limit((int) $limit, (int) $offset);

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
            ->where("sp.id_specific_price IN('" . implode("','", array_map('intval', $contentIds ?: [-1])) . "')")
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
        $this->generateFullQuery($langIso, false);

        $this->query->select('(COUNT(*) - ' . (int) $offset . ') as count');

        $result = $this->runQuery(true);

        return !empty($result[0]['count']) ? $result[0]['count'] : 0;
    }

    /**
     * @param int $specificPriceId
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getSpecificPriceById($specificPriceId)
    {
        if (!$specificPriceId) {
            return [];
        }

        $this->generateMinimalQuery(self::TABLE_NAME, 'sp');

        $this->query->where('sp.id_specific_price= ' . (int) $specificPriceId);

        $this->query
            ->select('sp.id_specific_price')
            ->select('sp.id_product')
            ->select('sp.id_shop')
            ->select('sp.id_shop_group')
            ->select('sp.id_currency')
            ->select('sp.id_country')
            ->select('sp.id_customer')
            ->select('sp.id_product_attribute')
            ->select('sp.price')
            ->select('sp.from_quantity')
            ->select('sp.reduction')
            ->select('sp.reduction_tax')
            ->select('sp.from')
            ->select('sp.to')
            ->select('sp.reduction_type')
            ->select('sp.id_specific_price_rule') // different
            ->select('sp.id_cart') // different
        ;

        return $this->runQuery(true);
    }
}
