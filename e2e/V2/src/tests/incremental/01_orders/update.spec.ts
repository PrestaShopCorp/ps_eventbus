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
import {
  assertCreatedOrder,
  carrier,
  customerAddress,
  orderToCreate
} from "./test.data";
import {authentication} from "@tests-fixtures/authentication.fixtures";
import {
  boOrdersViewBasePage,
  boOrdersViewBlockProductsPage,
  boOrdersViewBlockTabListPage,
  dataOrderStatuses
} from "@prestashop-core/ui-testing";

// Pass required datas to fixtures
sync.use({shopContent: ['orders', 'carriers']});
addresses.use({address: customerAddress});
carriers.use({carrier: carrier});
orders.use({order: orderToCreate});
// Prisma client
const prisma = new PrismaClient();
// Merge fixtures
const mergedFixtures = mergeTests(sync, authentication, addresses, carriers, orders);
// Test infos (tags and title)
const testTags = ['@incremental', '@orders-incremental', '@orders-incremental-update'];
const testTitle = `${colorText('[INCREMENTAL]', ["bold", "cyan", "italic"])} ==> ORDER UPDATE`;
// Test variables
const jobId = generateFakeJobId();
const messages$: MockProbeResponse[] = [];

mergedFixtures(testTitle, {tag: testTags}, async ({forceFullSync, bo_login, createCarrier, createAddress, createOrder, page}) => {

  // TEST STEPS

  await test.step('Collect eventbus_incremental_sync table content BEFORE update & sync', async () => {
    const incrementalSyncTableBefore = await prisma.ps_eventbus_incremental_sync.findMany({
      where: {
        type: 'orders',
        action: 'upsert'
      }
    });
    console.table(incrementalSyncTableBefore);
    // TODO ici quoi vérifier dans la table ??
  });

  await test.step('Update created order', async () => {
    await page.waitForTimeout(5000);
    await boOrdersViewBlockProductsPage.deleteDiscount(page);
  });


  await test.step('Collect eventbus_incremental_sync table content BEFORE update & sync', async () => {
    const incrementalSyncTableBefore = await prisma.ps_eventbus_incremental_sync.findMany({
      where: {
        type: 'orders',
        action: 'upsert'
      }
    });
    console.table(incrementalSyncTableBefore);
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

    // trigger sync
    await callPsEventbus(queryParams);

    const updatedOrderFromProbe = messages$[0].body.file;

    await assertCreatedOrder(updatedOrderFromProbe[0]);
  });

  // Récupération du contenu de la table incremental (orders / upsert) apres la sync (expect empty about orders)
  await test.step('Collect and check eventbus_incremental_sync table AFTER sync', async () => {
    const incrementalSyncTableAfter = await prisma.ps_eventbus_incremental_sync.findMany({
      where: {
        type: 'orders',
      }
    });
    console.table(incrementalSyncTableAfter);
    expect(incrementalSyncTableAfter.length).toEqual(0);
  });
});
