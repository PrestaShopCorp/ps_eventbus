<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\WishlistDecorator;
use PrestaShop\Module\PsEventbus\Formatter\ArrayFormatter;
use PrestaShop\Module\PsEventbus\Repository\WishlistProductRepository;
use PrestaShop\Module\PsEventbus\Repository\WishlistRepository;

class OrderDataProvider implements PaginatedApiDataProviderInterface
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
        ArrayFormatter $arrayFormatter,
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
        $wishlists = $this->wishlistRepository->getWishlists($offset, $limit, $shopId);

        if (empty($wishlists)) {
            return [];
        }

        $wishlistProducts = $this->getWishlistProducts($wishlists, $shopId);

        $this->wishlistDecorator->decorateWishlists($wishlists);
        $this->wishlistDecorator->decorateWishlistProducts($wishlistProducts);

        $wishlists = array_map(function ($wishlists) {
            return [
                'id' => $wishlists['id_wishlist'],
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

        return (int) $this->wishlistRepository->getRemainingWishlistCount($offset, $shopId);
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
        $wishlists = $this->wishlistRepository->getWishlistsIncremental($limit, $shopId, $objectIds);

        if (!is_array($wishlists) || empty($wishlists)) {
            return [];
        }

        $wishlistProducts = $this->getWishlistProducts($wishlists, $shopId);

        $this->wishlistDecorator->decorateWishlists($wishlists);
        $this->wishlistDecorator->decorateWishlistProducts($wishlistProducts);

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
     * @param int $shopId
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    private function getWishlistProducts(array $wishlists, $shopId)
    {
        if (empty($wishlists)) {
            return [];
        }

        $wishlistIds = $this->arrayFormatter->formatValueArray($wishlists, 'id_wishlist');

        $wishlistProducts = $this->wishlistProductRepository->getWishlistProducts($wishlistIds, $shopId);

        if (!is_array($wishlistProducts) || empty($wishlistProducts)) {
            return [];
        }

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
