<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

class WishlistDecorator
{
    /**
     * @param array $wishlists
     *
     * @return void
     */
    public function decorateWishlists(array &$wishlists)
    {
        foreach ($wishlists as &$wishlist) {
            $this->castWishlistPropertyValues($wishlist);
        }
    }

    /**
     * @param array $wishlistProducts
     *
     * @return void
     */
    public function decorateWishlistProducts(array &$wishlistProducts)
    {
        foreach ($wishlistProducts as &$wishlistProduct) {
            $this->castWishlistProductPropertyValues($wishlistProduct);
        }
    }

    /**
     * @param array $wishlist
     *
     * @return void
     */
    private function castWishlistPropertyValues(array &$wishlist)
    {
        $wishlist['id_wishlist'] = (int) $wishlist['id_wishlist'];
        $wishlist['id_customer'] = (int) $wishlist['id_customer'];
        $wishlist['id_shop'] = (int) $wishlist['id_shop'];
        $wishlist['id_shop_group'] = (int) $wishlist['id_shop_group'];
        $wishlist['counter'] = (int) $wishlist['counter'];
        $wishlist['default'] = (bool) $wishlist['default'];
    }

    /**
     * @param array $wishlistProduct
     *
     * @return void
     */
    private function castWishlistProductPropertyValues(array &$wishlistProduct)
    {
        $wishlistProduct['id_wishlist_product'] = (int) $wishlistProduct['id_wishlist_product'];
        $wishlistProduct['id_wishlist'] = (int) $wishlistProduct['id_wishlist'];
        $wishlistProduct['id_product'] = (int) $wishlistProduct['id_product'];
        $wishlistProduct['id_product_attribute'] = (int) $wishlistProduct['id_product_attribute'];
        $wishlistProduct['quantity'] = (int) $wishlistProduct['quantity'];
        $wishlistProduct['priority'] = (int) $wishlistProduct['priority'];
    }
}
