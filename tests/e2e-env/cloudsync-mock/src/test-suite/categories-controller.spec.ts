import request from "supertest";
//import fetch from "node-fetch";
import {expect, describe, beforeAll, it, afterAll} from '@jest/globals';
import { startSyncApi, startProxyApi } from "../helpers/api-mock";

const controller = 'apiCategories';

const url = 'http://prestashop';
const endpoint = `/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5`;
describe("CategoriesController", () => {
    let syncApi;
    let proxyApi;

    beforeAll( async () => {
        syncApi = await startSyncApi(); 
        proxyApi = await startProxyApi();
    });

    it('should be defined', () => {
        expect(url).toBeDefined();
    });
    it("should return 500 because job is invalid (sync-api response == 500)", async () => {
        await request(url)
        .get(`${endpoint}&job_id=invalid-job-${Date.now()}}`)
        .redirects(1)
        .expect('content-type', /json/)
        .expect(500)
    });
    it("should return 201 because job is valid (sync-api and proxy-api response == 201)", async () => {
        const req = await request(url)
        .get(`${endpoint}&job_id=valid-job-${Date.now()}}`)
        .redirects(1)
        .expect('content-type', /json/)
        .expect(201)

        console.log(req.body);
    });

    afterAll(() => {
        syncApi.close();
        proxyApi.close();
    })
})