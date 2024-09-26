<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\WishlistRepository;

class WishlistsService implements ShopContentServiceInterface
{
    /** @var WishlistRepository */
    private $wishlistRepository;

    public function __construct(WishlistRepository $wishlistRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
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
        $result = $this->wishlistRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castWishlists($result, $langIso);

        return array_map(function ($item) {
            return [
                'id' => $item['id_wishlist'],
                'collection' => Config::COLLECTION_WISHLISTS,
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
        $result = $this->wishlistRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castWishlists($result, $langIso);

        return array_map(function ($item) {
            return [
                'id' => $item['id_wishlist'],
                'collection' => Config::COLLECTION_WISHLISTS,
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
        return $this->wishlistRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $wishlists
     * @param string $langIso
     *
     * @return void
     */
    private function castWishlists(&$wishlists, $langIso)
    {
        foreach ($wishlists as &$wishlist) {
            $wishlist['id_wishlist'] = (int) $wishlist['id_wishlist'];
            $wishlist['id_customer'] = (int) $wishlist['id_customer'];
            $wishlist['id_shop'] = (int) $wishlist['id_shop'];
            $wishlist['id_shop_group'] = (int) $wishlist['id_shop_group'];
            $wishlist['counter'] = (int) $wishlist['counter'];
            $wishlist['default'] = (bool) $wishlist['default'];
        }
    }
}
