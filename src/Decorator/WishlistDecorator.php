<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

class WishlistDecorator
{
    /**
     * @param array<mixed> $wishlists
     *
     * @return void
     */
    public function decorateWishlists(&$wishlists)
    {
        foreach ($wishlists as &$wishlist) {
            $this->castWishlistPropertyValues($wishlist);
        }
    }

    /**
     * @param array<mixed> $wishlistProducts
     *
     * @return void
     */
    public function decorateWishlistProducts(&$wishlistProducts)
    {
        foreach ($wishlistProducts as &$wishlistProduct) {
            $this->castWishlistProductPropertyValues($wishlistProduct);
        }
    }

    /**
     * @param array<mixed> $wishlist
     *
     * @return void
     */
    private function castWishlistPropertyValues(&$wishlist)
    {
        $wishlist['id_wishlist'] = (int) $wishlist['id_wishlist'];
        $wishlist['id_customer'] = (int) $wishlist['id_customer'];
        $wishlist['id_shop'] = (int) $wishlist['id_shop'];
        $wishlist['id_shop_group'] = (int) $wishlist['id_shop_group'];
        $wishlist['counter'] = (int) $wishlist['counter'];
        $wishlist['default'] = (bool) $wishlist['default'];
    }

    /**
     * @param array<mixed> $wishlistProduct
     *
     * @return void
     */
    private function castWishlistProductPropertyValues(&$wishlistProduct)
    {
        $wishlistProduct['id_wishlist_product'] = (int) $wishlistProduct['id_wishlist_product'];
        $wishlistProduct['id_wishlist'] = (int) $wishlistProduct['id_wishlist'];
        $wishlistProduct['id_product'] = (int) $wishlistProduct['id_product'];
        $wishlistProduct['id_product_attribute'] = (int) $wishlistProduct['id_product_attribute'];
        $wishlistProduct['quantity'] = (int) $wishlistProduct['quantity'];
        $wishlistProduct['priority'] = (int) $wishlistProduct['priority'];
    }
}
