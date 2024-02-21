import {MockProbe} from './helpers/mock-probe';
import testConfig from './helpers/test.config';
import * as matchers from 'jest-extended';
import {logAxiosError} from "./helpers/log-helper";
import axios, {AxiosError} from "axios";

expect.extend(matchers);

// these controllers will be excluded from the following test suite
const EXCLUDED_API: typeof testConfig.controllers[number][] = ['apiHealthCheck', 'apiGoogleTaxonomies'];

// FIXME : these api can't send anything to the mock api because the database is empty from the factory
const MISSING_TEST_DATA: typeof testConfig.controllers[number][] = ['apiCartRules', 'apiCustomProductCarriers', 'apiDeletedObjects', 'apiTranslations', 'apiWishlists'];

describe('Full Sync', () => {
  let testIndex = 0;
  let probe = new MockProbe();

  const controllers = testConfig.controllers.filter(it => !EXCLUDED_API.includes(it))

  let jobId: string;

  beforeEach(() => {
    jobId = `valid-job-full-${testIndex++}`
  });

  describe('apiGoogleTaxonomies', () => {
    const controller = 'apiGoogleTaxonomies'

    // TODO : apiGoogleTaxonomies requires an additional module to be present : devise a specific test setup for this endpoint
    it.skip(`${controller} should accept full sync`, async () => {
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
        expect(response.data).toMatchObject({
          'job_id': jobId,
          'syncType': 'full'
        })
      }).catch(err => {
        logAxiosError(err);
        expect(err).toBeNull();
      });
    });

    it.skip(`${controller} should upload to collector`, async () => {
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

    it(`${controller} should reject full sync when ps_facebook is not installed`, async () => {
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&full=1&job_id=${jobId}`;

      // act
      await axios.post(url, {
        headers: {
          'Host': testConfig.prestaShopHostHeader
        },
      }).then(response => {
        expect(response).toBeNull();
      }).catch(err => {
        // assert
        expect(err).toBeInstanceOf(AxiosError);
        if (err instanceof AxiosError) {
          expect(err.response.status).toEqual(456);
          // expect some explanation to be given to the user
          expect(err.response.statusText).toMatch(/[Ff]acebook/)
        }
      });
    })
  })

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
        expect(response.data).toMatchObject({
          'job_id': jobId,
          'syncType': 'full'
        })
      }).catch(err => {
        logAxiosError(err);
        expect(err).toBeNull();
      });
    });

    if (MISSING_TEST_DATA.includes(controller)) {
      it.skip(`${controller} should upload to collector`, () => {
      })
    } else {
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
        expect(collectorRequest[0].headers).toMatchObject({"full-sync-requested": "1"});
      });
    }
  })
})

