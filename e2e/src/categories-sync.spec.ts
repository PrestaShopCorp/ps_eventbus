import axios from 'axios';
import * as matchers from 'jest-extended';
import { Category, WSClient } from 'prestashop-ws-client';
import { concatMap, from, lastValueFrom, map, toArray, zip } from 'rxjs';
import { category_new } from './data/ws/categories';
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
import { PostgresClient } from './helpers/postgres';
import { postgresTablesMapping } from './helpers/postgres-tables';
import testConfig from './helpers/test.config';

expect.extend(matchers);

describe('Categories', () => {
  const testIndex = 0;

  let wsClient: WSClient = null;
  let categoryId: number = -1;
  let postgresClient: PostgresClient;

  const controller: string = contentControllerMapping.categories;
  const jobId: string = `valid-job-full-${controller}`;

  beforeAll(async () => {
    if (!postgresClient.isConnected) {
      await postgresClient.connect();
    }
    await postgresClient.query(
      `TRUNCATE TABLE  ${postgresTablesMapping.categories};`,
    );

    wsClient = new WSClient(testConfig.prestashopUrl, testConfig.wsKey);
    const category: Category = await wsClient.categories.create(category_new);

    categoryId = category.id;
  });

  describe('Full Sync', () => {
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
      const ctrler: Controller = controllerList[controller];
      // arrange
      const fullSync$ = doFullSync(jobId, ctrler, {
        timeout: 4000,
      });
      const message$ = probe({ url: `/upload/${jobId}` }, { timeout: 4000 });
      const fixture = await loadFixture(ctrler);

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

  describe('Incremental Sync', () => {
    it(`${controller} update category`, async () => {
      //TODO
      await wsClient.categories.update(category_new);
    });

    it(`${controller} update category`, async () => {
      //TODO
      await wsClient.categories.delete(categoryId.toString());
    });
  });
});
