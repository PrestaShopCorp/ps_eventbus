import {test, mergeTests} from '@playwright/test';
// Import fixtures
import {orders} from "@fixtures/orders.fixtures";
import {carriers} from "@fixtures/carriers.fixtures";
import {authentication} from "@fixtures/authentication.fixtures";

// Merge fixtures
const mergedFixtures = mergeTests(authentication, carriers, orders)

mergedFixtures('[INCREMENTAL] @orders-incremental', async ({bo_login, createCarrier, createOrder}) => {
  await test.step('trigger incremental sync', async () => {
    console.log('Sync triggered !!!');
  });
});
