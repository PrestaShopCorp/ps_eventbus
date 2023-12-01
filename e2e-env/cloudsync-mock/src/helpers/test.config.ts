export default {
  // server mocks configuration
  syncApiPort: process.env.SYNC_API_PORT ?? '3232',
  collectorApiPort: process.env.COLLECTOR_API_PORT ?? '3333',
  liveSyncApiPort: process.env.COLLECTOR_API_PORT ?? '3434',

  // client test configuration
  prestashopUrl:
    process.env.RUN_IN_DOCKER === '1'
      ? 'http://prestashop'
      : 'http://localhost:8000',
  prestaShopHostHeader: 'localhost:8000',
};
