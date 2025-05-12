import {test, mergeTests} from '@playwright/test';
// Import fixtures
import {orders} from "@tests-fixtures/orders.fixtures";
import {carriers} from "@tests-fixtures/carriers.fixtures";
import {addresses} from "@tests-fixtures/addresses.fixtures";
import {authentication} from "@tests-fixtures/authentication.fixtures";
// Import test data
import {customerAddress, carrier, order} from "./test.data";
// prisma
import { PrismaClient } from '@prismaClient/prisma'

const prisma = new PrismaClient();

addresses.use({address: customerAddress});
carriers.use({carrier: carrier});
orders.use({order: order});
// Merge fixtures
const mergedFixtures = mergeTests(authentication, addresses, carriers, orders);

mergedFixtures('[INCREMENTAL] @orders-incremental', async ({bo_login, createCarrier, createAddress, createOrder}) => {
  await test.step('trigger incremental sync', async () => {
    console.log('Sync triggered !!!');
    const eventbusData = await prisma.ps_eventbus_incremental_sync.findMany({
      take: 10,
    });
    const jobs = await prisma.ps_eventbus_job.findMany({
      take: 10,
    });
    console.log(eventbusData);
    console.log(jobs);
  });
});
