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

const controller = "apiCategories";

const url = "http://prestashop";
const endpoint = `/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5`;
describe("CategoriesController", () => {
  let syncApi;
  let syncApiRequestData;
  let proxyApi;
  let proxyApiRequestData;

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

  it("should be defined", () => {
    expect(url).toBeDefined();
  });
  it("should return 500 because job is invalid (sync-api response == 500)", async () => {
    jest.setTimeout(10000);
    const id = Date.now();
    await request(url)
      .get(`${endpoint}&job_id=invalid-job-${id}}`)
      .redirects(1)
      .expect("content-type", /json/)
      .expect(500);

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

    expect(syncApiRequestData).toHaveBeenCalledWith(
      expect.objectContaining({
        url: expect.stringContaining(`valid-job-${jobId}`),
      })
    );
    expect(proxyApiRequestData).toHaveBeenCalledWith(
      expect.objectContaining({
        url: expect.stringContaining(`valid-job-${jobId}`),
        files: expect.arrayContaining([
          expect.objectContaining({ fieldname: "file" }),
        ]),
      })
    );
    expect(req.body.total_objects).toEqual(1);
    console.log(req.body);
  });

  afterAll(() => {
    syncApi.close();
    proxyApi.close();
  });
});
