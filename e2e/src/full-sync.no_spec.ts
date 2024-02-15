import { MockProbe } from './helpers/mock-probe';
import testConfig from './helpers/test.config';
import request from 'supertest';
import {afterEach, beforeEach, describe} from "@jest/globals";

describe('Full Sync', () => {
  const jobId = `valid-job-${Date.now()}`;

  beforeEach(() => {
    MockProbe.connect();
  });

  it.each(testConfig.controllers)('%s should accept full sync', async (controller) => {
    const probe = MockProbe.waitForMessages(1);
    const url = `/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&full=1&job_id=${jobId}`;

    await request(testConfig.prestashopUrl)
      .post(url)
      .set('Host', testConfig.prestaShopHostHeader)
      .redirects(1)
      .expect('content-type', /json/)
      .expect(201);

    const syncApiRequest = await probe;

    expect(syncApiRequest[0].method).toBe('GET');
    expect(syncApiRequest[0].url.split( '/' )).toContain(jobId);
  });

  afterEach(() => {
    MockProbe.disconnect();
  });
});
