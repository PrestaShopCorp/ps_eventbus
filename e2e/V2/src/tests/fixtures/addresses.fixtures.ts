//@ts-nocheck
import {test as base, expect, test} from '@playwright/test';
import {
  boAddressesPage,
  boAddressesCreatePage,
  boDashboardPage,
  FakerAddress,
} from '@prestashop-core/ui-testing';

type AddressesFixtures = {
  address: FakerAddress;
  createAddress: string;
};

export const addresses = base.extend<AddressesFixtures> ({
  address: {},

  createAddress: async ({page, address}, use) => {

    await test.step('should go to \'Customers > Addresses\' page', async () => {

      await boDashboardPage.goToSubMenu(
        page,
        boDashboardPage.customersParentLink,
        boDashboardPage.addressesLink,
      );
      await boAddressesPage.closeSfToolBar(page);

      const pageTitle = await boAddressesPage.getPageTitle(page);
      expect(pageTitle).toContain(boAddressesPage.pageTitle);
    });

    await test.step('should go to add new address page', async () => {

      await boAddressesPage.goToAddNewAddressPage(page);

      const pageTitle = await boAddressesCreatePage.getPageTitle(page);
      expect(pageTitle).toContain(boAddressesCreatePage.pageTitleCreate);
    });

    await test.step('should create address and check result', async () => {

      const textResult = await boAddressesCreatePage.createEditAddress(page, address);
      expect(textResult).toEqual(boAddressesPage.successfulCreationMessage);
    });

    await use(page)
  }
});
