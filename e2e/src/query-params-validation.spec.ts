import { lastValueFrom, toArray } from "rxjs";
import { callPsEventbus, doFullSync, ExplainSqlResponse, PsEventbusSyncResponse } from "./helpers/mock-probe";
import { shopContentList } from "./helpers/shop-contents";

describe("Query param validation", () => {
    let generatedNumber = 0;
    let jobId: string;

    beforeEach(() => {
        generatedNumber = Date.now() + Math.trunc(Math.random() * 100000000000000);
        jobId = `valid-job-full-${generatedNumber}`;
    });

    const kebabToSnake = (str) => str.replace(/-/g, "_");

    describe.each(shopContentList)("%s", (shopContent) => {
        it(`${shopContent} - Test 'job_id', 'shop_content' and 'limit' query params`, async () => {
            const queryParams = {
                controller: "apiShopContent",
                shop_content: shopContent,
                job_id: jobId,
                limit: Math.floor(Math.random() * 100).toString(),
            };

            const response = await callPsEventbus<PsEventbusSyncResponse>(queryParams);

            expect(response.data.job_id).toEqual(queryParams.job_id);
            expect(response.data.object_type).toEqual(kebabToSnake(shopContent));
            expect(response.data.total_objects).toBeLessThanOrEqual(Number(queryParams.limit));
        });

        it(`${shopContent} - Check if 'remaining_objects' correctly decrease`, async () => {
            const limit = Math.floor(Math.random() * 3);

            const response$ = doFullSync(jobId, shopContent, limit, {
                timeout: 5000,
            });

            const messages = await lastValueFrom(response$.pipe(toArray()));

            let expectedNextObjectCount = null;

            messages.forEach((response) => {
                if (expectedNextObjectCount !== null && expectedNextObjectCount >= 0) {
                    expect(response.remaining_objects).toEqual(expectedNextObjectCount);
                }

                expectedNextObjectCount = response.remaining_objects - limit;
            });
        });

        it(`${shopContent} - The 'explain_sql' parameters in full sync returns the correct response with the SQL representation`, async () => {
            // Skip for info and themes. There is no sql request for these shop contents
            if (shopContent === "info" || shopContent === "themes") {
                return;
            }

            const queryParams = {
                controller: "apiShopContent",
                shop_content: shopContent,
                job_id: jobId,
                full: "1",
                explain_sql: "1",
            };

            const response = await callPsEventbus<ExplainSqlResponse>(queryParams);

            expect(response.data).toEqual(
                expect.objectContaining({
                    "\x00*\x00query": expect.any(Object),
                    queryStringified: expect.any(String),
                    httpCode: expect.any(Number),
                }),
            );
        });

        it(`${shopContent} - The 'explain_sql' parameters in incremental sync returns the correct response with the SQL representation`, async () => {
            // Skip for info and themes. There is no sql request for these shop contents
            if (shopContent === "info" || shopContent === "themes") {
                return;
            }

            const queryParams = {
                controller: "apiShopContent",
                shop_content: shopContent,
                job_id: jobId,
                full: "0",
                explain_sql: "1",
            };

            // Do a full sync first to define the sync into incremental
            await lastValueFrom(doFullSync(jobId, shopContent, 1000, { timeout: 5000 }));

            const response = await callPsEventbus<ExplainSqlResponse>(queryParams);

            expect(response.data).toEqual(
                expect.objectContaining({
                    "\x00*\x00query": expect.any(Object),
                    queryStringified: expect.any(String),
                    httpCode: expect.any(Number),
                }),
            );
        });
    });
});
