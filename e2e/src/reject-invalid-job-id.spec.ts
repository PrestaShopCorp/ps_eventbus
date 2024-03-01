import testConfig from './helpers/test.config';
import {beforeEach, describe, expect} from "@jest/globals";
import axios from "axios";
import {from, lastValueFrom, map, toArray, zip} from "rxjs";
import {Controller, controllerList} from "./type/controllers";
import {probe} from "./helpers/mock-probe";

describe('Reject invalid job-id', () => {
  let testIndex = 0;

  const controllers: Controller[] = controllerList

  let jobId: string;

  beforeEach(() => {
    jobId = `invalid-job-id-${testIndex++}`
  });

  it.each(controllers)(`%s should return 454 with an invalid job id (sync-api status 454)`, async (controller) => {
      expect.assertions(6);
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&job_id=${jobId}`
      const message$ = probe({params: {id: jobId}});

      //act
      const request$ = from(axios.get(url, {
        headers: {'Host': testConfig.prestaShopHostHeader}
      }).then(res => {
        expect(res).toBeNull();
      }).catch(err => {
        // assert
        expect(err.response.status).toEqual(454);
        expect(err.response.headers).toMatchObject({'content-type': /json/});
        expect(err.response.data).toMatchObject({
          status: false,
          httpCode: 454,
        });
      }))

      const results = await lastValueFrom(zip(message$, request$)
        .pipe(map(result => ({
            probeMessage: result[0],
            psEventbusReq: result[1],
          })),
          toArray()));

      // assert
      expect(results.length).toEqual(1);
      expect(results[0].probeMessage.method).toBe('GET');
      expect(results[0].probeMessage.url.split('/')).toContain(jobId);
    }
  );
})
