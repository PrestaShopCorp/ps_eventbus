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
use PrestaShop\Module\PsEventbus\Repository\WishlistRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

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
     * @param bool $explainSql
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $explainSql)
    {
        $result = $this->wishlistRepository->retrieveContentsForFull($offset, $limit, $langIso, $explainSql);

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
     * @param bool $explainSql
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $explainSql)
    {
        $result = $this->wishlistRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $explainSql);

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
