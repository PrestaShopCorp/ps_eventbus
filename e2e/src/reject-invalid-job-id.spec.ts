import {MockProbe} from './helpers/mock-probe';
import testConfig from './helpers/test.config';
import request from 'supertest';
import {beforeEach, describe, expect} from "@jest/globals";
import axios, {AxiosError} from "axios";

describe('Reject invalid job-id', () => {
  let testIndex = 0;
  let probe = new MockProbe();

  const controllers = testConfig.controllers.filter(it => !['apiHealthCheck'].includes(it))

  let jobId: string;

  beforeEach(() => {
    jobId = `invalid-job-id-${testIndex++}`
  });

  describe.each(controllers)('%s', (controller) => {

    it(`${controller} should return 454 with an invalid job id (sync-api status 454)`, async () => {
        expect.assertions(4);

        const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&job_id=${jobId}`

        const messages = probe.waitForMessages(1, {params: {id: jobId}});

        await axios.get(url, {
          headers: {'Host': testConfig.prestaShopHostHeader}
        }).catch(err => {
          expect(err.response.status).toEqual(454);
          expect(err.response.headers).toMatchObject({'content-type': /json/});
        })

        const syncApiRequest = await messages;

        expect(syncApiRequest[0].method).toBe('GET');
        expect(syncApiRequest[0].url.split('/')).toContain(jobId);
      }
    );
  })
})
