import {Controller, doFullSync, probe} from './helpers/mock-probe';
import {concatMap, from, lastValueFrom, map, toArray, zip} from "rxjs";
import testConfig from "./helpers/test.config";
import * as fs from "fs";
import {sortUploadData} from "./helpers/data-helper";

// these controllers will be excluded from the following test suite
const EXCLUDED_API: Controller[] = ['apiHealthCheck', 'apiGoogleTaxonomies'];

// FIXME : these api can't send anything to the mock api because the database is empty from the factory
const MISSING_TEST_DATA: Controller[] = ['apiCartRules', 'apiCustomProductCarriers', 'apiDeletedObjects', 'apiTranslations', 'apiWishlists'];


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

          // act
          const syncedData = await lastValueFrom(zip(fullSync$, message$).pipe(
            map(msg => msg[1].body.file),
            concatMap(syncedPage => {
              return from(syncedPage);
            }),
            toArray(),
          ))

          //fs.writeFileSync(`src/fixtures/${controller}.json`, JSON.stringify(syncedData, null, 2));
          const fixture = require(`./fixtures/${controller}.json`);
          expect(sortUploadData(syncedData)).toMatchObject(sortUploadData(fixture));
          // TODO : check actual content against expected content
        });
      }

    });

  });

});
