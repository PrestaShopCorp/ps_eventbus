import request from 'supertest';
import { CollectorApi, SyncApi } from '../helpers/api-mock';
import { config } from '../helpers/config';

const controller = 'apiCategories';
const endpoint = `index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5`;

describe('CategoriesController', () => {
  let syncApi;
  let syncApiRequestData;
  let collectorApi;
  let collectorApiRequestData;

  beforeAll(async () => {
    syncApi = new SyncApi(config.syncApiPort);
    syncApiRequestData = jest.spyOn(syncApi, 'requestData');

    collectorApi = new CollectorApi(config.collectorApiPort);
    collectorApiRequestData = jest.spyOn(collectorApi, 'requestData');
  });

  afterEach(() => {
    syncApiRequestData.mockClear();
    collectorApiRequestData.mockClear();
  });

  it('should be defined', () => {
    expect(config.prestaShopBaseUrl).toBeDefined();
  });

  it('should return 500 with an invalid job id (sync-api status 500)', async () => {
    jest.setTimeout(10000);
    const jobId = `invalid-job-${Date.now()}`
    await request(config.prestaShopBaseUrl)
      .get(`${endpoint}&job_id=${jobId}`)
      .set({ host: config.prestaShopHostHeader })
      .redirects(1)
      .expect('content-type', /json/)
      .expect(500);

    expect(syncApiRequestData).toHaveBeenCalledWith(
      expect.objectContaining({
        url: expect.stringContaining(jobId),
      }),
    );
    expect(collectorApiRequestData).not.toHaveBeenCalled();
  });

  it('should synchronize (sync-api and proxy-api status 201)', async () => {
    const jobId = Date.now();
    const req = await request(config.prestaShopBaseUrl)
      .get(`${endpoint}&job_id=valid-job-${jobId}`)
      .set({ host: config.prestaShopHostHeader })
      .redirects(1)
      .expect('content-type', /json/)
      .expect(201);

    expect(syncApiRequestData).toHaveBeenCalledWith(
      expect.objectContaining({
        url: expect.stringContaining(`valid-job-${jobId}`),
      }),
    );
    expect(collectorApiRequestData).toHaveBeenCalledWith(
      expect.objectContaining({
        url: expect.stringContaining(`valid-job-${jobId}`),
        files: expect.arrayContaining([
          expect.objectContaining({ fieldname: 'file' }),
        ]),
      }),
    );
    expect(req.body.total_objects).toEqual(1);
    console.log(req.body);
  });

  afterAll(() => {
    syncApi.close();
    collectorApi.close();
  });
});
