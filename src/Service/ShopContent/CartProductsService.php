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
use PrestaShop\Module\PsEventbus\Repository\NewRepository\CartProductRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

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
