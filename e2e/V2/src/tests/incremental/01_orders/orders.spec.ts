import {test, mergeTests} from '@playwright/test';
// Import fixtures
import {orders} from "@fixtures/orders.fixtures";
import {carriers} from "@fixtures/carriers.fixtures";
import {addresses} from "@fixtures/addresses.fixtures";
import {authentication} from "@fixtures/authentication.fixtures";
// Import test data
import {customerAddress, carrier, order} from "./test.data";

addresses.use({address: customerAddress});
carriers.use({carrier: carrier});
orders.use({order: order});
// Merge fixtures
const mergedFixtures = mergeTests(authentication, addresses, carriers, orders);

mergedFixtures('[INCREMENTAL] @orders-incremental', async ({bo_login, createCarrier, createAddress, createOrder}) => {
  await test.step('trigger incremental sync', async () => {
    console.log('Sync triggered !!!');
  });
});
