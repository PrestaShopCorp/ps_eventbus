import R from "ramda";

export const contentControllerMapping = {
  carriers: "apiCarriers",
  carrier_details: "apiCarriers",
  carts: "apiCarts",
  cart_products: "apiCarts",
  cart_rules: "apiCartRules",
  categories: "apiCategories",
  currencies: "apiCurrencies",
  specific_prices: "apiSpecificPrices",
  custom_product_carriers: "apiCustomProductCarriers",
  customers: "apiCustomers",
  taxonomies: "apiGoogleTaxonomies",
  modules: "apiModules",
  orders: "apiOrders",
  order_details: "apiOrders",
  order_status_history: "apiOrders",
  order_cart_rules: "apiOrders",
  products: "apiProducts",
  shops: "apiInfo",
  stores: "apiStores",
  themes: "apiThemes",
  bundles: "apiProducts",
  wishlists: "apiWishlists",
  wishlist_products: "apiWishlists",
  stocks: "apiStocks",
  stock_movements: "apiStocks",
  manufacturers: "apiManufacturers",
  suppliers: "apiSuppliers",
  product_suppliers: "apiProducts",
  languages: "apiLanguages",
  employees: "apiEmployees",
  translations: "apiTranslations",
  images: "apiImages",
  image_types: "apiImageTypes",
} as const;

type ContentControllerMapping = typeof contentControllerMapping;

export type Content = keyof ContentControllerMapping;
export const contentList = Object.keys(contentControllerMapping) as Content[];

export type Controller = ContentControllerMapping[Content];
export const controllerList = R.uniq(
  Object.values(contentControllerMapping)
) as Controller[];
