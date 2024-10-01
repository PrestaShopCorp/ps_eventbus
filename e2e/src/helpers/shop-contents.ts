import R from "ramda";

export const shopContentMapping = {
  carriers: "carriers",
  carrier_details: "carrier-details",
  carrier_taxes: "carrier-taxes",
  carts: "carts",
  cart_products: "cart-products",
  cart_rules: "cart-rules",
  categories: "categories",
  currencies: "currencies",
  customers: "customers",
  employees: "employees",
  images: "images",
  image_types: "image-types",
  languages: "languages",
  manufacturers: "manufacturers",
  modules: "modules",
  orders: "orders",
  order_cart_rules: "order-cart-rules",
  order_details: "order-details",
  order_histories: "order-histories",
  products: "products",
  product_bundles: "product-bundles",
  product_carriers: "product-carriers",
  product_suppliers: "product-suppliers",
  shop_details: "shop-details",
  specific_prices: "specific-prices",
  stocks: "stocks",
  stock_mvts: "stock-mvts",
  stores: "stores",
  suppliers: "suppliers",
  taxonomies: "taxonomies",
  themes: "themes",
  translations: "translations",
  wishlists: "wishlists",
  wishlist_products: "wishlist-products",
} as const;

type ShopContentMapping = typeof shopContentMapping;

export type Content = keyof ShopContentMapping;
export const contentList = Object.keys(shopContentMapping) as Content[];

export type ShopContent = ShopContentMapping[Content];
export const shopContentList = R.uniq(
  Object.values(shopContentMapping),
) as ShopContent[];
