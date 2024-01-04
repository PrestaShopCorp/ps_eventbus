import { MockProbe } from './helpers/mock-probe';
import testConfig from './helpers/test.config';
import request from 'supertest';

const controller = 'apiCategories';
const endpoint = `/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5`;


describe('CategoriesController', () => {
  it('should be defined', () => {
    expect(testConfig.prestashopUrl).toBeDefined();
  });

  it('should return 454 with an invalid job id (sync-api status 454)', async () => {
    const mockProbe = new MockProbe();

    const probe = mockProbe.waitForMessages(1);
    const jobId = `invalid-job-${Date.now()}`;

    await request(testConfig.prestashopUrl)
      .get(`${endpoint}&job_id=${jobId}`)
      .set('Host', testConfig.prestaShopHostHeader)
      .redirects(1)
      .expect('content-type', /json/)
      .expect(454);

    const syncApiRequest = await probe;
    
    expect(syncApiRequest[0].method).toBe('GET');
    expect(syncApiRequest[0].url.split( '/' )).toContain(jobId);

    mockProbe.close();
  });
});
