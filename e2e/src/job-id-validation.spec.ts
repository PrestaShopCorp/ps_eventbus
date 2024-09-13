import testConfig from "./helpers/test.config";
import { beforeEach, describe, expect } from "@jest/globals";
import axios from "axios";
import { from, lastValueFrom, map, toArray, zip } from "rxjs";
import { probe } from "./helpers/mock-probe";
import { Controller, controllerList } from "./helpers/controllers";

describe("Reject invalid job-id", () => {
  let testIndex = 0;

  const controllers: Controller[] = controllerList;

  let jobId: string;

  describe("healthcheck endpoint", () => {
    it(`should return an authentified payload with an valid job-id`, async () => {
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=apiHealthCheck&job_id=valid-job-1`;

      //act
      const res = await axios.get(url, {
        headers: { Host: testConfig.prestaShopHostHeader },
      });

      // assert
      expect(res.status).toEqual(200);
      expect(res.headers).toMatchObject({
        "content-type": /json/,
      });
      expect(res.data).toMatchObject({
        httpCode: 200,
        shop_id: "f07181f7-2399-406d-9226-4b6c14cf6068",
        is_valid_jwt: true,
        ps_account: true,
        ps_eventbus: true,
        php_version: "8.1.29",
        prestashop_version: "8.1.7",
        ps_accounts_version: "7.0.2",
        ps_eventbus_version: "0.0.0",
        env: {
          EVENT_BUS_LIVE_SYNC_API_URL: "http://reverse-proxy/live-sync-api/v1",
          EVENT_BUS_PROXY_API_URL: "http://reverse-proxy/collector",
          EVENT_BUS_SYNC_API_URL: "http://reverse-proxy/sync-api",
        },
      });
    });

    it(`should return a minimal dataset with an invalid job`, async () => {
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=apiHealthCheck&job_id=invalid-job`;

      //act
      const res = await axios.get(url, {
        headers: { Host: testConfig.prestaShopHostHeader },
      });

      // assert
      expect(res.status).toEqual(200);
      expect(res.headers).toMatchObject({
        "content-type": /json/,
      });
      expect(res.data).toMatchObject({
        httpCode: 200,
        is_valid_jwt: true,
        ps_account: true,
        ps_eventbus: true,
        env: {
          EVENT_BUS_LIVE_SYNC_API_URL: "http://reverse-proxy/live-sync-api/v1",
          EVENT_BUS_PROXY_API_URL: "http://reverse-proxy/collector",
          EVENT_BUS_SYNC_API_URL: "http://reverse-proxy/sync-api",
        },
      });
    });
  });

  describe("data endpoints", () => {
    beforeEach(() => {
      jobId = `invalid-job-id-${testIndex++}`;
    });

    it.each(controllers)(
      `%s should return 454 with an invalid job id (sync-api status 454)`,
      async (controller) => {
        expect.assertions(6);
        // arrange
        const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&job_id=${jobId}`;
        const message$ = probe({ params: { id: jobId } });

        //act
        const request$ = from(
          axios
            .get(url, {
              headers: { Host: testConfig.prestaShopHostHeader },
            })
            .then((res) => {
              expect(res).toBeNull(); // fail test
            })
            .catch((err) => {
              return err.response;
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
        expect(results[0].probeMessage.method).toBe("GET");
        expect(results[0].probeMessage.url.split("/")).toContain(jobId);
        expect(results[0].psEventbusReq.status).toEqual(454);
        expect(results[0].psEventbusReq.headers).toMatchObject({
          "content-type": /json/,
        });
        expect(results[0].psEventbusReq.data).toMatchObject({
          status: false,
          httpCode: 454,
        });
      }
    );
  });
});
