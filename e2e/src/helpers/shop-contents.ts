import R from "ramda";

export const shopContentMapping = {
  'carriers': 'carriers',
  'carrier_details': 'carrier-details',
  'carts' : 'carts',
  'cart_products': 'carts',
  'cart_rules' : 'cart-rules',
  'categories' : 'categories',
  'currencies' : 'currencies',
  'specific_prices': 'specific-prices',
  'custom_product_carriers' : 'custom-product-carriers',
  'customers': 'customers',
  'taxonomies': 'google-taxonomies',
  'modules': 'modules',
  'orders': 'orders',
  'order_details': 'order-details',
  'order_status_histories': 'order-status-histories',
  'order_cart_rules': 'order-cart-rules',
  'products': 'products',
  'shops': 'info',
  'stores': 'stores',
  'themes': 'themes',
  'product_bundles': 'product-bundles',
  'wishlists': 'wishlists',
  'wishlist_products': 'wishlist-products',
  'stocks': 'stocks',
  'stock_movements': 'stock-movements',
  'manufacturers': 'manufacturers',
  'suppliers': 'suppliers',
  'product_suppliers': 'product-suppliers',
  'languages': 'languages',
  'employees': 'employees',
  'translations': 'translations',
  'images': 'images',
  'image_types': 'image-types'
} as const;

type ShopContentMapping = typeof shopContentMapping;

export type Content = keyof ShopContentMapping;
export const contentList  = Object.keys(shopContentMapping) as Content[];

export type ShopContent = ShopContentMapping[Content];
export const shopContentList = R.uniq(Object.values(shopContentMapping)) as ShopContent[];


