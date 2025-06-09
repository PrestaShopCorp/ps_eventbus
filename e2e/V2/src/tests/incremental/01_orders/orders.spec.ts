import {test, mergeTests, expect} from '@playwright/test';
// Import fixtures
import {orders} from "@tests-fixtures/orders.fixtures";
import {carriers} from "@tests-fixtures/carriers.fixtures";
import {addresses} from "@tests-fixtures/addresses.fixtures";
import {authentication} from "@tests-fixtures/authentication.fixtures";
import {sync} from "@tests-fixtures/sync.fixtures";
// Import test data
import {customerAddress, carrier, orderToCreate} from "./test.data";
// Shop content
import {shopContentMapping} from "@helpers/shop-contents";
import {runProductsCreator, runShopCreator} from "@helpers/fixtures-generator";
// prisma
import { PrismaClient } from '@prismaClient/prisma'
// Prisma client
const prisma = new PrismaClient();

// Define test data
addresses.use({address: customerAddress});
carriers.use({carrier: carrier});
orders.use({order: orderToCreate});
sync.use({shopContent: [shopContentMapping.orders]})
// Merge fixtures
//const mergedFixtures = mergeTests(sync, authentication, addresses, carriers, orders);
const mergedFixtures = mergeTests(sync);
// Tags
const testTags = ['@incremental', '@orders-incremental'];


mergedFixtures('[INCREMENTAL]', {tag: testTags}, async ({forceFullSync}) => {
/*  await test.step('TEST prisma', async () => {
    const eventbusData = await prisma.ps_eventbus_incremental_sync.findMany({
      where: {
        action: 'upsert'
      },
      take: 10,
    });
    const jobs = await prisma.ps_eventbus_job.findMany({
      take: 10,
    });
    console.log(eventbusData);
    console.log(jobs);

    const config = await prisma.ps_configuration.findMany({
      where: {
        name: 'PS_CARRIER_DEFAULT'
      }
    });
    console.log(config)
    //expect(config[0].id_configuration).toEqual(1);
  });*/

  // TODO // Focus products && orders first
  // TODO quand un shop content est créé / modifié / supprimé?? => check content est dans table live_sync (focus create et update first) (check before and after ??)
  // TODO quand un shop content est créé / modifié / supprimé?? => check entrée + dans incremental (focus create et update first)

  // TODO mise en place probe
  // TODO declencher sync incremental (callPsEventbus) => observer data envoyé de ps_eventbus vers le collector (consulter probe)

  await test.step('Generate new fixtures', async () => {
    ///await runShopCreator({orders: 10});
    await runProductsCreator({products: 10, productsWithCombinations: 5});
  });

  await test.step('Should check shopContent is in live sync table', async () => {
    const liveSyncTableRow = await prisma.ps_eventbus_live_sync.findUnique({
      where: {
        shop_content: 'products'
      }
    });

    console.log(liveSyncTableRow)

    expect(liveSyncTableRow).toMatchObject({shop_content: 'products', last_change_at: expect.any(Date)});
  });
});
