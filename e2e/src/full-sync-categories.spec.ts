import {doFullSync, probe} from './helpers/mock-probe';
import {expect} from "@jest/globals";
import {concatAll, concatMap, from, lastValueFrom, map, toArray, zip} from "rxjs";

let testIndex = 0;

let jobId: string = `valid-job-full-categories`;

beforeEach(() => {
  jobId = `valid-job-full-better-${testIndex++}`
});

describe('apiCategories full sync but more better', () => {
  it(`apiCategories should upload to collector bet`, async () => {
    // arrange
    const fullSync$ = doFullSync(jobId);
    const message$ = probe({url: `/upload/${jobId}`})


    // act
    const syncedData = await lastValueFrom(zip(fullSync$, message$).pipe(
      map(msg => msg[1].body.file),
      concatMap(syncedPage => {
        return from(syncedPage);
      }),
      toArray(),
    ))

    // asset
    expect(syncedData.length).toEqual(9);
  });
})

