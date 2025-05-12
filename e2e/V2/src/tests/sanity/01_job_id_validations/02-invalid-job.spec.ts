import axios from 'axios';
import { from, lastValueFrom, map, toArray, zip } from 'rxjs';
import { probe } from '@helpers/mock-probe';
import { ShopContent, shopContentList } from '@helpers/shop-contents';
import { generateFakeJobId } from '@helpers/utils';
import {test, expect} from '@playwright/test';
import testConfig from "@helpers/test.config";

const testTags = ['@sanity', '@job-id-validations', '@invalid-job-id'];

const shopContents: ShopContent[] = shopContentList;
let jobId: string;

test.describe('Job ID validations', {tag: testTags}, async () => {

  shopContents.forEach(async (shopContent: ShopContent) => {

    test(`Should return 454 with an invalid job id (sync-api status 454) for ${shopContent.toUpperCase()}`, async () => {
      jobId = generateFakeJobId(false);
      // arrange
      const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=apiShopContent&shop_content=${shopContent}&limit=5&job_id=${jobId}`;
      const message$ = probe({ params: { id: jobId } });

      //act
      const request$ = from(
        axios
          .get(url, {
            headers: { Host: testConfig.prestaShopHostHeader },
          })
          .then((res) => {
            expect(res).toBeNull(); // fail test
          })
          .catch((err) => {
            return err.response;
          })
      );

      const results = await lastValueFrom(
        zip(message$, request$).pipe(
          map((result) => ({
            probeMessage: result[0],
            psEventbusReq: result[1],
          })),
          toArray()
        )
      );

      // assert
      expect(results.length).toEqual(1);
      expect(results[0].probeMessage.method).toBe('GET');
      expect(results[0].probeMessage.url.split('/')).toContain(jobId);
      expect(results[0].psEventbusReq.status).toEqual(454);
      expect(results[0].psEventbusReq.headers).toMatchObject({
        'content-type': /json/,
      });
      expect(results[0].psEventbusReq.data).toMatchObject({
        status: false,
        httpCode: 454,
      });
    });
  });
});
