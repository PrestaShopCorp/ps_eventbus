<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\CartProductRepository;
use PrestaShop\Module\PsEventbus\Repository\CartRepository;

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
     * @param CartRepository $cartRepository
     * @param CartProductRepository $cartProductRepository
     */
    public function __construct(
        CartRepository $cartRepository,
        CartProductRepository $cartProductRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->cartProductRepository = $cartProductRepository;
    }

    public function getFormattedData($offset, $limit, $langIso)
    {
        $carts = $this->cartRepository->getCarts($offset, $limit);

        if (!is_array($carts)) {
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
     * @param array<mixed> $carts
     *
     * @return void
     */
    private function castCartValues(&$carts)
    {
        foreach ($carts as &$cart) {
            $cart['id_cart'] = (string) $cart['id_cart'];
        }
    }

    /**
     * @param array<mixed> $cartProducts
     *
     * @return void
     */
    private function castCartProductValues(&$cartProducts)
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
     * @param array<mixed> $objectIds
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
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
     * @param array<mixed> $carts
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function getCartProducts($carts)
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
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        return $this->cartRepository->getQueryForDebug($offset, $limit);
    }
}
