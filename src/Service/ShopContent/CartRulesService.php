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
use PrestaShop\Module\PsEventbus\Repository\CartRuleRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CartRulesService implements ShopContentServiceInterface
{
    /** @var CartRuleRepository */
    private $cartRuleRepository;

    public function __construct(CartRuleRepository $cartRuleRepository)
    {
        $this->cartRuleRepository = $cartRuleRepository;
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
        $result = $this->cartRuleRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castCartRules($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_cart_rule'],
                'collection' => Config::COLLECTION_CART_RULES,
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
        $result = $this->cartRuleRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castCartRules($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_cart_rule'],
                'collection' => Config::COLLECTION_CART_RULES,
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
        return $this->cartRuleRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $cartRules
     *
     * @return void
     */
    private function castCartRules(&$cartRules)
    {
        foreach ($cartRules as &$cartRule) {
            $cartRule['id_cart_rule'] = (int) $cartRule['id_cart_rule'];
            $cartRule['id_customer'] = (int) $cartRule['id_customer'];
            $cartRule['quantity'] = (int) $cartRule['quantity'];
            $cartRule['quantity_per_user'] = (int) $cartRule['quantity_per_user'];
            $cartRule['priority'] = (int) $cartRule['priority'];
            $cartRule['partial_use'] = (bool) $cartRule['partial_use'];
            $cartRule['minimum_amount'] = (float) $cartRule['minimum_amount'];
            $cartRule['minimum_amount_tax'] = (bool) $cartRule['minimum_amount_tax'];
            $cartRule['minimum_amount_currency'] = (int) $cartRule['minimum_amount_currency'];
            $cartRule['minimum_amount_shipping'] = (bool) $cartRule['minimum_amount_shipping'];
            $cartRule['country_restriction'] = (bool) $cartRule['country_restriction'];
            $cartRule['carrier_restriction'] = (bool) $cartRule['carrier_restriction'];
            $cartRule['group_restriction'] = (bool) $cartRule['group_restriction'];
            $cartRule['cart_rule_restriction'] = (bool) $cartRule['cart_rule_restriction'];
            $cartRule['product_restriction'] = (bool) $cartRule['product_restriction'];
            $cartRule['shop_restriction'] = (bool) $cartRule['shop_restriction'];
            $cartRule['free_shipping'] = (bool) $cartRule['free_shipping'];
            $cartRule['reduction_percent'] = (float) $cartRule['reduction_percent'];
            $cartRule['reduction_amount'] = (float) $cartRule['reduction_amount'];
            $cartRule['reduction_tax'] = (bool) $cartRule['reduction_tax'];
            $cartRule['reduction_currency'] = (int) $cartRule['reduction_currency'];
            $cartRule['reduction_product'] = (int) $cartRule['reduction_product'];
            $cartRule['reduction_exclude_special'] = (bool) $cartRule['reduction_exclude_special'];
            $cartRule['gift_product'] = (int) $cartRule['gift_product'];
            $cartRule['gift_product_attribute'] = (int) $cartRule['gift_product_attribute'];
            $cartRule['highlight'] = (bool) $cartRule['highlight'];
            $cartRule['active'] = (bool) $cartRule['active'];
        }
    }
}
