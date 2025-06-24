import {test as setup, test, expect} from '@playwright/test';
import {shopContentList} from "@helpers/shop-contents";
import {generateFakeJobId} from "@helpers/utils";
import testConfig from "@helpers/test.config";
import axios from "axios";
import {logAxiosError} from "@helpers/log-helper";
import {doFullSync, probe, PsEventbusSyncUpload} from "@helpers/mock-probe";
import {lastValueFrom, toArray, withLatestFrom} from "rxjs";
import {loadFixture, omitProperties, sortUploadData} from "@helpers/data-helper";
import {dumpUploadData} from "@helpers/log-helper";

// these fields change from test run to test run, so we replace them with a matcher to only ensure the type and format are correct
const isDateString = (val: any) => {
  if (val == null) return expect(val).toBeNull();
  expect(typeof val).toBe('string');
  expect(!isNaN(Date.parse(val))).toBeTruthy();
};
const isString = (val: any) => {
  if (val == null) return expect(val).toBeNull();
  expect(typeof val).toBe('string');
};
const isNumber = (val: any) => {
  if (val == null) return expect(val).toBeNull();
  expect(typeof val).toBe('number');
};
const isBoolean = (val: any) => {
  if (val == null) return expect(val).toBeNull();
  expect(typeof val).toBe('boolean');
};

const specialFieldAssert: { [index: string]: (val: unknown) => void } = {
  created_at: isDateString,
  updated_at: isDateString,
  delivery_date: isDateString,
  invoice_date: isDateString,
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
  cover: isString,
  link: isString,
  url: isString,
  images: isString,
  ssl: isBoolean,
};

setup('[FULL-SYNC] - @full-sync', async () => {
  let jobId: string;

  for (const shopContent of shopContentList) {
    jobId = generateFakeJobId();
    await test.step(`Should check ${shopContent.toUpperCase()} accept full-sync`, async () => {
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=apiShopContent&shop_content=${shopContent}&limit=5&full=1&job_id=${jobId}`;
      const callId = {call_id: Math.random().toString(36).substring(2, 11)};
      // act
      const response = await axios
        .post(url, callId, {
          headers: {
            Host: testConfig.prestaShopHostHeader,
            'Content-Type': 'application/x-www-form-urlencoded', // for compat PHP 5.6
          },
        })
        .catch((err) => {
          logAxiosError(err);
          expect(err).toBeNull();
          throw err;
        });

      // assert
      //expect(response.status).toBeOneOf([200, 201]);
      expect([200, 201].includes(response.status), `Response status should be either '200' or '201', but got ${response.status}`).toBeTruthy();
      //expect(response.headers).toMatchObject({'content-type': /json/});
      expect(response.headers['content-type']).toMatch(/json/);
      expect(response.data).toMatchObject({
        job_id: jobId,
        syncType: 'full',
      });
    });

    await test.step(`Should upload complete ${shopContent.toUpperCase()} dataset collector`, async () => {
      // arrange
      const response$ = doFullSync(jobId, shopContent, 5, { timeout: 5000 });
      const message$ = probe({ url: `/upload/${jobId}` }, { timeout: 4000 });

      // this combines each response from ps_eventbus to the last request captured by the probe.
      // it works because ps_eventbus sends a response after calling our mock collector server
      // if ps_eventbus doesn't need to call the collector, the probe completes without value after its timeout
      const messages = await lastValueFrom(
        response$.pipe(
          withLatestFrom(message$, (_, message) => message.body.file),
          toArray()
        )
      );

      let dataFromModule: PsEventbusSyncUpload[] = messages.flat();
      let fixtures = await loadFixture(shopContent);

      if (testConfig.dumpFullSyncData) {
        await dumpUploadData(dataFromModule);
      }

      dataFromModule = omitProperties(dataFromModule, Object.keys(specialFieldAssert));

      fixtures = omitProperties(fixtures, Object.keys(specialFieldAssert));

      dataFromModule = sortUploadData(dataFromModule);
      fixtures = sortUploadData(fixtures);

      // assert
      expect(dataFromModule).toEqual(fixtures);

      // assert special field using custom matcher
      for (const data of dataFromModule) {
        for (const specialFieldName of Object.keys(specialFieldAssert)) {
          // @ts-ignore
          if (data.properties[specialFieldName] !== undefined) {
            // @ts-ignore
            specialFieldAssert[specialFieldName](data.properties[specialFieldName]);
          }
        }
      }
    });
  }
});
