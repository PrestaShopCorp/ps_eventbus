import { WsClient } from './helpers/ws-client';
import testConfig from './helpers/test.config';
import request from 'supertest';

const controller = 'apiCategories';
const endpoint = `/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5`;

describe('CategoriesController', () => {
  let wsClient: WsClient;

  beforeAll(() => {
    wsClient = new WsClient();
  });

  it('should be defined', () => {
    expect(testConfig.prestashopUrl).toBeDefined();
  });

  it('should return 500 with an invalid job id (sync-api status 500)', async () => {
    const mockProbe = wsClient.registerMockProbe();
    const jobId = `invalid-job-${Date.now()}`;

    await request(testConfig.prestashopUrl)
      .get(`${endpoint}&job_id=${jobId}`)
      .set('Host', testConfig.prestaShopHostHeader)
      .redirects(1)
      .expect('content-type', /json/)
      .expect(454);

    const moduleRequest = await mockProbe;

    expect(moduleRequest.headers.authorization).toBeDefined();

    expect(moduleRequest.url.split( '/' )).toContain(jobId);
    expect(moduleRequest.method).toBe('GET');

    console.log('moduleRequest', moduleRequest);
  });

  afterAll(() => {
    wsClient.close();
  });
});