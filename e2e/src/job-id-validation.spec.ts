import testConfig from './helpers/test.config';
import { beforeEach, describe, expect } from '@jest/globals';
import axios from 'axios';
import { from, lastValueFrom, map, toArray, zip } from 'rxjs';
import { callPsEventbus, probe, PsEventbusHealthCheckFullResponse, PsEventbusHealthCheckLiteResponse } from './helpers/mock-probe';
import { ShopContent, shopContentList } from './helpers/shop-contents';

describe('Reject invalid job-id', () => {
    let generatedNumber = 0;

    const shopContents: ShopContent[] = shopContentList;

    let jobId: string;

    beforeEach(() => {
        generatedNumber = Date.now() + Math.trunc(Math.random() * 100000000000000);
        jobId = `invalid-job-id-${generatedNumber}`;
    });

    it.each(shopContents)(`%s should return 454 with an invalid job id (sync-api status 454)`, async (shopContent) => {
        expect.assertions(6);
        // arrange
        const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=apiShopContent&shop_content=${shopContent}&limit=5&job_id=${jobId}`;
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
        expect(results[0].probeMessage.method).toBe('GET');
        expect(results[0].probeMessage.url.split('/')).toContain(jobId);
        expect(results[0].psEventbusReq.status).toEqual(454);
        expect(results[0].psEventbusReq.headers).toMatchObject({
            'content-type': /json/,
        });
        expect(results[0].psEventbusReq.data).toMatchObject({
            status: false,
            httpCode: 454,
        });
    });

    it('HealthCheck without job_id (or falsy job_id) should return 200 with minimal response', async () => {
        const queryParams = {
            controller: 'apiHealthCheck',
        };

        const response = await callPsEventbus<PsEventbusHealthCheckLiteResponse>(queryParams);

        expect(response.data).toMatchObject({
            ps_account: true,
            is_valid_jwt: true,
            ps_eventbus: true,
            env: expect.objectContaining({
                EVENT_BUS_PROXY_API_URL: expect.any(String),
                EVENT_BUS_SYNC_API_URL: expect.any(String),
                EVENT_BUS_LIVE_SYNC_API_URL: expect.any(String),
            }),
            httpCode: 200,
        });
    });

    it('HealthCheck with correct job_id should return 200 with full response', async () => {
        const queryParams = {
            controller: 'apiHealthCheck',
            job_id: 'valid-job-id',
        };

        const response = await callPsEventbus<PsEventbusHealthCheckFullResponse>(queryParams);

        expect(response.data).toMatchObject({
            prestashop_version: expect.any(String),
            ps_eventbus_version: expect.any(String),
            ps_accounts_version: expect.any(String),
            php_version: expect.any(String),
            shop_id: expect.any(String),
            ps_account: true,
            is_valid_jwt: true,
            ps_eventbus: true,
            env: expect.objectContaining({
                EVENT_BUS_PROXY_API_URL: expect.any(String),
                EVENT_BUS_SYNC_API_URL: expect.any(String),
                EVENT_BUS_LIVE_SYNC_API_URL: expect.any(String),
            }),
            httpCode: 200,
        });
    });
});
