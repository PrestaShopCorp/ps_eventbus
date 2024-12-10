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

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\CartRuleRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CartRulesService extends ShopContentAbstractService implements ShopContentServiceInterface
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
                'action' => Config::INCREMENTAL_TYPE_UPSERT,
                'collection' => Config::COLLECTION_CART_RULES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<mixed> $upsertedContents
     * @param array<mixed> $deletedContents
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $upsertedContents, $deletedContents, $langIso)
    {
        $result = $this->cartRuleRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $this->castCartRules($result);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_CART_RULES, $result, $deletedContents);
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

            $cartRule['gift_product'] = (int) $cartRule['gift_product'];
            $cartRule['gift_product_attribute'] = (int) $cartRule['gift_product_attribute'];
            $cartRule['highlight'] = (bool) $cartRule['highlight'];
            $cartRule['active'] = (bool) $cartRule['active'];

            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7', '>=')) {
                $cartRule['reduction_exclude_special'] = (bool) $cartRule['reduction_exclude_special'];
            }
        }
    }
}
