import R from 'ramda';

export const shopContentMapping = {
    bundles: 'bundles',
    carriers: 'carriers',
    carrier_details: 'carrier-details',
    carrier_taxes: 'carrier-taxes',
    carts: 'carts',
    cart_products: 'cart-products',
    cart_rules: 'cart-rules',
    categories: 'categories',
    currencies: 'currencies',
    customers: 'customers',
    custom_product_carriers: 'custom-product-carriers',
    employees: 'employees',
    images: 'images',
    image_types: 'image-types',
    languages: 'languages',
    manufacturers: 'manufacturers',
    modules: 'modules',
    orders: 'orders',
    order_carriers: 'order-carriers',
    order_cart_rules: 'order-cart-rules',
    order_details: 'order-details',
    order_status_history: 'order-status-history',
    products: 'products',
    product_suppliers: 'product-suppliers',
    info: 'info',
    specific_prices: 'specific-prices',
    stocks: 'stocks',
    stock_movements: 'stock-movements',
    stores: 'stores',
    suppliers: 'suppliers',
    taxonomies: 'taxonomies',
    themes: 'themes',
    translations: 'translations',
    wishlists: 'wishlists',
    wishlist_products: 'wishlist-products',
} as const;

type ShopContentMapping = typeof shopContentMapping;

export type Content = keyof ShopContentMapping;
export const contentList = Object.keys(shopContentMapping) as Content[];

export type ShopContent = ShopContentMapping[Content];
export const shopContentList = R.uniq(Object.values(shopContentMapping)) as ShopContent[];
