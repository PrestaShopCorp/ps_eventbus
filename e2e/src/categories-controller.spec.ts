import { MockProbe } from './helpers/mock-probe';
import testConfig from './helpers/test.config';
import request from 'supertest';
import {beforeEach} from "@jest/globals";

const controller = 'apiCategories';
const endpoint = `/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5`;

describe('CategoriesController', () => {
  let testIndex = 0;
  let jobId : string;
  let probe;

  beforeEach(() => {
    probe = new MockProbe();
    jobId = `valid-job-${testIndex++}`
  });

  it('should be defined', () => {
    expect(testConfig.prestashopUrl).toBeDefined();
  });

  it('should return 454 with an invalid job id (sync-api status 454)', async () => {
    probe.connect(jobId);

    const messages = probe.waitForMessages(1);

    await request(testConfig.prestashopUrl)
      .get(`${endpoint}&job_id=${jobId}`)
      .set('Host', testConfig.prestaShopHostHeader)
      .redirects(1)
      .expect('content-type', /json/)
      .expect(454);

    const syncApiRequest = await messages;

    expect(syncApiRequest[0].method).toBe('GET');
    expect(syncApiRequest[0].url.split( '/' )).toContain(jobId);
  });
});
