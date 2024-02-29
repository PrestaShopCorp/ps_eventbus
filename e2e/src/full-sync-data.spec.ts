import {Controller, doFullSync, probe, PsEventbusSyncUpload} from './helpers/mock-probe';
import {concatMap, from, lastValueFrom, map, toArray, zip} from "rxjs";
import testConfig from "./helpers/test.config";
import {sortUploadData} from "./helpers/data-helper";
import {dumpData} from "./helpers/log-helper";
import R from "ramda";
import * as matchers from 'jest-extended';

expect.extend(matchers);

// these controllers will be excluded from the following test suite
const EXCLUDED_API: Controller[] = ['apiHealthCheck', 'apiGoogleTaxonomies'];

// FIXME : these api can't send anything to the mock api because the database is empty from the factory
const MISSING_TEST_DATA: Controller[] = ['apiCartRules', 'apiCustomProductCarriers', 'apiDeletedObjects', 'apiTranslations', 'apiWishlists'];

// these fields change from test run to test run, so we replace them with a matcher to only ensure the type and format are correct
const isDateString = val => expect(val).toBeDateString();
const isString = val => expect(val).toBeString();
const specialFieldAssert: { [index: string]: (val) => void } = {
  'created_at': isDateString,
  'updated_at': isDateString,
  'last_connection_date': isDateString,
  'folder_created_at': isDateString,
  'date_add': isDateString,
  'from': isDateString,
  'to': isDateString,
  'conversion_rate': val => expect(val).toBeNumber(),
  'cms_version': isString,
  'module_version': isString,
  'name': isString,
}

describe('Full Sync Data', () => {
  let testIndex = 0;
  const controllers = testConfig.controllers.filter(it => !EXCLUDED_API.includes(it))
  let jobId: string;

  beforeEach(() => {
    jobId = `valid-job-full-data-${testIndex++}`
  });

  describe.each(controllers)('%s', (controller) => {

    describe(`${controller} full sync data`, () => {
      if (MISSING_TEST_DATA.includes(controller)) {
        it.skip(`${controller} should upload all data to collector`, () => {
        })
      } else {
        it(`${controller} should upload all data to collector`, async () => {
          // arrange
          const fullSync$ = doFullSync(jobId, controller, {timeout: 4000});
          const message$ = probe({url: `/upload/${jobId}`}, {timeout: 4000})

          // load fixtures and filter out fields we know won't exactly match
          const fixture: PsEventbusSyncUpload[] = require(`./fixtures/${controller}.json`);
          const fixtureWithoutDate: PsEventbusSyncUpload[] = fixture.map(it => ({
            ...it,
            properties: R.omit(Object.keys(specialFieldAssert), it.properties)
          }))

          // act
          const syncedData: PsEventbusSyncUpload[] = await lastValueFrom(zip(fullSync$, message$).pipe(
            map(msg => msg[1].body.file),
            concatMap(syncedPage => {
              return from(syncedPage);
            }),
            toArray(),
          ))

          // dump data for easier debugging or updating fixtures
          if (testConfig.dumpFullSyncData) {
            dumpData(syncedData, controller);
          }

          // assert
          expect(sortUploadData(syncedData)).toMatchObject(sortUploadData(fixtureWithoutDate));
          // assert special field using custom matcher
          for (const data of syncedData) {
            for (const specialFieldName of Object.keys(specialFieldAssert)) {
              if (data.properties[specialFieldName] !== undefined) {
                specialFieldAssert[specialFieldName](data.properties[specialFieldName]);
              }
            }
          }
        });
      }
    });

  });
});
