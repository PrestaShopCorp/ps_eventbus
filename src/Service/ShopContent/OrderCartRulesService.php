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

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\OrderCartRuleRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class OrderCartRulesService implements ShopContentServiceInterface
{
    /** @var OrderCartRuleRepository */
    private $orderCartRuleRepository;

    public function __construct(OrderCartRuleRepository $orderCartRuleRepository)
    {
        $this->orderCartRuleRepository = $orderCartRuleRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso)
    {
        $result = $this->orderCartRuleRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castOrderCartRules($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_order_cart_rule'],
                'collection' => Config::COLLECTION_ORDER_CART_RULES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<string, int> $contentIds
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso)
    {
        $result = $this->orderCartRuleRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castOrderCartRules($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_order_cart_rule'],
                'collection' => Config::COLLECTION_ORDER_CART_RULES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return int
     */
    public function getFullSyncContentLeft($offset, $limit, $langIso)
    {
        return $this->orderCartRuleRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $orderCartRules
     *
     * @return void
     */
    private function castOrderCartRules(&$orderCartRules)
    {
        foreach ($orderCartRules as &$orderCartRule) {
            $orderCartRule['id_cart_rule'] = (int) $orderCartRule['id_cart_rule'];
            $orderCartRule['id_customer'] = (int) $orderCartRule['id_customer'];
            $orderCartRule['quantity'] = (int) $orderCartRule['quantity'];
            $orderCartRule['quantity_per_user'] = (int) $orderCartRule['quantity_per_user'];
            $orderCartRule['priority'] = (int) $orderCartRule['priority'];
            $orderCartRule['partial_use'] = (bool) $orderCartRule['partial_use'];
            $orderCartRule['minimum_amount'] = (float) $orderCartRule['minimum_amount'];
            $orderCartRule['minimum_amount_tax'] = (bool) $orderCartRule['minimum_amount_tax'];
            $orderCartRule['minimum_amount_currency'] = (int) $orderCartRule['minimum_amount_currency'];
            $orderCartRule['minimum_amount_shipping'] = (bool) $orderCartRule['minimum_amount_shipping'];
            $orderCartRule['country_restriction'] = (bool) $orderCartRule['country_restriction'];
            $orderCartRule['carrier_restriction'] = (bool) $orderCartRule['carrier_restriction'];
            $orderCartRule['group_restriction'] = (bool) $orderCartRule['group_restriction'];
            $orderCartRule['cart_rule_restriction'] = (bool) $orderCartRule['cart_rule_restriction'];
            $orderCartRule['product_restriction'] = (bool) $orderCartRule['product_restriction'];
            $orderCartRule['shop_restriction'] = (bool) $orderCartRule['shop_restriction'];
            $orderCartRule['free_shipping'] = (bool) $orderCartRule['free_shipping'];
            $orderCartRule['reduction_percent'] = (float) $orderCartRule['reduction_percent'];
            $orderCartRule['reduction_amount'] = (float) $orderCartRule['reduction_amount'];
            $orderCartRule['reduction_tax'] = (bool) $orderCartRule['reduction_tax'];
            $orderCartRule['reduction_currency'] = (int) $orderCartRule['reduction_currency'];
            $orderCartRule['reduction_product'] = (int) $orderCartRule['reduction_product'];
            $orderCartRule['reduction_exclude_special'] = (bool) $orderCartRule['reduction_exclude_special'];
            $orderCartRule['gift_product'] = (int) $orderCartRule['gift_product'];
            $orderCartRule['gift_product_attribute'] = (int) $orderCartRule['gift_product_attribute'];
            $orderCartRule['highlight'] = (bool) $orderCartRule['highlight'];
            $orderCartRule['active'] = (bool) $orderCartRule['active'];
        }
    }
}
