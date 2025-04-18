// Import types
import {test as setup, test, expect} from '@playwright/test';
import testConfig from '../../../../src/helpers/test.config';
import axios from 'axios';
import { getShopHealthCheck } from '../../../../src/helpers/data-helper';

// This suite is designed to help troubleshoot the e2e environment by checking if some prerequisites are met.
setup('[HEALTHCHECK] - @healthcheck', async () => {

  await test.step('Should check ps_eventbus is up and ready', async () => {
    const healthCheck = await getShopHealthCheck({cache: false});
    expect(healthCheck.ps_eventbus).toEqual(true);
    process.env['PS_VERSION'] = healthCheck.prestashop_version;
  });

  await test.step('Should check Collector mock is up and ready', async () => {
    const res = await axios.get(`${testConfig.mockBaseUrl}${testConfig.mockCollectorPath}/healthcheck`);
    expect(res.data.mock).toEqual('CollectorApiServer');
  });

  await test.step('Should check Live Sync Api mock is up and ready', async () => {
    const res = await axios.get(`${testConfig.mockBaseUrl}${testConfig.mockLiveSyncApiPath}/healthcheck`);
    expect(res.data.mock).toEqual('LiveSyncApiServer');
  });

  await test.step('Should check Sync Api mock is up and ready', async () => {
    const res = await axios.get(`${testConfig.mockBaseUrl}${testConfig.mockSyncApiPath}/healthcheck`);
    expect(res.data.mock).toEqual('SyncApiServer');
  });
});
