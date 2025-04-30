//@ts-nocheck
import {test as base, expect, test} from '@playwright/test';
import {
  boDashboardPage,
  boCarriersPage,
  boCarriersCreatePage,
  FakerCarrier,
  utilsFile
} from '@prestashop-core/ui-testing';

type CarriersFixtures = {
  carrier: FakerCarrier;
  createCarrier: string;
};

export const carriers = base.extend<CarriersFixtures> ({
  carrier: {},

  createCarrier: async ({page, carrier}, use) => {

    // Create images
    await Promise.all([
      utilsFile.generateImage(`${carrier.name}.jpg`),
    ]);

    await test.step('should go to \'Shipping > Carriers\' page', async () => {
      await boDashboardPage.goToSubMenu(
        page,
        boDashboardPage.shippingLink,
        boDashboardPage.carriersLink,
      );

      const pageTitle = await boCarriersPage.getPageTitle(page);
      expect(pageTitle).toContain(boCarriersPage.pageTitle);
    });

    await test.step('should go to add new carrier page', async () => {
      await boCarriersPage.goToAddNewCarrierPage(page);

      const pageTitle = await boCarriersCreatePage.getPageTitle(page);
      expect(pageTitle).toContain(boCarriersCreatePage.pageTitleCreate);
    });

    await test.step('should create carrier and check result', async () => {
      const textResult = await boCarriersCreatePage.createEditCarrier(page, carrier);
      expect(textResult).toContain(boCarriersPage.successfulCreationMessage);
    });

    await use(page)
  }
});
