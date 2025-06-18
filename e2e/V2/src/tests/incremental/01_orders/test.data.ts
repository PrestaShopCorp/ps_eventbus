import {
  dataCustomers,
  dataOrderStatuses,
  dataPaymentMethods,
  dataProducts,
  dataZones,
  FakerAddress,
  FakerCarrier,
  FakerOrder
} from "@prestashop-core/ui-testing";
import {faker} from "@faker-js/faker";
import {expect} from "@playwright/test";
import {
  getCurrencyById,
  getLastCreatedOrder,
  getStatusLabelNameByOrderState
} from "@helpers/database-helper";
import {format} from "date-fns-tz";
import {toIsoNoColon, toSqlDateTime} from "@helpers/date-format-helper";

const superAddressName = `Eventbus ${faker.word.words({count: 1})}`

export const customerAddress: FakerAddress = new FakerAddress({
  name: superAddressName,
  alias: superAddressName,
  email: 'pub@prestashop.com',
  country: 'United Kingdom'
});

export const carrier: FakerCarrier = new FakerCarrier({
  name: `Eventbus ${faker.word.words({count: 1})}`,
  speedGrade: 7,
  trackingURL: 'https://example.com/track.php?num=@',
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

export async function assertCreatedOrder(createdOrderFromProbe: any) {

  const lastCreatedOrderFromDb = await getLastCreatedOrder();
  const currency = await getCurrencyById(lastCreatedOrderFromDb.id_currency);
  const statusLabel = await getStatusLabelNameByOrderState(lastCreatedOrderFromDb.current_state);

  expect(createdOrderFromProbe).toMatchObject({
    action: 'upsert',
    collection: 'orders',
    properties: {
      id_order: lastCreatedOrderFromDb.id_order,
      reference: lastCreatedOrderFromDb.reference,
      id_customer: lastCreatedOrderFromDb.id_customer,
      id_cart: String(lastCreatedOrderFromDb.id_cart),
      current_state: lastCreatedOrderFromDb.current_state,
      conversion_rate: Number(lastCreatedOrderFromDb.conversion_rate),
      carrier_tax_rate: 0,
      total_paid_tax_excl: Number(lastCreatedOrderFromDb.total_paid_tax_excl),
      total_paid_tax_incl: Number(lastCreatedOrderFromDb.total_paid_tax_incl),
      currency: currency!.iso_code,
      payment_module: 'ps_checkpayment',
      payment_mode: 'Payments by check',
      total_paid_real: lastCreatedOrderFromDb.total_paid_real,
      shipping_cost: 3,
      //created_at: lastCreatedOrderFromDb.date_add,
      created_at: toIsoNoColon(lastCreatedOrderFromDb.date_add),
      updated_at: toIsoNoColon(lastCreatedOrderFromDb.date_upd),
      //updated_at: lastCreatedOrderFromDb.date_upd,
      id_carrier: lastCreatedOrderFromDb.id_carrier,
      payment_name: 'ps_checkpayment',
      is_validated: '1',
      is_paid: true,
      is_shipped: '1',
      status_label: statusLabel,
      id_shop_group: lastCreatedOrderFromDb.id_shop_group,
      id_shop: lastCreatedOrderFromDb.id_shop,
      id_lang: lastCreatedOrderFromDb.id_lang,
      id_currency: 1,
      recyclable: false,
      gift: false,
      total_discounts: Number(lastCreatedOrderFromDb.total_discounts),
      total_discounts_tax_incl: Number(lastCreatedOrderFromDb.total_discounts_tax_incl),
      total_discounts_tax_excl: Number(lastCreatedOrderFromDb.total_discounts_tax_excl),
      total_products: Number(lastCreatedOrderFromDb.total_products),
      total_products_wt: Number(lastCreatedOrderFromDb.total_products_wt),
      total_shipping_tax_incl: Number(lastCreatedOrderFromDb.total_shipping_tax_incl),
      total_wrapping: Number(lastCreatedOrderFromDb.total_wrapping),
      total_wrapping_tax_incl: Number(lastCreatedOrderFromDb.total_wrapping_tax_incl),
      total_wrapping_tax_excl: Number(lastCreatedOrderFromDb.total_wrapping_tax_excl),
      round_mode: lastCreatedOrderFromDb.round_mode,
      round_type: true,
      invoice_number: lastCreatedOrderFromDb.invoice_number,
      delivery_number: lastCreatedOrderFromDb.delivery_number,
      //invoice_date: lastCreatedOrderFromDb.invoice_date,
      invoice_date: toSqlDateTime(lastCreatedOrderFromDb.invoice_date),
      //delivery_date: lastCreatedOrderFromDb.delivery_date,
      delivery_date: toSqlDateTime(lastCreatedOrderFromDb.delivery_date),
      valid: lastCreatedOrderFromDb.valid,
      refund: 0,
      refund_tax_excl: 0,
      new_customer: false,
      total_paid_tax: 0,
      delivery_country_code: 'GB',
      invoice_country_code: 'GB'
    },
  })
}


