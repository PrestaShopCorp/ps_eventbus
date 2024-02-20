import {MockProbe} from './helpers/mock-probe';
import testConfig from './helpers/test.config';
import * as matchers from 'jest-extended';
import axios, {AxiosError} from "axios";
import R from "ramda";
import {logAxiosError} from "./helpers/log-helper";

expect.extend(matchers);

// FIXME : jest worker trips on something and runs tests several times

describe('Full Sync', () => {
  let testIndex = 0;
  let probe = new MockProbe();

  const controllers = testConfig.controllers.filter(it => !['apiHealthCheck'].includes(it))

  let jobId: string;

  beforeEach(() => {
    jobId = `valid-job-full-${testIndex++}`
  });

  describe.each(controllers)('%s', (controller) => {
    it(`${controller} should accept full sync`, async () => {
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&full=1&job_id=${jobId}`;

      // act
      await axios.post(url, {
        headers: {
          'Host': testConfig.prestaShopHostHeader
        },
      }).then(response => {
        // assert
        expect(response.status).toBeOneOf([200, 201])
        expect(response.headers).toMatchObject({'content-type': /json/})
      }).catch(err => {
        logAxiosError(err);
        expect(err).toBeNull();
      });
    });

    it(`${controller} should upload to collector`, async () => {
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&full=1&job_id=${jobId}`;
      const messages = probe.waitForMessages(1, {url: `/upload/${jobId}`});

      // act
      await axios.post(url, {
        headers: {
          'Host': testConfig.prestaShopHostHeader
        },
      }).catch(err => {
        logAxiosError(err);
        expect(err).toBeNull();
      })
      const collectorRequest = await messages;

      // assert
      expect(collectorRequest[0].method).toBe('POST');
    });
  })
})

