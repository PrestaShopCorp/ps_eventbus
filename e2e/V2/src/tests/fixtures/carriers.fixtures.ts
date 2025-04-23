//@ts-nocheck
import {test as base, expect, test} from '@playwright/test';
import {
  boDashboardPage,
  boLoginPage,
  boCarriersPage,
  boCarriersCreatePage,
  FakerCarrier,
  dataZones,
  utilsFile
} from '@prestashop-core/ui-testing';

type CarriersFixtures = {
  createCarrier: string;
};


const createCarrierData: FakerCarrier = new FakerCarrier({
  // General settings
  name: 'Eventbus Carrier',
  speedGrade: 7,
  trackingURL: 'https://example.com/track.php?num=@',
  // Shipping locations and cost
  handlingCosts: false,
  freeShipping: false,
  billing: 'According to total weight',
  taxRule: 'No tax',
  outOfRangeBehavior: 'Apply the cost of the highest defined range',
  ranges: [
    {
      weightMin: 0,
      weightMax: 5,
      zones: [
        {
          zone: dataZones.europe,
          price: 5,
        },
        {
          zone: dataZones.northAmerica,
          price: 2,
        },
      ],
    },
    {
      weightMin: 5,
      weightMax: 10,
      zones: [
        {
          zone: dataZones.europe,
          price: 10,
        },
        {
          zone: dataZones.northAmerica,
          price: 4,
        },
      ],
    },
    {
      weightMin: 10,
      weightMax: 20,
      zones: [
        {
          zone: dataZones.europe,
          price: 20,
        },
        {
          zone: dataZones.northAmerica,
          price: 8,
        },
      ],
    },
  ],
  // Size weight and group access
  maxWidth: 200,
  maxHeight: 200,
  maxDepth: 200,
  maxWeight: 500,
  enable: true,
});

export const carriers = base.extend<CarriersFixtures> ({
  createCarrier: async ({page}, use) => {

    // Create images
    await Promise.all([
      utilsFile.generateImage(`${createCarrierData.name}.jpg`),
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
      const textResult = await boCarriersCreatePage.createEditCarrier(page, createCarrierData);
      expect(textResult).toContain(boCarriersPage.successfulCreationMessage);
    });

    await use(page)
  }
});
