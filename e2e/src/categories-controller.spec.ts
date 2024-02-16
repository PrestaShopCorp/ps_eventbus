import {MockProbe} from './helpers/mock-probe';
import testConfig from './helpers/test.config';
import request from 'supertest';
import {beforeEach} from "@jest/globals";

const controller = 'apiCategories';
const endpoint = `/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5`;

describe('CategoriesController', () => {
  let probe: MockProbe;

  beforeEach(() => {
    probe = new MockProbe();
  });

  it('should be defined', () => {
    expect(testConfig.prestashopUrl).toBeDefined();
  });

  it('should return 454 with an invalid job id (sync-api status 454)', async () => {
    const jobId = 'invalid-job-id'

    const messages = probe.waitForMessages(1, {params: {id: jobId}});

    const stuff = await request(testConfig.prestashopUrl)
      .get(`/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&job_id=${jobId}`)
      .set('Host', testConfig.prestaShopHostHeader)
      .redirects(1)
      .expect('content-type', /json/)
      .expect(454);

    const syncApiRequest = await messages;

    expect(syncApiRequest[0].method).toBe('GET');
    expect(syncApiRequest[0].url.split('/')).toContain(jobId);
  });
});
