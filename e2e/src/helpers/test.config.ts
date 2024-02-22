export default {
  // client test configuration
  prestashopUrl:
    process.env.RUN_IN_DOCKER === '1'
      ? 'http://prestashop'
      : 'http://localhost:8000',
  prestaShopHostHeader: 'localhost:8000',

  mockBaseUrl:
    process.env.RUN_IN_DOCKER === '1'
      ? 'http://reverse-proxy'
      : 'http://localhost:3030',

  mockProbePath: '/mock-probe',
  mockSyncApiPath: '/sync/v1',
  mockCollectorPath: '/collector/v1',
  mockLiveSyncApiPath: '/live-sync-api/v1',

  // list of every controller of ps_eventbus
  controllers: [
    "apiCarriers",
    "apiCartRules",
    "apiCarts",
    "apiCategories",
    "apiCurrencies",
    "apiCustomers",
    "apiCustomProductCarriers",
    "apiDeletedObjects",
    "apiEmployees",
    "apiGoogleTaxonomies",
    "apiHealthCheck",
    "apiImages",
    "apiImageTypes",
    "apiInfo",
    "apiLanguages",
    "apiManufacturers",
    "apiModules",
    "apiOrders",
    "apiProducts",
    "apiSpecificPrices",
    "apiStocks",
    "apiStores",
    "apiSuppliers",
    "apiThemes",
    "apiTranslations",
    "apiWishlists",
  ] as const
};
