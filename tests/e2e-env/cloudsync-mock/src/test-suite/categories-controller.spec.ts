import {
  afterAll,
  afterEach,
  beforeAll,
  describe,
  expect,
  it,
  jest,
} from "@jest/globals";
import request from "supertest";
import { ProxyApi, SyncApi } from "../helpers/api-mock";
import configTest from "./config.test";

describe("CategoriesController", () => {
  let syncApi;
  let syncApiRequestData;
  let proxyApi;
  let proxyApiRequestData;

  const url = configTest.prestashopUrl;
  const controller = "apiCategories";
  const endpoint = `/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5`;

  // @TODO: what about multishop testing?
  beforeAll(async () => {
    syncApi = new SyncApi(3232);
    syncApiRequestData = jest.spyOn(syncApi, "requestData");

    proxyApi = new ProxyApi(3333);
    proxyApiRequestData = jest.spyOn(proxyApi, "requestData");
  });

  afterEach(() => {
    syncApiRequestData.mockClear();
    proxyApiRequestData.mockClear();
  });

  afterAll(() => {
    syncApi.close();
    proxyApi.close();
  });

  it("should be defined", () => {
    expect(url).toBeDefined();
  });

  it("should return 500 because job is invalid (sync-api response == 500)", async () => {
    jest.setTimeout(10_000); // TODO: timeouts should not be needed
    const id = Date.now();

    await request(url)
      .get(`${endpoint}&job_id=invalid-job-${id}}`)
      .redirects(1)
      .expect("content-type", /json/)
      .expect(500); // @TODO: why 500 and not 403/401?

    expect(syncApiRequestData).toHaveBeenCalledWith(
      expect.objectContaining({
        url: expect.stringContaining(`invalid-job-${id}`),
      })
    );

    expect(proxyApiRequestData).not.toHaveBeenCalled();
  });

  it("should synchronize (sync-api and proxy-api response == 201)", async () => {
    const jobId = Date.now();
    const req = await request(url)
      .get(`${endpoint}&job_id=valid-job-${jobId}`)
      .redirects(1)
      .expect("content-type", /json/)
      .expect(201);
    // @TODO check req body output
    // @TODO job ids do have a local cache

    expect(syncApiRequestData).toHaveBeenCalledWith(
      expect.objectContaining({
        url: expect.stringContaining(`valid-job-${jobId}`),
      })
    );

    expect(proxyApiRequestData).toHaveBeenCalledWith(
      expect.objectContaining({
        url: expect.stringContaining(`valid-job-${jobId}`),
        files: expect.arrayContaining([
          // TODO: check content of this file
          expect.objectContaining({ fieldname: "file" }),
        ]),
      })
    );

    // TODO: check the incremental_sync table state
    expect(req.body.total_objects).toEqual(1);
    console.log(req.body);
  });
});
