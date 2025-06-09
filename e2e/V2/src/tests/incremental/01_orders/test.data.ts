import {
  dataAddresses,
  dataCustomers, dataOrderStatuses, dataPaymentMethods,
  dataProducts,
  dataZones,
  FakerAddress,
  FakerCarrier,
  FakerOrder
} from "@prestashop-core/ui-testing";
import {faker} from "@faker-js/faker";
import { PrismaClient } from "@prismaClient/prisma";
// Prisma client
const prisma = new PrismaClient();

const superAddressName = `Eventbus ${faker.word.words({count: 1})}`

export const customerAddress: FakerAddress = new FakerAddress({
  name: superAddressName,
  alias: superAddressName,
  email: 'pub@prestashop.com',
  country: 'United Kingdom'
});

export const carrier: FakerCarrier = new FakerCarrier({
  // General settings
  name: `Eventbus ${faker.word.words({count: 1})}`,
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
          zone: dataZones.europeNonEu,
          price: 3,
        },
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
          zone: dataZones.europeNonEu,
          price: 6,
        },
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
          zone: dataZones.europeNonEu,
          price: 9,
        },
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

export const orderToCreate: FakerOrder = new FakerOrder({
  customer: dataCustomers.johnDoe,
  products: [
    {
      product: dataProducts.demo_5,
      quantity: 4,
    },
  ],
  deliveryAddress: customerAddress,
  invoiceAddress: customerAddress,
  deliveryOption: {
    name: `${carrier.name} - ${carrier.transitName}`,
    freeShipping: true,
  },
  paymentMethod: dataPaymentMethods.checkPayment,
  status: dataOrderStatuses.delivered,
  totalPrice: (dataProducts.demo_5.priceTaxExcluded * 4) * 1.2, // Price tax included
});


export async function generateOrderAssertData() {
  const lastCreatedOrder = await prisma.ps_orders.findMany({
    orderBy: {
      date_add: 'desc'
    },
    take: 1,
  });

  const currency = await prisma.ps_currency.findUnique({
    where: { id_currency: lastCreatedOrder[0].id_currency }
  });

  const orderState = await prisma.ps_order_state.findUnique({
    where: { id_order_state: lastCreatedOrder[0].current_state }
  });

// Si tu veux le label :
  const statusLabel = await prisma.ps_order_state_lang.findFirst({
    where: { id_order_state: lastCreatedOrder[0].current_state }
  });
  return {
    action: 'upsert',
    collection: 'orders',
    properties: {
      id_order: lastCreatedOrder[0].id_order,
      reference: lastCreatedOrder[0].reference,
      id_customer: dataCustomers.johnDoe.id,
      id_cart: lastCreatedOrder[0].id_cart,
      current_state: lastCreatedOrder[0].current_state,
      conversion_rate: lastCreatedOrder[0].conversion_rate,
      total_paid_tax_excl: lastCreatedOrder[0].total_paid_tax_excl,
      total_paid_tax_incl: lastCreatedOrder[0].total_paid_tax_incl,
      currency: 'EUR',
      payment_module: 'ps_checkpayment',
      payment_mode: 'Payments by check',
      total_paid_real: lastCreatedOrder[0].total_paid_real,
      shipping_cost: 3,
      created_at: lastCreatedOrder[0].date_add,
      updated_at: lastCreatedOrder[0].date_upd,
      id_carrier: lastCreatedOrder[0].id_carrier,
      payment_name: 'ps_checkpayment',
      is_validated: '1',
      is_paid: true,
      is_shipped: '1',
      status_label: 'Delivered',
      id_shop_group: 1,
      id_shop: 1,
      id_lang: 1,
      id_currency: 1,
      recyclable: false,
      gift: false,
      total_discounts: lastCreatedOrder[0].total_discounts,
      total_discounts_tax_incl: lastCreatedOrder[0].total_discounts_tax_incl,
      total_discounts_tax_excl: lastCreatedOrder[0].total_discounts_tax_excl,
      total_products: lastCreatedOrder[0].total_products,
      total_products_wt: lastCreatedOrder[0].total_products_wt,
      total_shipping_tax_incl: lastCreatedOrder[0].total_shipping_tax_incl,
      total_wrapping: lastCreatedOrder[0].total_wrapping,
      total_wrapping_tax_incl: lastCreatedOrder[0].total_wrapping_tax_incl,
      total_wrapping_tax_excl: lastCreatedOrder[0].total_wrapping_tax_excl,
      round_mode: lastCreatedOrder[0].round_mode,
      round_type: lastCreatedOrder[0].round_type,
      invoice_number: lastCreatedOrder[0].invoice_number,
      delivery_number: lastCreatedOrder[0].delivery_number,
      invoice_date: lastCreatedOrder[0].invoice_date,
      delivery_date: lastCreatedOrder[0].delivery_date,
      valid: true,
      refund: 0,
      refund_tax_excl: 0,
      new_customer: false,
      total_paid_tax: 0,
      delivery_country_code: 'GB',
      invoice_country_code: 'GB'
    }
  }
}


