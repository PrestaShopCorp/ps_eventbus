import testConfig from "./helpers/test.config";
import * as matchers from "jest-extended";
import { dumpUploadData, logAxiosError } from "./helpers/log-helper";
import axios, { AxiosError } from "axios";
import { doFullSync, probe, PsEventbusSyncUpload } from "./helpers/mock-probe";
import { concatMap, from, lastValueFrom, map, TimeoutError, toArray, zip } from "rxjs";
import {
  generatePredictableModuleId,
  loadFixture,
  omitProperties,
  sortUploadData,
} from "./helpers/data-helper";
import { ShopContent, shopContentList } from "./helpers/shop-contents";
import { exit } from "process";
import { cp } from "fs";

expect.extend(matchers);

// these ShopContent will be excluded from the following test suite
const EXCLUDED_API: ShopContent[] = ["taxonomies" as ShopContent];

// FIXME : these api can't send anything to the mock api because the database is empty from the factory
const MISSING_TEST_DATA: ShopContent[] = [
  "cart-rules" as ShopContent,
  "custom-product-carriers" as ShopContent,
  "translations" as ShopContent,
  "wishlists" as ShopContent,
];

// these fields change from test run to test run, so we replace them with a matcher to only ensure the type and format are correct
const isDateString = (val) =>
  val ? expect(val).toBeDateString() : expect(val).toBeNull();
const isString = (val) =>
  val ? expect(val).toBeString() : expect(val).toBeNull();
const isNumber = (val) =>
  val ? expect(val).toBeNumber() : expect(val).toBeNull();
const specialFieldAssert: { [index: string]: (val) => void } = {
  'created_at': isDateString,
  'updated_at': isDateString,
  'last_connection_date': isDateString,
  'folder_created_at': isDateString,
  'date_add': isDateString,
  'from': isDateString,
  'to': isDateString,
  'conversion_rate': isNumber,
  'cms_version': isString,
  'module_id': isString,
  'module_version': isString,
  'theme_version': isString,
  'php_version': isString,
  'http_server' : isString,
}

describe('Full Sync', () => {
  let testTimestamp = 0;

  // gérer les cas ou un shopContent n'existe pas (pas de fixture du coup)
  const shopContents: ShopContent[] = shopContentList.filter(
    (it) => !EXCLUDED_API.includes(it)
  );

  let jobId: string;

  beforeEach(() => {
    testTimestamp = Date.now();
    jobId = `valid-job-full-${testTimestamp}`;
  });

  // TODO : some versions of prestashop include ps_facebook out of the box, this test can't reliably be run for all versions
  describe.skip("taxonomies", () => {
    const shoContent = "taxonomies";

    // TODO : apiGoogleTaxonomies requires an additional module to be present : devise a specific test setup for this endpoint
    it.skip(`${shoContent} should accept full sync`, async () => {});

    it.skip(`${shoContent} should upload to collector`, async () => {});

    it(`${shoContent} should reject full sync when ps_facebook is not installed`, async () => {
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=apiFront&is_e2e=1&shop_content=${shoContent}&limit=5&full=1&job_id=${jobId}`;

      const callId = { 'call_id': Math.random().toString(36).substring(2, 11) };

      // act
      const response = await axios
        .post(url, callId, {
          headers: { 
            Host: testConfig.prestaShopHostHeader,
            'Content-Type': 'application/x-www-form-urlencoded' // for compat PHP 5.6
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

      const callId = { 'call_id': Math.random().toString(36).substring(2, 11) };

      // act
      const response = await axios
        .post(url, callId, {
          headers: {
            Host: testConfig.prestaShopHostHeader,
            'Content-Type': 'application/x-www-form-urlencoded' // for compat PHP 5.6
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

    if (MISSING_TEST_DATA.includes(shopContent)) {
      it.skip(`${shopContent} should upload to collector`, () => {});
    } else {
      it(`${shopContent} should upload to collector`, async () => {
        // arrange
        const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=apiFront&is_e2e=1&shop_content=${shopContent}&limit=5&full=1&job_id=${jobId}`;
        const message$ = probe({ url: `/upload/${jobId}` });

        const callId = { 'call_id': Math.random().toString(36).substring(2, 11) };

        // act
        const request$ = from(
          axios.post(url, callId, {
            headers: {
              Host: testConfig.prestaShopHostHeader,
              'Content-Type': 'application/x-www-form-urlencoded' // for compat PHP 5.6
            },
          })
        );

        // check if shopcontent have items lenght > 0
        request$.subscribe(async (request) => {
          if (request.data.total_objects != 0) {
            let results;

            try {
              results = await lastValueFrom(
                zip(message$, request$).pipe(
                  map((result) => ({
                    probeMessage: result[0],
                    psEventbusReq: result[1],
                  })),
                  toArray()
                )
              );
            } catch (error) {
              if (error instanceof TimeoutError) {
                throw new Error(`Upload to collector for "${shopContent}" throw TimeoutError with jobId "${jobId}"`)
              } 
            }
            
            // assert
            expect(results.length).toEqual(1);
            expect(results[0].probeMessage.method).toBe("POST");
            expect(results[0].probeMessage.headers).toMatchObject({
              "full-sync-requested": "1",
            });
          }
        })
      });
    }
    

    if (MISSING_TEST_DATA.includes(shopContent)) {
      it.skip(`${shopContent} should upload complete dataset to collector`, () => {});
    } else {
      it(`${shopContent} should upload complete dataset collector`, async () => {
        // arrange
        const fullSync$ = doFullSync(jobId, shopContent, { timeout: 4000 });
        const message$ = probe({ url: `/upload/${jobId}` }, { timeout: 4000 });
        
        let syncedData: PsEventbusSyncUpload[];
        let hasData = false;

        try {
          // act
          hasData = (await lastValueFrom(fullSync$)).total_objects != 0;

          if (hasData) {
            syncedData = await lastValueFrom(
              zip(fullSync$, message$).pipe(
                map((msg) => {
                  return msg[1].body.file
                }),
                concatMap((syncedPage) => {
                  return from(syncedPage);
                }),
                toArray()
              )
            );
          }
        } catch (error) {
          if (error instanceof TimeoutError) {
            throw new Error(`Upload complete dataset collector for "${shopContent}" throw TimeoutError with jobId "${jobId}"`)
          } 
        }

        if (!hasData) {
          return;
        }

        // dump data for easier debugging or updating fixtures
        if (testConfig.dumpFullSyncData) {
          await dumpUploadData(syncedData, shopContent);
        }

        const fixture = await loadFixture(shopContent);

        // we need to process fixtures and data returned from ps_eventbus to make them easier to compare
        let processedData = syncedData;
        let processedFixture = fixture;
        if (shopContent  === "modules" as ShopContent) {
          processedData = generatePredictableModuleId(processedData);
          processedFixture = generatePredictableModuleId(processedFixture);
        }
        processedData = omitProperties(
          processedData,
          Object.keys(specialFieldAssert)
        );
        processedData = sortUploadData(processedData);
        processedFixture = omitProperties(
          processedFixture,
          Object.keys(specialFieldAssert)
        );
        processedFixture = sortUploadData(processedFixture);

        // assert
        expect(processedData).toMatchObject(processedFixture);

        // assert special field using custom matcher
        for (const data of syncedData) {
          for (const specialFieldName of Object.keys(specialFieldAssert)) {
            if (data.properties[specialFieldName] !== undefined) {
              specialFieldAssert[specialFieldName](
                data.properties[specialFieldName]
              );
            }
          }
        }
      });
    }
  });
});
