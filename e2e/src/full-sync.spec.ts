import testConfig from "./helpers/test.config";
import * as matchers from "jest-extended";
import { dumpUploadData, logAxiosError } from "./helpers/log-helper";
import axios from "axios";
import { doFullSync, probe, PsEventbusSyncUpload } from "./helpers/mock-probe";
import { lastValueFrom, toArray, withLatestFrom } from "rxjs";
import {
  loadFixture,
  omitProperties,
  sortUploadData,
} from "./helpers/data-helper";
import { shopContentList } from "./helpers/shop-contents";

expect.extend(matchers);

// these fields change from test run to test run, so we replace them with a matcher to only ensure the type and format are correct
const isDateString = (val) =>
  val ? expect(val).toBeDateString() : expect(val).toBeNull();
const isString = (val) =>
  val ? expect(val).toBeString() : expect(val).toBeNull();
const isNumber = (val) =>
  val ? expect(val).toBeNumber() : expect(val).toBeNull();
const isBoolean = (val) =>
  val ? expect(val).toBeBoolean() : expect(val).toBeNull();
const specialFieldAssert: { [index: string]: (val) => void } = {
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

describe("Full Sync", () => {
  let generatedNumber = 0;

  let jobId: string;

  beforeEach(() => {
    generatedNumber = Date.now() + Math.trunc(Math.random() * 100000000000000);
    jobId = `valid-job-full-${generatedNumber}`;
  });

  describe.each(shopContentList)("%s", (shopContent) => {
    it(`${shopContent} should accept full sync`, async () => {
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=apiShopContent&shop_content=${shopContent}&limit=5&full=1&job_id=${jobId}`;

      const callId = { call_id: Math.random().toString(36).substring(2, 11) };

      // act
      const response = await axios
        .post(url, callId, {
          headers: {
            Host: testConfig.prestaShopHostHeader,
            "Content-Type": "application/x-www-form-urlencoded", // for compat PHP 5.6
          },
        })
        .catch((err) => {
          logAxiosError(err);
          expect(err).toBeNull();
          throw err;
        });

      // assert
      expect(response.status).toBeOneOf([200, 201]);
      expect(response.headers).toMatchObject({ "content-type": /json/ });
      expect(response.data).toMatchObject({
        job_id: jobId,
        syncType: "full",
      });
    });

    it(`${shopContent} should upload complete dataset collector`, async () => {
      // arrange
      const response$ = doFullSync(jobId, shopContent, { timeout: 5000 });
      const message$ = probe({ url: `/upload/${jobId}` }, { timeout: 4000 });

      // this combines each response from ps_eventbus to the last request captured by the probe.
      // it works because ps_eventbus sends a response after calling our mock collector server
      // if ps_eventbus doesn't need to call the collector, the probe completes without value after its timeout
      const messages = await lastValueFrom(
        response$.pipe(
          withLatestFrom(message$, (_, message) => message.body.file),
          toArray(),
        ),
      );

      let dataFromModule: PsEventbusSyncUpload[] = messages.flat();
      let fixtures = await loadFixture(shopContent);

      if (testConfig.dumpFullSyncData) {
        await dumpUploadData(dataFromModule);
      }

      dataFromModule = omitProperties(
        dataFromModule,
        Object.keys(specialFieldAssert),
      );

      fixtures = omitProperties(fixtures, Object.keys(specialFieldAssert));

      dataFromModule = sortUploadData(dataFromModule);
      fixtures = sortUploadData(fixtures);

      // assert
      expect(dataFromModule).toEqual(fixtures);

      // assert special field using custom matcher
      for (const data of dataFromModule) {
        for (const specialFieldName of Object.keys(specialFieldAssert)) {
          if (data.properties[specialFieldName] !== undefined) {
            specialFieldAssert[specialFieldName](
              data.properties[specialFieldName],
            );
          }
        }
      }
    }); // Timeout set to 30s because full sync can take a long time
  });
});
