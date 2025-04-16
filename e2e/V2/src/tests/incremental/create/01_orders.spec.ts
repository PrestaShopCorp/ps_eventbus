import {test} from '@playwright/test';
// Import fixtures
import {orders} from "@fixtures/orders.fixtures";



orders('[INCREMENTAL-CREATE] @orders-incremental', async ({create}) => {
  await test.step('trigger incremental sync', async () => {
    console.log('Sync triggered !!!')
  });
});
