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

  it('should return 454 with an invalid job id (sync-api status 454)', async () => {
    const mockProbe = wsClient.registerMockProbe();
    const jobId = `invalid-job-${Date.now()}`;

    await request(testConfig.prestashopUrl)
      .get(`${endpoint}&job_id=${jobId}`)
      .set('Host', testConfig.prestaShopHostHeader)
      .redirects(1)
      .expect('content-type', /json/)
      .expect(454);

    const syncApiRequest = await mockProbe;
    
    expect(syncApiRequest.method).toBe('GET');
    expect(syncApiRequest.url.split( '/' )).toContain(jobId);
  });

  it('should synchronize (sync-api and proxy-api status 200)', async () => {
    const mockProbe = wsClient.registerMockProbe();
    const jobId = `valid-job-${Date.now()}`;
  
    const response = await request(testConfig.prestashopUrl)
      .get(`${endpoint}&job_id=${jobId}`)
      .set('Host', testConfig.prestaShopHostHeader)
      .redirects(1)
      .expect('content-type', /json/)
      .expect(200);

    const syncApiRequest = await mockProbe;
    console.log(syncApiRequest, response.body);
  });

  afterAll(() => {
    wsClient.close();
  });
});
