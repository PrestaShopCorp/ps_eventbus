<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\CartRuleRepository;

class CartRuleDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var CartRuleRepository
     */
    private $cartRuleRepository;

    /**
     * @param CartRuleRepository $cartRuleRepository
     */
    public function __construct(
        CartRuleRepository $cartRuleRepository
    ) {
        $this->cartRuleRepository = $cartRuleRepository;
    }

    public function getFormattedData($offset, $limit, $langIso)
    {
        $cartRules = $this->cartRuleRepository->getCartRules($limit, $offset);

        if (!is_array($cartRules) || empty($cartRules)) {
            return [];
        }

        $this->castCartRuleValues($cartRules);

        if (is_array($cartRules)) {
            return array_map(function ($cartRule) {
                return [
                  'id' => $cartRule['id_cart_rule'],
                  'collection' => Config::COLLECTION_CART_RULES,
                  'properties' => $cartRule,
                ];
            }, $cartRules);
        }

        return [];
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->cartRuleRepository->getRemainingCartRulesCount($offset);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array $objectIds
     *
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        $cartRules = $this->cartRuleRepository->getCartRulesIncremental($limit, $objectIds);

        if (!is_array($cartRules)) {
            return [];
        }

        $this->castCartRuleValues($cartRules);

        return array_map(function ($cartRule) {
            return [
              'id' => $cartRule['id_cart_rule'],
              'collection' => Config::COLLECTION_CART_RULES,
              'properties' => $cartRule,
            ];
        }, $cartRules);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        return $this->cartRuleRepository->getQueryForDebug($limit, $offset);
    }

    /**
     * @param array $cartRules
     *
     * @return void
     */
    private function castCartRuleValues(array &$cartRules)
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
