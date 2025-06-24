import { lastValueFrom } from 'rxjs';
import { callPsEventbus, doFullSync, ExplainSqlResponse } from '@helpers/mock-probe';
import {ShopContent, shopContentList} from '@helpers/shop-contents';
import { generateFakeJobId } from '@helpers/utils';
import {test, expect} from '@playwright/test';

const testTags = ['@sanity', '@query-params-validations', '@explain-sql-incremental'];

const shopContents: ShopContent[] = shopContentList;
let jobId: string;
test.describe('Query params validations', {tag: testTags}, async () => {
    shopContents.forEach((shopContent: ShopContent) => {
      jobId = generateFakeJobId();
      test(`Should check "explain_sql" param in incremental sync returns the correct response with the SQL representation for ${shopContent.toUpperCase()}`, async () => {
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
