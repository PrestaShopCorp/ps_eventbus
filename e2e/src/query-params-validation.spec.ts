import { lastValueFrom, toArray } from 'rxjs';
import { callPsEventbus, doFullSync, ExplainSqlResponse, PsEventbusSyncResponse } from './helpers/mock-probe';
import { shopContentList } from './helpers/shop-contents';
import { generateFakeJobId } from './helpers/utils';

describe('Query param validation', () => {
    let jobId: string;

    beforeEach(() => {
        jobId = generateFakeJobId();
    });

    const kebabToSnake = (str) => str.replace(/-/g, '_');

    describe.each(shopContentList)('%s', (shopContent) => {
        it(`${shopContent} - Test 'job_id', 'shop_content' and 'limit' query params`, async () => {
            const queryParams = {
                controller: 'apiShopContent',
                shop_content: shopContent,
                job_id: jobId,
                limit: (Math.floor(Math.random() * 100) + 1).toString(),
            };

            const response = await callPsEventbus<PsEventbusSyncResponse>(queryParams);

            const expectedKeys = [
                'job_id',
                'object_type',
                'syncType',
                'total_objects',
                'has_remaining_objects',
                'execution_time_in_seconds',
                'remaining_objects',
                'md5',
                'httpCode',
                // Clés facultatives, présentens que lorsqu'il y a upload de data
                'body',
                'upload_url',
                'status',
            ];

            // Vérifier que les clés de response.data sont strictement contenues dans expectedKeys
            expect(Object.keys(response.data).sort()).toStrictEqual(
                Object.keys(response.data)
                    .filter((key) => expectedKeys.includes(key))
                    .sort()
            );

            // Vérifier que les propriétés requises sont bien présentes avec leurs types attendus
            expect(response.data).toMatchObject({
                job_id: queryParams.job_id,
                object_type: expect.any(String),
                syncType: expect.any(String),
                total_objects: expect.any(Number),
                execution_time_in_seconds: expect.any(Number),
                has_remaining_objects: expect.any(Boolean),
                remaining_objects: expect.any(Number),
                md5: expect.any(String),
                httpCode: expect.any(Number),
            });

            expect(response.data.job_id).toEqual(queryParams.job_id);
            expect(response.data.object_type).toEqual(kebabToSnake(shopContent));
            expect(response.data.total_objects).toBeLessThanOrEqual(Number(queryParams.limit));
            expect([200, 201]).toContain(response.data.httpCode);
        });

        it(`${shopContent} - Check if 'remaining_objects' correctly decrease`, async () => {
            const limit = 2;

            const response$ = doFullSync(jobId, shopContent, limit, { timeout: 5000 });

            const messages = await lastValueFrom(response$.pipe(toArray()));

            let expectedNextObjectCount = null;

            messages.forEach((response) => {
                if (expectedNextObjectCount !== null && expectedNextObjectCount >= 0) {
                    expect(response.remaining_objects).toEqual(expectedNextObjectCount);
                }

                expectedNextObjectCount = response.remaining_objects - limit;
            });
        }, 30000);

        it(`${shopContent} - The 'explain_sql' parameters in full sync returns the correct response with the SQL representation`, async () => {
            // Skip for info and themes. There is no sql request for these shop contents
            if (shopContent === 'info' || shopContent === 'themes') {
                return;
            }

            const queryParams = {
                controller: 'apiShopContent',
                shop_content: shopContent,
                job_id: jobId,
                full: '1',
                explain_sql: '1',
            };

            const response = await callPsEventbus<ExplainSqlResponse>(queryParams);

            expect(response.data).toStrictEqual({
                '\x00*\x00query': expect.any(Object),
                queryStringified: expect.any(String),
                httpCode: 200,
            });
        });

        it(`${shopContent} - The 'explain_sql' parameters in incremental sync returns the correct response with the SQL representation`, async () => {
            // Skip for info and themes. There is no sql request for these shop contents
            if (shopContent === 'info' || shopContent === 'themes') {
                return;
            }

            const queryParams = {
                controller: 'apiShopContent',
                shop_content: shopContent,
                job_id: jobId,
                full: '0',
                explain_sql: '1',
            };

            // Do a full sync first to define the sync into incremental
            await lastValueFrom(doFullSync(jobId, shopContent, 1000, { timeout: 5000 }));

            const response = await callPsEventbus<ExplainSqlResponse>(queryParams);

            expect(response.data).toStrictEqual({
                '\x00*\x00query': expect.objectContaining({
                    where: expect.arrayContaining([expect.stringContaining("IN('-1')")]),
                }),
                queryStringified: expect.any(String),
                httpCode: 200,
            });
        });
    });
});
