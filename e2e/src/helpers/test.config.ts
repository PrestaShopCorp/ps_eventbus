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

  dumpFullSyncData: process.env.RUN_IN_DOCKER !== '1',

  testRunTime: new Date().toISOString(),

  // WebService key
  wsKey: 'GENERATE_A_COMPLEX_VALUE_WITH_32',

  postgres_params: {
    user: process.env.POSTGRES_USER,
    password: process.env.POSTGRES_PASSWORD,
    host: process.env.POSTGRES_HOST,
    port: process.env.POSTGRES_PORT,
    database: process.env.POSTGRES_DB,
    schema: 'eventbus',
  },
};
