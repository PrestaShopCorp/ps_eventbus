import { callPsEventbus, PsEventbusHealthCheckLiteResponse } from '@helpers/mock-probe';
import {test, expect} from '@playwright/test';


const testTags = ['@sanity', '@job-id-validations', '@missing-or-falsy'];

test.describe('Job ID validations', {tag: testTags}, async () => {

  test(`HealthCheck without job_id (or falsy job_id) should return 200 with minimal response`, async () => {

    const queryParams = {
      controller: 'apiHealthCheck',
    };

    const response = await callPsEventbus<PsEventbusHealthCheckLiteResponse>(queryParams);

    expect(response.data).toStrictEqual({
      ps_account: true,
      is_valid_jwt: true,
      ps_eventbus: true,
      env: {
        EVENT_BUS_PROXY_API_URL: expect.any(String),
        EVENT_BUS_SYNC_API_URL: expect.any(String),
        EVENT_BUS_LIVE_SYNC_API_URL: expect.any(String),
      },
      httpCode: 200,
    });
  });
});
