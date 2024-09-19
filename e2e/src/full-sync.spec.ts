import testConfig from "./helpers/test.config";
import * as matchers from "jest-extended";
import { dumpUploadData, logAxiosError } from "./helpers/log-helper";
import axios, { AxiosError } from "axios";
import { doFullSync, probe, PsEventbusSyncUpload } from "./helpers/mock-probe";
import { lastValueFrom, toArray, withLatestFrom } from "rxjs";
import {
  generatePredictableModuleId,
  loadFixture,
  omitProperties,
  sortUploadData,
} from "./helpers/data-helper";
import { ShopContent, shopContentList } from "./helpers/shop-contents";

expect.extend(matchers);

// these ShopContent will be excluded from the following test suite
const EXCLUDED_API: ShopContent[] = ["taxonomies" as ShopContent];

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

describe("Full Sync", () => {
  let generatedNumber = 0;

  // gérer les cas ou un shopContent n'existe pas (pas de fixture du coup)
  const shopContents: ShopContent[] = shopContentList.filter(
    (it) => !EXCLUDED_API.includes(it),
  );

  let jobId: string;

  beforeEach(() => {
    generatedNumber = Date.now() + Math.trunc(Math.random() * 100000000000000);
    jobId = `valid-job-full-${generatedNumber}`;
  });

  // TODO : some versions of prestashop include ps_facebook out of the box, this test can't reliably be run for all versions
  describe.skip("taxonomies", () => {
    const shoContent = "taxonomies";

    // TODO : apiGoogleTaxonomies requires an additional module to be present : devise a specific test setup for this endpoint
    it.skip(`${shoContent} should accept full sync`, async () => {});

    it(`${shoContent} should reject full sync when ps_facebook is not installed`, async () => {
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=apiFront&is_e2e=1&shop_content=${shoContent}&limit=5&full=1&job_id=${jobId}`;

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
          expect(err).toBeInstanceOf(AxiosError);
          return err.response;
        });

      // assert
      expect(response.status).toEqual(456);
      // expect some explanation to be given to the user
      expect(response.statusText).toMatch(/[Ff]acebook/);
    });
  });

  describe.each(shopContents)("%s", (shopContent) => {
    it(`${shopContent} should accept full sync`, async () => {
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=apiFront&is_e2e=1&shop_content=${shopContent}&limit=5&full=1&job_id=${jobId}`;

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
      const response$ = doFullSync(jobId, shopContent, { timeout: 4000 });
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

      const syncedData: PsEventbusSyncUpload[] = messages.flat();

      // dump data for easier debugging or updating fixtures
      let processedData = syncedData as PsEventbusSyncUpload[];
      if (testConfig.dumpFullSyncData) {
        await dumpUploadData(syncedData, shopContent);
      }

      const fixture = await loadFixture(shopContent);

      // we need to process fixtures and data returned from ps_eventbus to make them easier to compare
      let processedFixture = fixture;
      if (shopContent === ("modules" as ShopContent)) {
        processedData = generatePredictableModuleId(processedData);
        processedFixture = generatePredictableModuleId(processedFixture);
      }
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
      for (const data of processedData) {
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
