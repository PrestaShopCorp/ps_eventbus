import {MockProbe} from './helpers/mock-probe';
import testConfig from './helpers/test.config';
import * as matchers from 'jest-extended';
import {logAxiosError} from "./helpers/log-helper";
import axios, {AxiosError, AxiosResponse} from "axios";
import {expect} from "@jest/globals";

expect.extend(matchers);

// // these controllers will be excluded from the following test suite
// const EXCLUDED_API: typeof testConfig.controllers[number][] = ['apiHealthCheck', 'apiGoogleTaxonomies'];

// // FIXME : these api can't send anything to the mock api because the database is empty from the factory
// const MISSING_TEST_DATA: typeof testConfig.controllers[number][] = ['apiCartRules', 'apiCustomProductCarriers', 'apiDeletedObjects', 'apiTranslations', 'apiWishlists'];

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

async function* doFullSync(): AsyncGenerator<PsEventbusSyncResponse> {
  let full = 1;
  let lastPage = false;
  while (!lastPage) {
    const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=apiCategories&limit=5&full=${full}&job_id=${jobId}`;
    console.log(url);
    const response = await axios.post<PsEventbusSyncResponse>(url, {
      headers: {
        'Host': testConfig.prestaShopHostHeader
      },
    })
    lastPage = !response.data.has_remaining_objects;
    full = 0;
    yield response.data;
  }
}

let testIndex = 0;
let probe = new MockProbe();

// const controllers = testConfig.controllers.filter(it => !EXCLUDED_API.includes(it))

let jobId: string = `valid-job-full-categories`;

 beforeEach(() => {
   jobId = `valid-job-full-better-${testIndex++}`
});

describe('apiCategories full sync but more better' , () => {
      it(`apiCategories should upload to collector bet`, async () => {
        // arrange

        // act
        const allTheResponses = [];
        const collectorRequests = [];
        let done = false;
        const fullSync = doFullSync();

        while (!done) {
          const message = probe.waitForMessages(1, {url: `/upload/${jobId}`});
          const response = await fullSync.next()
          allTheResponses.push( response.value);
          const collectorReq = await message;
          collectorRequests.push( ...collectorReq );
          done = response.done;
        }

        const uploadedItems = collectorRequests.flatMap(request => request.body.file)

        console.debug(uploadedItems);

        // assert
        expect(allTheResponses).toEqual('toto')
      });
  })

