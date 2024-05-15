import axios from 'axios';
import * as matchers from 'jest-extended';
import { Category, WSClient } from 'prestashop-ws-client';
import { concatMap, from, lastValueFrom, map, toArray, zip } from 'rxjs';
import { categoryMultilanguage, getWSKey, getWSUrl } from './data/ws';
import {
  Controller,
  contentControllerMapping,
  controllerList,
} from './helpers/controllers';
import {
  loadFixture,
  omitProperties,
  sortUploadData,
} from './helpers/data-helper';
import { dumpUploadData, logAxiosError } from './helpers/log-helper';
import { PsEventbusSyncUpload, doFullSync, probe } from './helpers/mock-probe';
import testConfig from './helpers/test.config';

expect.extend(matchers);

// these fields change from test run to test run, so we replace them with a matcher to only ensure the type and format are correct
const isDateString = (val) =>
  val ? expect(val).toBeDateString() : expect(val).toBeNull();
const isString = (val) =>
  val ? expect(val).toBeString() : expect(val).toBeNull();
const isNumber = (val) =>
  val ? expect(val).toBeNumber() : expect(val).toBeNull();
const specialFieldAssert: { [index: string]: (val) => void } = {
  created_at: isDateString,
  updated_at: isDateString,
  last_connection_date: isDateString,
  folder_created_at: isDateString,
  date_add: isDateString,
  from: isDateString,
  to: isDateString,
  conversion_rate: isNumber,
  cms_version: isString,
  module_id: isString,
  module_version: isString,
  theme_version: isString,
  php_version: isString,
  http_server: isString,
};

describe('Full Sync', () => {
  const testIndex = 0;

  let wsClient: WSClient = null;
  let categoryId: number = -1;

  const controllers: Controller[] = controllerList;
  const controller: string = contentControllerMapping.categories;
  const jobId: string = `valid-job-full-${controller}`;

  beforeAll(async () => {
    wsClient = new WSClient(getWSUrl(), getWSKey());
    const category: Category = await wsClient.categories.create(
      categoryMultilanguage,
    );

    categoryId = category.id;
  });

  afterAll(async () => {
    await wsClient.categories.delete(categoryId.toString());
  });

  describe('Categories', () => {
    it(`${controller} should accept full sync`, async () => {
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&full=1&job_id=${jobId}`;

      // act
      const response = await axios
        .post(url, {
          headers: {
            Host: testConfig.prestaShopHostHeader,
          },
        })
        .catch((err) => {
          logAxiosError(err);
          expect(err).toBeNull();
          throw err;
        });

      // assert
      expect(response.status).toBeOneOf([200, 201]);
      expect(response.headers).toMatchObject({ 'content-type': /json/ });
      expect(response.data).toMatchObject({
        job_id: jobId,
        syncType: 'full',
      });
    });

    it(`${controller} should upload to collector`, async () => {
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&full=1&job_id=${jobId}`;
      const message$ = probe({ url: `/upload/${jobId}` });

      // act
      const request$ = from(
        axios.post(url, {
          headers: {
            Host: testConfig.prestaShopHostHeader,
          },
        }),
      );

      const results = await lastValueFrom(
        zip(message$, request$).pipe(
          map((result) => ({
            probeMessage: result[0],
            psEventbusReq: result[1],
          })),
          toArray(),
        ),
      );

      // assert
      expect(results.length).toEqual(1);
      expect(results[0].probeMessage.method).toBe('POST');
      expect(results[0].probeMessage.headers).toMatchObject({
        'full-sync-requested': '1',
      });
    });

    it(`${controller} should upload complete dataset collector`, async () => {
      // arrange
      const fullSync$ = doFullSync(jobId, controller, { timeout: 4000 });
      const message$ = probe({ url: `/upload/${jobId}` }, { timeout: 4000 });
      const fixture = await loadFixture(controller);

      // act
      const syncedData: PsEventbusSyncUpload[] = await lastValueFrom(
        zip(fullSync$, message$).pipe(
          map((msg) => msg[1].body.file),
          concatMap((syncedPage) => {
            return from(syncedPage);
          }),
          toArray(),
        ),
      );

      // dump data for easier debugging or updating fixtures
      if (testConfig.dumpFullSyncData) {
        await dumpUploadData(syncedData, controller);
      }

      // we need to process fixtures and data returned from ps_eventbus to make them easier to compare
      let processedData = syncedData;
      let processedFixture = fixture;
      processedData = omitProperties(
        processedData,
        Object.keys(specialFieldAssert),
      );
      processedData = sortUploadData(processedData);
      processedFixture = omitProperties(
        processedFixture,
        Object.keys(specialFieldAssert),
      );
      processedFixture = sortUploadData(processedFixture);

      // assert
      expect(processedData).toMatchObject(processedFixture);

      // assert special field using custom matcher
      for (const data of syncedData) {
        for (const specialFieldName of Object.keys(specialFieldAssert)) {
          if (data.properties[specialFieldName] !== undefined) {
            specialFieldAssert[specialFieldName](
              data.properties[specialFieldName],
            );
          }
        }
      }
    });
  });
});
