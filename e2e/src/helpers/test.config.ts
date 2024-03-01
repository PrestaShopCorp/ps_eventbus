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

  dumpFullSyncData:
    process.env.RUN_IN_DOCKER !== '1',

  testRunTime: new Date().toISOString(),
};
