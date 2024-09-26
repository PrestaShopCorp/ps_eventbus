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



namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CartRuleRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'cart_rule';

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
        $this->generateMinimalQuery(self::TABLE_NAME, 'cr');

        if ($withSelecParameters) {
            $this->query
                ->select('cr.id_cart_rule')
                ->select('cr.id_customer')
                ->select('cr.code')
                ->select('cr.date_from AS "from"')
                ->select('cr.date_to AS "to"')
                ->select('cr.description')
                ->select('cr.quantity')
                ->select('cr.quantity_per_user')
                ->select('cr.priority')
                ->select('cr.partial_use')
                ->select('cr.minimum_amount')
                ->select('cr.minimum_amount_tax')
                ->select('cr.minimum_amount_currency')
                ->select('cr.minimum_amount_shipping')
                ->select('cr.country_restriction')
                ->select('cr.carrier_restriction')
                ->select('cr.group_restriction')
                ->select('cr.cart_rule_restriction')
                ->select('cr.product_restriction')
                ->select('cr.shop_restriction')
                ->select('cr.free_shipping')
                ->select('cr.reduction_percent')
                ->select('cr.reduction_amount')
                ->select('cr.reduction_tax')
                ->select('cr.reduction_currency')
                ->select('cr.reduction_product')
                ->select('cr.gift_product')
                ->select('cr.gift_product_attribute')
                ->select('cr.highlight')
                ->select('cr.active')
                ->select('cr.date_add AS created_at')
                ->select('cr.date_upd AS updated_at')
            ;

            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7', '>=')) {
                $this->query->select('cr.reduction_exclude_special');
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
            ->where('cr.id_cart_rule IN(' . implode(',', array_map('intval', $contentIds)) . ')')
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
