import { callPsEventbus, PsEventbusSyncResponse } from '@helpers/mock-probe';
import {ShopContent, shopContentList} from '@helpers/shop-contents';
import { generateFakeJobId } from '@helpers/utils';
import {test, expect} from '@playwright/test';

const testTags = ['@sanity', '@query-params-validations', '@query-params'];

const shopContents: ShopContent[] = shopContentList;
const kebabToSnake = (str: string) => str.replace(/-/g, '_');
let jobId: string;

test.describe('Query params validation', {tag: testTags}, async () => {
    shopContents.forEach((shopContent: ShopContent) => {
      test(`Should check "job_id", "shop_content" and "limit" query params for ${shopContent.toUpperCase()}`, async () => {

        jobId = generateFakeJobId();

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
    });
});
