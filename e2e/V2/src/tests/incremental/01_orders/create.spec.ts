import {expect, mergeTests, test} from '@playwright/test';
// prisma
import { PrismaClient } from '@prismaClient/prisma';
// Fixtures
import {sync} from "@tests-fixtures/sync.fixtures";
// Helpers
import {callPsEventbus, MockProbeResponse, probe} from "@helpers/mock-probe";
import {colorText, generateFakeJobId} from "@helpers/utils";
import {carriers} from "@tests-fixtures/carriers.fixtures";
import {addresses} from "@tests-fixtures/addresses.fixtures";
import {orders} from "@tests-fixtures/orders.fixtures";
import {carrier, customerAddress, generateOrderAssertData, orderToCreate} from "./test.data";
import {authentication} from "@tests-fixtures/authentication.fixtures";

// Pass required datas to fixtures
sync.use({shopContent: ['orders']});
addresses.use({address: customerAddress});
carriers.use({carrier: carrier});
orders.use({order: orderToCreate});
// Prisma client
const prisma = new PrismaClient();
// Merge fixtures
const mergedFixtures = mergeTests(sync, authentication, addresses, carriers, orders);
// Test infos (tags and title)
const testTags = ['@incremental', '@orders-incremental', '@orders-incremental-create'];
const testTitle = `${colorText('[INCREMENTAL]', ["bold", "cyan", "italic"])} ==> ORDER CREATE`;
// Test variables
let incrementalSyncTableBefore;
let liveSyncTableAfter;
let incrementalTableAfter;
const jobId = generateFakeJobId();
const messages$: MockProbeResponse[] = [];

mergedFixtures(testTitle, {tag: testTags}, async ({forceFullSync, bo_login, createCarrier, createAddress, createOrder}) => {

  // TEST STEPS
  // Collect live_sync_table
  // Collect incremental_sync_table before sync
  // launch probe
  // Trigger incremental sync
  // Check probe results
  // Collect incremental_sync_table after sync

  // Récupération du contenu de la table live sync apres création de contenu (faut-il le faire avant ?? check que c'est vide et donc une fixture ??)
  await test.step('Collect eventbus_live_sync table content AFTER content creation', async () => {
    liveSyncTableAfter = await prisma.ps_eventbus_live_sync.findUnique({
      where: {
        shop_content: 'orders'
      }
    });
    expect(liveSyncTableAfter).toMatchObject({
      shop_content: 'orders',
      // TODO ici voir si possible de tester autrement ??
      last_change_at: expect.any(Date),
    })
  });

  // Récupération du contenu de la table incremental (orders / upsert) avant la sync
  await test.step('Collect eventbus_incremental_sync table content BEFORE sync', async () => {
    incrementalSyncTableBefore = await prisma.ps_eventbus_incremental_sync.findMany({
      where: {
        type: 'orders',
        action: 'upsert'
      }
    });
    //console.log(incrementalSyncTableBefore);
    // TODO ici quoi vérifier dans la table ??
  });



  // Subscribe websocket and trigger sync
  await test.step('Trigger incremental sync for ORDERS', async () => {

    // Start probe listening
    probe({ url: `/upload/${jobId}` }, { timeout: 4000 }).subscribe((msg) => {
      messages$.push(msg);
    });

    const queryParams = {
      controller: 'apiShopContent',
      shop_content: 'orders',
      job_id: jobId,
      full: '0',
      explain_sql: '0',
    };

    const response = await callPsEventbus(queryParams);
    console.log(response)

    const createdOrder = messages$[0].body.file;
    const assertionData = await generateOrderAssertData();

    expect(createdOrder).toMatchObject(assertionData);
    //expect(messages$[0].body.file).toMatchObject(orderForAssert);

/*    messages$.forEach((message) => {
      const toCheck = message.body.file
      console.log(toCheck);
    });*/

/*    const orders = await prisma.ps_orders.findMany();
    console.log(orders[0]);*/
  });

  // Récupération du contenu de la table incremental (orders / upsert) apres la sync (expect empty)
  await test.step('Collect and check eventbus_incremental_sync table AFTER sync', async () => {
    const incrementalSyncTableAfter = await prisma.ps_eventbus_incremental_sync.findMany({
      where: {
        type: 'orders',
        action: 'upsert'
      }
    });
    expect(incrementalSyncTableAfter.length).toEqual(0);
  });
});
