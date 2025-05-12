import { lastValueFrom, toArray } from 'rxjs';
import { doFullSync } from '@helpers/mock-probe';
import {ShopContent, shopContentList} from '@helpers/shop-contents';
import { generateFakeJobId } from '@helpers/utils';
import {test, expect} from '@playwright/test';

const testTags = ['@sanity', '@query-params-validations', '@remaining-objects'];

const shopContents: ShopContent[] = shopContentList;
let jobId: string;
test.describe('Query params validation', {tag: testTags}, async () => {
  shopContents.forEach((shopContent: ShopContent) => {
    jobId = generateFakeJobId();
    test(`Should check "remaining_objects" correctly decrease for ${shopContent.toUpperCase()}`, async () => {
      const limit = 2;

      const response$ = doFullSync(jobId, shopContent, limit, { timeout: 5000 });

      const messages = await lastValueFrom(response$.pipe(toArray()));

      let expectedNextObjectCount: null | number = null;

      messages.forEach((response) => {
        if (expectedNextObjectCount !== null && expectedNextObjectCount >= 0) {
          expect(response.remaining_objects).toEqual(expectedNextObjectCount);
        }

        expectedNextObjectCount = response.remaining_objects - limit;
      });
    });
  });
});
