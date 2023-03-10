<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\CartProductRepository;
use PrestaShop\Module\PsEventbus\Repository\CartRepository;
use PrestaShop\Module\PsEventbus\Repository\CartRuleRepository;

class CartDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var CartRepository
     */
    private $cartRepository;
    /**
     * @var CartProductRepository
     */
    private $cartProductRepository;
    /**
     * @var CartRuleRepository
     */
    private $cartRuleRepository;

    /**
     * @param CartRepository $cartRepository
     * @param CartProductRepository $cartProductRepository
     */
    public function __construct(
        CartRepository $cartRepository,
        CartProductRepository $cartProductRepository,
        CartRuleRepository $cartRuleRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->cartProductRepository = $cartProductRepository;
        $this->cartRuleRepository = $cartRuleRepository;
    }

    public function getFormattedData($offset, $limit, $langIso)
    {
        $carts = $this->cartRepository->getCarts($offset, $limit);

        if (!is_array($carts)) {
            return [];
        }

        $cartProducts = $this->getCartProducts($carts);

        $this->castCartValues($carts);

        $cartRules = $this->getCartRules();

        $carts = array_map(function ($cart) {
            return [
                'id' => $cart['id_cart'],
                'collection' => Config::COLLECTION_CARTS,
                'properties' => $cart,
            ];
        }, $carts);

        return array_merge($carts, $cartProducts, $cartRules);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->cartRepository->getRemainingCartsCount($offset);
    }

    /**
     * @param array $carts
     *
     * @return void
     */
    private function castCartValues(array &$carts)
    {
        foreach ($carts as &$cart) {
            $cart['id_cart'] = (string) $cart['id_cart'];
        }
    }

    /**
     * @param array $cartProducts
     *
     * @return void
     */
    private function castCartProductValues(array &$cartProducts)
    {
        foreach ($cartProducts as &$cartProduct) {
            $cartProduct['id_cart_product'] = (string) "{$cartProduct['id_cart']}-{$cartProduct['id_product']}-{$cartProduct['id_product_attribute']}";
            $cartProduct['id_cart'] = (string) $cartProduct['id_cart'];
            $cartProduct['id_product'] = (string) $cartProduct['id_product'];
            $cartProduct['id_product_attribute'] = (string) $cartProduct['id_product_attribute'];
            $cartProduct['quantity'] = (int) $cartProduct['quantity'];
        }
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array $objectIds
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        $carts = $this->cartRepository->getCartsIncremental($limit, $objectIds);

        if (!is_array($carts) || empty($carts)) {
            return [];
        }

        $cartProducts = $this->getCartProducts($carts);

        $this->castCartValues($carts);

        $carts = array_map(function ($cart) {
            return [
                'id' => $cart['id_cart'],
                'collection' => Config::COLLECTION_CARTS,
                'properties' => $cart,
            ];
        }, $carts);

        return array_merge($carts, $cartProducts);
    }

    /**
     * @param array $carts
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    private function getCartProducts(array $carts)
    {
        $cartIds = array_map(function ($cart) {
            return (string) $cart['id_cart'];
        }, $carts);

        $cartProducts = $this->cartProductRepository->getCartProducts($cartIds);

        if (!is_array($cartProducts) || empty($cartProducts)) {
            return [];
        }

        $this->castCartProductValues($cartProducts);

        if (is_array($cartProducts)) {
            return array_map(function ($cartProduct) {
                return [
                    'id' => "{$cartProduct['id_cart']}-{$cartProduct['id_product']}-{$cartProduct['id_product_attribute']}",
                    'collection' => Config::COLLECTION_CART_PRODUCTS,
                    'properties' => $cartProduct,
                ];
            }, $cartProducts);
        }

        return [];
    }

    /**
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    private function getCartRules()
    {
        $cartRules = $this->cartRuleRepository->getCartRules();

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
