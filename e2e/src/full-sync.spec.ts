import {MockProbe} from './helpers/mock-probe';
import testConfig from './helpers/test.config';
import * as matchers from 'jest-extended';
import {describe} from "@jest/globals";
import axios from "axios";

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
      const response = await axios.post(url, {
        headers: {
          'Host': testConfig.prestaShopHostHeader
        },
      }).catch(err => {
        console.error(err)
        throw err;
      });

      // assert
      expect(response.status).toBeOneOf([200, 201])
      expect(response.headers).toMatchObject({'content-type': /json/})
    });

    it(`${controller} should upload to collector`, async () => {
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&full=1&job_id=${jobId}`;
      const messages = probe.waitForMessages(1, {url: `/upload/${jobId}`});

      // act
      const response = await axios.post(url, {
        headers: {
          'Host': testConfig.prestaShopHostHeader
        },
      }).catch(err => {
        console.error(err)
        throw err;
      })
      const collectorRequest = await messages;

      // assert
      expect(collectorRequest[0].method).toBe('POST');
    });
  })
})

