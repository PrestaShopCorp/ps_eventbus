<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\WishlistDecorator;
use PrestaShop\Module\PsEventbus\Formatter\ArrayFormatter;
use PrestaShop\Module\PsEventbus\Repository\WishlistProductRepository;
use PrestaShop\Module\PsEventbus\Repository\WishlistRepository;

class WishlistDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var \Context
     */
    private $context;
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
        \Context $context,
        WishlistRepository $wishlistRepository,
        WishlistProductRepository $wishlistProductRepository,
        WishlistDecorator $wishlistDecorator,
        ArrayFormatter $arrayFormatter
    ) {
        $this->context = $context;
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
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $wishlists = $this->wishlistRepository->getWishlists($offset, $limit, $langIso);

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
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;

        return (int) $this->wishlistRepository->getRemainingWishlistsCount($offset, $langIso);
    }

    /**
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $langId = (int) \Language::getIdByIso($langIso);
        $wishlists = $this->wishlistRepository->getWishlistsIncremental($limit, $langIso, $objectIds);

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
     * @param array $wishlists
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    private function getWishlistProducts(array &$wishlists)
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
