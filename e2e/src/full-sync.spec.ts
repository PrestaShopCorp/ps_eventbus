import { MockProbe } from './helpers/mock-probe';
import testConfig from './helpers/test.config';
import request from 'supertest';
import {afterEach, beforeAll, beforeEach, describe} from "@jest/globals";

describe('Full Sync', () => {
  let testIndex = 0;
  let jobId: string;
  let probe: MockProbe;

  beforeAll(() => {
    probe = new MockProbe();
  })

  beforeEach(() => {
    jobId = `valid-job-${testIndex++}`
  });

  it('should be defined', () => {
    expect(testConfig.prestashopUrl).toBeDefined();
  });

  it.each(['apiCarriers'])('%s should accept full sync', async (controller) => {
    const url = `/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&full=1&job_id=${jobId}`;
    const messages = probe.waitForMessages(1);

    const stuff = await request(testConfig.prestashopUrl)
      .get(url)
      .set('Host', testConfig.prestaShopHostHeader)
      .redirects(1)
      .expect('content-type', /json/)
      .expect(201);

    const syncApiRequest = await messages;

    expect(syncApiRequest[0].method).toBe('POST');
    expect(syncApiRequest[0].url.split('/')).toContain(jobId);
  });
});
