import { callPsEventbus, ExplainSqlResponse } from '@helpers/mock-probe';
import {ShopContent, shopContentList} from '@helpers/shop-contents';
import { generateFakeJobId } from '@helpers/utils';
import {test, expect} from '@playwright/test';

const testTags = ['@sanity', '@query-params-validations', '@explain-sql-incremental'];

const shopContents: ShopContent[] = shopContentList;
let jobId: string;
test.describe('Query params validations', {tag: testTags}, async () => {
  shopContents.forEach((shopContent: ShopContent) => {
    jobId = generateFakeJobId();
    test(`Should check "explain_sql" param in full sync returns the correct response with the SQL representation for ${shopContent.toUpperCase()}`, async () => {
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
    })
  });
});
