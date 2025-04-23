//@ts-nocheck
import {test as base, expect, test} from '@playwright/test';
import {
  boDashboardPage,
  boOrdersPage,
  boOrdersViewBlockProductsPage,
  boLoginPage,
  dataOrderStatuses,
  dataCarriers,
  dataAddresses,
  boOrdersCreatePage,
  FakerOrder,
  dataCustomers,
  dataProducts,
  dataPaymentMethods,
} from '@prestashop-core/ui-testing';

type OrdersFixtures = {
  createOrder: string;
};

const orderToMake: FakerOrder = new FakerOrder({
  customer: dataCustomers.johnDoe,
  products: [
    {
      product: dataProducts.demo_5,
      quantity: 4,
    },
  ],
  deliveryAddress: dataAddresses.address_2,
  invoiceAddress: dataAddresses.address_2,
  deliveryOption: {
    name: `${dataCarriers.clickAndCollect.name} - ${dataCarriers.clickAndCollect.transitName}`,
    freeShipping: true,
  },
  paymentMethod: dataPaymentMethods.checkPayment,
  status: dataOrderStatuses.paymentAccepted,
  totalPrice: (dataProducts.demo_5.priceTaxExcluded * 4) * 1.2, // Price tax included
});

export const orders = base.extend<OrdersFixtures> ({
  createOrder: async ({page}, use) => {

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
      await boOrdersCreatePage.createOrder(page, orderToMake);

      const pageTitle = await boOrdersViewBlockProductsPage.getPageTitle(page);
      expect(pageTitle).toContain(boOrdersViewBlockProductsPage.pageTitle);
    });

    await use(page)
  }
});
