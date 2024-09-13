import testConfig from "./helpers/test.config";
import axios from "axios";
import { expect } from "@jest/globals";
import { getShopHealthCheck } from "./helpers/data-helper";

// This suite is designed to help troubleshoot the e2e environment by checking if some prerequisites are met.
describe("e2e setup", () => {
  it("ps_eventbus should be up and ready", async () => {
    const healthCheck = await getShopHealthCheck({ cache: false });
    expect(healthCheck.ps_eventbus).toEqual(true);
  });

  it("Collector mock should be up and ready", async () => {
    const res = await axios.get(
      `${testConfig.mockBaseUrl}${testConfig.mockCollectorPath}/healthcheck`,
    );
    expect(res.data.mock).toEqual("CollectorApiServer");
  });

  it("Live Sync Api mock should be up and ready", async () => {
    const res = await axios.get(
      `${testConfig.mockBaseUrl}${testConfig.mockLiveSyncApiPath}/healthcheck`,
    );
    expect(res.data.mock).toEqual("LiveSyncApiServer");
  });

  it("Sync Api mock should be up and ready", async () => {
    const res = await axios.get(
      `${testConfig.mockBaseUrl}${testConfig.mockSyncApiPath}/healthcheck`,
    );
    expect(res.data.mock).toEqual("SyncApiServer");
  });
});
