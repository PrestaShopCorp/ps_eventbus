import R from "ramda";

// TEMPORARY DISABLED, WAIT ADD ALL SHOP CONTENT
// AFTER UNCOMMENT THIS, CHANGE ALL "as ShopContent"CAST IN FULLSYNC TEST
/* export const shopContentMapping = {
  'specific_prices': 'specific-prices',
  'taxonomies': 'taxonomies',
  'stores': 'stores',
  'themes': 'themes',
  'wishlists': 'wishlists',
  'wishlist_products': 'wishlist-products',
  'stocks': 'stocks',
  'stock_movements': 'stock-movements',
  'manufacturers': 'manufacturers',
  'suppliers': 'suppliers',
  'languages': 'languages',
  'translations': 'translations',
} as const; */

export const shopContentMapping = {
  carriers: "carriers",
  carrier_details: "carrier-details",
  carrier_taxes: "carrier-taxes",
  carts: "carts",
  cart_products: "cart-products",
  cart_rules: "cart-rules",
  orders: "orders",
  order_cart_rules: "order-cart-rules",
  order_details: "order-details",
  order_histories: "order-histories",
  products: "products",
  product_bundles: "product-bundles",
  product_suppliers: "product-suppliers",
  product_carriers: "product-carriers",
  categories: "categories",
  customers: "customers",
  currencies: "currencies",
  employees: "employees",
  images: "images",
  image_types: "image-types",
  shop_information: "shop-information",
  modules: "modules",
} as const;

type ShopContentMapping = typeof shopContentMapping;

export type Content = keyof ShopContentMapping;
export const contentList = Object.keys(shopContentMapping) as Content[];

export type ShopContent = ShopContentMapping[Content];
export const shopContentList = R.uniq(
  Object.values(shopContentMapping),
) as ShopContent[];
