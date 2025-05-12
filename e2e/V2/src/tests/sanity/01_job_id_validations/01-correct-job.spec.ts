import { callPsEventbus, PsEventbusHealthCheckFullResponse } from '@helpers/mock-probe';
import {test, expect} from '@playwright/test';


const testTags = ['@sanity', '@job-id-validations', '@correct-job-id'];

test.describe('Job ID validations', {tag: testTags}, async () => {

  test(`HealthCheck with correct job_id should return 200 with full response`, async () => {

    const queryParams = {
      controller: 'apiHealthCheck',
      job_id: 'valid-job-id',
    };

    const response = await callPsEventbus<PsEventbusHealthCheckFullResponse>(queryParams);

    expect(response.data).toStrictEqual({
      prestashop_version: expect.any(String),
      ps_eventbus_version: expect.any(String),
      ps_accounts_version: expect.any(String),
      php_version: expect.any(String),
      shop_id: expect.any(String),
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
