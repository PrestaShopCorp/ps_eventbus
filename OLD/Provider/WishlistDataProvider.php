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

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\WishlistDecorator;
use PrestaShop\Module\PsEventbus\Formatter\ArrayFormatter;
use PrestaShop\Module\PsEventbus\Repository\WishlistProductRepository;
use PrestaShop\Module\PsEventbus\Repository\WishlistRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class WishlistDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var WishlistRepository
     */
    private $wishlistRepository;
    /**
     * @var WishlistProductRepository
     */
    private $wishlistProductRepository;
    /**
     * @var WishlistDecorator
     */
    private $wishlistDecorator;
    /**
     * @var ArrayFormatter
     */
    private $arrayFormatter;

    public function __construct(
        WishlistRepository $wishlistRepository,
        WishlistProductRepository $wishlistProductRepository,
        WishlistDecorator $wishlistDecorator,
        ArrayFormatter $arrayFormatter
    ) {
        $this->wishlistRepository = $wishlistRepository;
        $this->wishlistProductRepository = $wishlistProductRepository;
        $this->wishlistDecorator = $wishlistDecorator;
        $this->arrayFormatter = $arrayFormatter;
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
    public function getFormattedData($offset, $limit, $langIso)
    {
        $wishlists = $this->wishlistRepository->getWishlists($offset, $limit);

        if (empty($wishlists)) {
            return [];
        }

        $wishlistProducts = $this->getWishlistProducts($wishlists);

        $this->wishlistDecorator->decorateWishlists($wishlists);

        $wishlists = array_map(function ($wishlist) {
            return [
                'id' => $wishlist['id_wishlist'],
                'collection' => Config::COLLECTION_WISHLISTS,
                'properties' => $wishlist,
            ];
        }, $wishlists);

        return array_merge($wishlists, $wishlistProducts);
    }

    /**
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        $wishlists = $this->wishlistRepository->getWishlistsIncremental($limit, $objectIds);

        if (!is_array($wishlists) || empty($wishlists)) {
            return [];
        }

        $wishlistProducts = $this->getWishlistProducts($wishlists);

        $this->wishlistDecorator->decorateWishlists($wishlists);

        $wishlists = array_map(function ($wishlist) {
            return [
                'id' => $wishlist['id_wishlist'],
                'collection' => Config::COLLECTION_WISHLISTS,
                'properties' => $wishlist,
            ];
        }, $wishlists);

        return array_merge($wishlists, $wishlistProducts);
    }

    /**
     * @param array<mixed> $wishlists
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    private function getWishlistProducts(&$wishlists)
    {
        if (empty($wishlists)) {
            return [];
        }

        $wishlistIds = $this->arrayFormatter->formatValueArray($wishlists, 'id_wishlist');

        $wishlistProducts = $this->wishlistProductRepository->getWishlistProducts($wishlistIds);

        if (!is_array($wishlistProducts) || empty($wishlistProducts)) {
            return [];
        }

        $this->wishlistDecorator->decorateWishlistProducts($wishlistProducts);

        $wishlistProducts = array_map(function ($wishlistProduct) {
            return [
                'id' => $wishlistProduct['id_wishlist_product'],
                'collection' => Config::COLLECTION_WISHLIST_PRODUCTS,
                'properties' => $wishlistProduct,
            ];
        }, $wishlistProducts);

        return $wishlistProducts;
    }
}
