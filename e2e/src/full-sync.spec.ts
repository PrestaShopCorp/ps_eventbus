import testConfig from "./helpers/test.config";
import * as matchers from "jest-extended";
import { dumpUploadData, logAxiosError } from "./helpers/log-helper";
import axios, { AxiosError } from "axios";
import { doFullSync, probe, PsEventbusSyncUpload } from "./helpers/mock-probe";
import { concatMap, from, lastValueFrom, map, toArray, zip } from "rxjs";
import {
  generatePredictableModuleId,
  loadFixture,
  omitProperties,
  sortUploadData,
} from "./helpers/data-helper";
import { Controller, controllerList } from "./helpers/controllers";

expect.extend(matchers);

// these controllers will be excluded from the following test suite
const EXCLUDED_API: Controller[] = ["apiGoogleTaxonomies"];

// FIXME : these api can't send anything to the mock api because the database is empty from the factory
const MISSING_TEST_DATA: Controller[] = [
  "apiCartRules",
  "apiCustomProductCarriers",
  "apiTranslations",
  "apiWishlists",
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
  let testIndex = 0;

  // gérer les cas ou un shopContent n'existe pas (pas de fixture du coup)
  const controllers: Controller[] = controllerList.filter(
    (it) => !EXCLUDED_API.includes(it)
  );

  let jobId: string;

  beforeEach(() => {
    jobId = `valid-job-full-${testIndex++}`;
  });

  // TODO : some versions of prestashop include ps_facebook out of the box, this test can't reliably be run for all versions
  describe.skip("apiGoogleTaxonomies", () => {
    const controller = "apiGoogleTaxonomies";

    // TODO : apiGoogleTaxonomies requires an additional module to be present : devise a specific test setup for this endpoint
    it.skip(`${controller} should accept full sync`, async () => {});

    it.skip(`${controller} should upload to collector`, async () => {});

    it(`${controller} should reject full sync when ps_facebook is not installed`, async () => {
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&full=1&job_id=${jobId}`;

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

  describe.each(controllers)("%s", (controller) => {
    it(`${controller} should accept full sync`, async () => {
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&full=1&job_id=${jobId}`;

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

    if (MISSING_TEST_DATA.includes(controller)) {
      it.skip(`${controller} should upload to collector`, () => {});
    } else {
      it(`${controller} should upload to collector`, async () => {
        // arrange
        const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&full=1&job_id=${jobId}`;
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

        const results = await lastValueFrom(
          zip(message$, request$).pipe(
            map((result) => ({
              probeMessage: result[0],
              psEventbusReq: result[1],
            })),
            toArray()
          )
        );

        // assert
        expect(results.length).toEqual(1);
        expect(results[0].probeMessage.method).toBe("POST");
        expect(results[0].probeMessage.headers).toMatchObject({
          "full-sync-requested": "1",
        });
      });
    }
    

    if (MISSING_TEST_DATA.includes(controller)) {
      it.skip(`${controller} should upload complete dataset to collector`, () => {});
    } else {
      it(`${controller} should upload complete dataset collector`, async () => {
        
        // arrange
        const fullSync$ = doFullSync(jobId, controller, { timeout: 4000 });
        const message$ = probe({ url: `/upload/${jobId}` }, { timeout: 4000 });

        // act
        const syncedData: PsEventbusSyncUpload[] = await lastValueFrom(
          zip(fullSync$, message$).pipe(
            map((msg) => msg[1].body.file),
            concatMap((syncedPage) => {
              return from(syncedPage);
            }),
            toArray()
          )
        );

        // dump data for easier debugging or updating fixtures
        if (testConfig.dumpFullSyncData) {
          await dumpUploadData(syncedData, controller);
        }

        const fixture = await loadFixture(controller);

        // we need to process fixtures and data returned from ps_eventbus to make them easier to compare
        let processedData = syncedData;
        let processedFixture = fixture;
        if (controller === "apiModules") {
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
