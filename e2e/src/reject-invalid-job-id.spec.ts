import testConfig from './helpers/test.config';
import {beforeEach, describe, expect} from "@jest/globals";
import axios from "axios";
import {from, lastValueFrom, map, toArray, zip} from "rxjs";
import {probe} from "./helpers/mock-probe";
import {Controller, controllerList} from "./helpers/controllers";

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
        expect(res).toBeNull(); // fail test
      }).catch(err => {
        return err.response;
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
      expect(results[0].psEventbusReq.status).toEqual(454);
      expect(results[0].psEventbusReq.headers).toMatchObject({'content-type': /json/});
      expect(results[0].psEventbusReq.data).toMatchObject({
        status: false,
        httpCode: 454,
      });
    }
  );
})
