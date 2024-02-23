import {doFullSync, MockProbe, probe} from './helpers/mock-probe';
import {expect} from "@jest/globals";
import {concatAll, concatMap, from, lastValueFrom, map, mergeAll, of, tap, toArray, zip} from "rxjs";

export type PsEventbusSyncResponse = {
  job_id: string,
  object_type: string,
  syncType: string, // 'full' | 'incremental'
  total_objects: number, // may not always be accurate, can't be relied on
  has_remaining_objects: boolean, // reliable
  remaining_objects: number, // may not always be accurate, can't be relied on
  md5: string,
  status: boolean,
  httpCode: number,
  body: unknown, // not sure what this is
  upload_url: string,
}

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

