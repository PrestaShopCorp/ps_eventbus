<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\CartProductRepository;

class CartProductsService implements ShopContentServiceInterface
{
    /** @var CartProductRepository */
    private $cartProductRepository;

    public function __construct(CartProductRepository $cartProductRepository)
    {
        $this->cartProductRepository = $cartProductRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $debug)
    {
        $result = $this->cartProductRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castCartProducts($result);

        return array_map(function ($item) {
            return [
                'id' => "{$item['id_cart']}-{$item['id_product']}-{$item['id_product_attribute']}",
                'collection' => Config::COLLECTION_CART_PRODUCTS,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<string, int> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $result = $this->cartProductRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castCartProducts($result);

        return array_map(function ($item) {
            return [
                'id' => "{$item['id_cart']}-{$item['id_product']}-{$item['id_product_attribute']}",
                'collection' => Config::COLLECTION_CART_PRODUCTS,
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
        return $this->cartProductRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $cartProducts
     *
     * @return void
     */
    private function castCartProducts(&$cartProducts)
    {
        foreach ($cartProducts as &$cartProduct) {
            $cartProduct['id_cart_product'] = (string) "{$cartProduct['id_cart']}-{$cartProduct['id_product']}-{$cartProduct['id_product_attribute']}";
            $cartProduct['id_cart'] = (string) $cartProduct['id_cart'];
            $cartProduct['id_product'] = (string) $cartProduct['id_product'];
            $cartProduct['id_product_attribute'] = (string) $cartProduct['id_product_attribute'];
            $cartProduct['quantity'] = (int) $cartProduct['quantity'];
        }
    }
}
