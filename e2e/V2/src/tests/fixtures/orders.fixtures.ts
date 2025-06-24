//@ts-nocheck
import {test as base, expect, test} from '@playwright/test';
import {
  boDashboardPage,
  boOrdersPage,
  boOrdersViewBlockProductsPage,
  boOrdersCreatePage,
  FakerOrder,
} from '@prestashop-core/ui-testing';

type OrdersFixtures = {
  order: FakerOrder;
  createOrder: string;
};

export const orders = base.extend<OrdersFixtures> ({
  order: {},

  createOrder: async ({page, order}, use) => {

    await test.step('should go to \'Orders > Orders\' page', async () => {
      await boDashboardPage.goToSubMenu(
        page,
        boDashboardPage.ordersParentLink,
        boDashboardPage.ordersLink,
      );
      await boOrdersPage.closeSfToolBar(page);

      const pageTitle = await boOrdersPage.getPageTitle(page);
      expect(pageTitle).toContain(boOrdersPage.pageTitle);
    });

    await test.step('should create the order', async () => {
      await boOrdersPage.goToCreateOrderPage(page);
      await boOrdersCreatePage.createOrder(page, order);

      const pageTitle = await boOrdersViewBlockProductsPage.getPageTitle(page);
      expect(pageTitle).toContain(boOrdersViewBlockProductsPage.pageTitle);
    });

    await use(page)
  }
});
