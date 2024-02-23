import {MockProbe} from './helpers/mock-probe';
import testConfig from './helpers/test.config';
import {beforeEach, describe, expect} from "@jest/globals";
import axios, {AxiosError} from "axios";

// these controllers will be excluded from the following test suite
const EXCLUDED_API : typeof testConfig.controllers[number][] = ['apiHealthCheck'];


describe('Reject invalid job-id', () => {
  let testIndex = 0;
  let probe = new MockProbe({timeout: 3000});

  const controllers = testConfig.controllers.filter(it => !EXCLUDED_API.includes(it))

  let jobId: string;

  beforeEach(() => {
    jobId = `invalid-job-id-${testIndex++}`
  });

  describe.each(controllers)('%s', (controller) => {

    it(`${controller} should return 454 with an invalid job id (sync-api status 454)`, async () => {
       expect.assertions(5);
        // arrange
        const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&job_id=${jobId}`
        const messages = probe.waitForMessages(1, {params: {id: jobId}});

        //act
        await axios.get(url, {
          headers: {'Host': testConfig.prestaShopHostHeader}
        }).then(res => {
          expect(res).toBeNull();
        }).catch(err => {
          // assert
          expect(err.response.status).toEqual(454);
          expect(err.response.headers).toMatchObject({'content-type': /json/});
          expect(err.response.data).toMatchObject({
            status: false,
            httpCode: 454,
          });
        })

        const syncApiRequest = await messages;

        // assert
        expect(syncApiRequest[0].method).toBe('GET');
        expect(syncApiRequest[0].url.split('/')).toContain(jobId);
      }
    );
  })
})
