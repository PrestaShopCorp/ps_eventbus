import {Order} from '../type/order';
import {Order_detail} from '../type/order-detail';
import {OrderStatusHistory} from "../type/order-status-history";
export const order_full: Order[] = [
  {
    id: 1,
    collection: 'orders',
    properties: {
      conversion_rate: 1,
      created_at: '2024-02-19T12:12:12+0100',
      currency: 'EUR',
      current_state: 6,
      delivery_country_code: 'US',
      id_carrier: 2,
      id_cart: 1,
      id_customer: 2,
      id_order: 1,
      invoice_country_code: 'US',
      is_paid: false,
      is_shipped: 0,
      is_validated: 0,
      new_customer: true,
      payment_mode: 'Payment by check',
      payment_module: 'ps_checkpayment',
      payment_name: 'ps_checkpayment',
      reference: 'XKBKNABJK',
      refund: 0,
      refund_tax_excl: 0,
      shipping_cost: 7,
      status_label: 'Canceled',
      total_paid_real: 0.000000,
      total_paid_tax: 1.4000000000000057,
      total_paid_tax_excl: 66.8,
      total_paid_tax_incl: 68.2,
      updated_at: '2024-02-19T12:12:12+0100'
    }
  },
{
  id: 2,
    collection: 'orders',
  properties: {
    conversion_rate: 1,
    created_at: '2024-02-19T12:12:12+0100',
    currency: 'EUR',
    current_state: 1,
    delivery_country_code: 'US',
    id_carrier: 2,
    id_cart: 2,
    id_customer: 2,
    id_order: 2,
    invoice_country_code: 'US',
    is_paid: false,
    is_shipped: 0,
    is_validated: 0,
    new_customer: false,
    payment_mode: 'Payment by check',
    payment_module: 'ps_checkpayment',
    payment_name: 'ps_checkpayment',
    reference: 'OHSATSERP',
    refund: 0,
    refund_tax_excl: 0,
    shipping_cost: 0,
    status_label: 'Awaiting check payment',
    total_paid_real: 0.000000,
    total_paid_tax: 0,
    total_paid_tax_excl: 169.9,
    total_paid_tax_incl: 169.9,
    updated_at: '2024-02-19T12:12:12+0100'
  }
},
{
  id: 3,
    collection: 'orders',
  properties: {
    conversion_rate: 1,
    created_at: '2024-02-19T12:12:12+0100',
    currency: 'EUR',
    current_state: 8,
    delivery_country_code: 'US',
    id_carrier: 2,
    id_cart: 3,
    id_customer: 2,
    id_order: 3,
    invoice_country_code: 'US',
    is_paid: false,
    is_shipped: 0,
    is_validated: 0,
    new_customer: false,
    payment_mode: 'Payment by check',
    payment_module: 'ps_checkpayment',
    payment_name: 'ps_checkpayment',
    reference: 'UOYEVOLI',
    refund: 0,
    refund_tax_excl: 0,
    shipping_cost: 7,
    status_label: 'Payment error',
    total_paid_real: 0.000000,
    total_paid_tax: 1.4000000000000021,
    total_paid_tax_excl: 19.9,
    total_paid_tax_incl: 21.3,
    updated_at: '2024-02-19T12:12:12+0100'
  }
},
{
  id: 4,
    collection: 'orders',
  properties: {
    conversion_rate: 1,
    created_at: '2024-02-19T12:12:12+0100',
    currency: 'EUR',
    current_state: 1,
    delivery_country_code: 'US',
    id_carrier: 2,
    id_cart: 4,
    id_customer: 2,
    id_order: 4,
    invoice_country_code: 'US',
    is_paid: false,
    is_shipped: 0,
    is_validated: 0,
    new_customer: false,
    payment_mode: 'Payment by check',
    payment_module: 'ps_checkpayment',
    payment_name: 'ps_checkpayment',
    reference: 'FFATNOMMJ',
    refund: 0,
    refund_tax_excl: 0,
    shipping_cost: 7,
    status_label: 'Awaiting check payment',
    total_paid_real: 0.000000,
    total_paid_tax: 1.4000000000000021,
    total_paid_tax_excl: 19.9,
    total_paid_tax_incl: 21.3,
    updated_at: '2024-02-19T12:12:12+0100'
  }
},
{
  id: 5,
    collection: 'orders',
  properties: {
    conversion_rate: 1,
    created_at: '2024-02-19T12:12:12+0100',
    currency: 'EUR',
    current_state: 10,
    delivery_country_code: 'US',
    id_carrier: 2,
    id_cart: 5,
    id_customer: 2,
    id_order: 5,
    invoice_country_code: 'US',
    is_paid: false,
    is_shipped: 0,
    is_validated: 0,
    new_customer: false,
    payment_mode: 'Bank wire',
    payment_module: 'ps_wirepayment',
    payment_name: 'ps_wirepayment',
    reference: 'KHWLILZLL',
    refund: 0,
    refund_tax_excl: 0,
    shipping_cost: 7,
    status_label: 'Awaiting bank wire payment',
    total_paid_real: 0.000000,
    total_paid_tax: 1.4000000000000021,
    total_paid_tax_excl: 25.9,
    total_paid_tax_incl: 27.3,
    updated_at: '2024-02-19T12:12:12+0100'
  }
},

  ]
export const orders_details_full: Order_detail[] = [
  {
    id: 1,
    collection: 'order_details',
    properties: {
      category: 4,
      conversion_rate: 1,
      currency: 'EUR',
      id_order: 1,
      id_order_detail: 1,
      iso_code: 'en',
      product_attribute_id: 1,
      product_id: 1,
      product_quantity: 1,
      refund: 0,
      refund_tax_excl: 0,
      unique_product_id: '1-1-en',
      unit_price_tax_excl: 23.9,
      unit_price_tax_incl: 23.9
    }
  },
  {
    id: 2,
    collection: 'order_details',
    properties: {
      category: 5,
      conversion_rate: 1,
      currency: 'EUR',
      id_order: 1,
      id_order_detail: 2,
      iso_code: 'en',
      product_attribute_id: 9,
      product_id: 2,
      product_quantity: 1,
      refund: 0,
      refund_tax_excl: 0,
      unique_product_id: '2-9-en',
      unit_price_tax_excl: 35.9,
      unit_price_tax_incl: 35.9
    }
  },
  {
    id: 3,
    collection: 'order_details',
    properties: {
      category: 9,
      conversion_rate: 1,
      currency: 'EUR',
      id_order: 2,
      id_order_detail: 3,
      iso_code: 'en',
      product_attribute_id: 18,
      product_id: 4,
      product_quantity: 2,
      refund: 0,
      refund_tax_excl: 0,
      unique_product_id: '4-18-en',
      unit_price_tax_excl: 79,
      unit_price_tax_incl: 79
    }
  },
  {
    id: 4,
    collection: 'order_details',
    properties: {
      category: 8,
      conversion_rate: 1,
      currency: 'EUR',
      id_order: 2,
      id_order_detail: 4,
      iso_code: 'en',
      product_attribute_id: 0,
      product_id: 8,
      product_quantity: 1,
      refund: 0,
      refund_tax_excl: 0,
      unique_product_id: '8-0-en',
      unit_price_tax_excl: 11.9,
      unit_price_tax_incl: 11.9
    }
  },
  {
    id: 5,
    collection: 'order_details',
    properties: {
      category: 7,
      conversion_rate: 1,
      currency: 'EUR',
      id_order: 3,
      id_order_detail: 5,
      iso_code: 'en',
      product_attribute_id: 28,
      product_id: 16,
      product_quantity: 1,
      refund: 0,
      refund_tax_excl: 0,
      unique_product_id: '16-28-en',
      unit_price_tax_excl: 12.9,
      unit_price_tax_incl: 12.9
    }
  },
  {
    id: 6,
    collection: 'order_details',
    properties: {
      category: 7,
      conversion_rate: 1,
      currency: 'EUR',
      id_order: 4,
      id_order_detail: 6,
      iso_code: 'en',
      product_attribute_id: 29,
      product_id: 16,
      product_quantity: 1,
      refund: 0,
      refund_tax_excl: 0,
      unique_product_id: '16-29-en',
      unit_price_tax_excl: 12.9,
      unit_price_tax_incl: 12.9
    }
  },
  {
    id: 7,
    collection: 'order_details',
    properties: {
      category: 8,
      conversion_rate: 1,
      currency: 'EUR',
      id_order: 5,
      id_order_detail: 7,
      iso_code: 'en',
      product_attribute_id: 25,
      product_id: 10,
      product_quantity: 1,
      refund: 0,
      refund_tax_excl: 0,
      unique_product_id: '10-25-en',
      unit_price_tax_excl: 18.9,
      unit_price_tax_incl: 18.9
    }
  }
]

export const order_status_history_full: OrderStatusHistory[] = [
  {
  id: 1,
  collection: 'order_status_history',
  properties: {
    created_at: '2024-02-19T12:12:12+0100',
    date_add: '2024-02-19T12:12:12+01:00',
    id_order: 1,
    id_order_history: 1,
    id_order_state: 1,
    is_deleted: false,
    is_delivered: false,
    is_paid: false,
    is_shipped: false,
    is_validated: false,
    name: 'Awaiting check payment',
    template: 'cheque',
    updated_at: '2024-02-19T12:12:12+0100'
  }
  },
{
  id: 2,
    collection: 'order_status_history',
  properties: {
    created_at: '2024-02-19T12:12:12+0100',
    date_add: '2024-02-19T12:12:12+01:00',
    id_order: 2,
    id_order_history: 2,
    id_order_state: 1,
    is_deleted: false,
    is_delivered: false,
    is_paid: false,
    is_shipped: false,
    is_validated: false,
    name: 'Awaiting check payment',
    template: 'cheque',
    updated_at: '2024-02-19T12:12:12+0100'
  }
},
{
  id: 3,
    collection: 'order_status_history',
  properties: {
    created_at: '2024-02-19T12:12:12+0100',
    date_add: '2024-02-19T12:12:12+01:00',
    id_order: 3,
    id_order_history: 3,
    id_order_state: 1,
    is_deleted: false,
    is_delivered: false,
    is_paid: false,
    is_shipped: false,
    is_validated: false,
    name: 'Awaiting check payment',
    template: 'cheque',
    updated_at: '2024-02-19T12:12:12+0100'
  }
},
{
  id: 4,
    collection: 'order_status_history',
  properties: {
    created_at: '2024-02-19T12:12:12+0100',
    date_add: '2024-02-19T12:12:12+01:00',
    id_order: 4,
    id_order_history: 4,
    id_order_state: 1,
    is_deleted: false,
    is_delivered: false,
    is_paid: false,
    is_shipped: false,
    is_validated: false,
    name: 'Awaiting check payment',
    template: 'cheque',
    updated_at: '2024-02-19T12:12:12+0100'
  }
},
{
  id: 5,
    collection: 'order_status_history',
  properties: {
    created_at: '2024-02-19T12:12:12+0100',
    date_add: '2024-02-19T12:12:12+01:00',
    id_order: 5,
    id_order_history: 5,
    id_order_state: 10,
    is_deleted: false,
    is_delivered: false,
    is_paid: false,
    is_shipped: false,
    is_validated: false,
    name: 'Awaiting bank wire payment',
    template: 'bankwire',
    updated_at: '2024-02-19T12:12:12+0100'
  }
},
{
  id: 6,
    collection: 'order_status_history',
  properties: {
    created_at: '2024-02-19T12:12:12+0100',
    date_add: '2024-02-19T12:12:12+01:00',
    id_order: 1,
    id_order_history: 6,
    id_order_state: 6,
    is_deleted: false,
    is_delivered: false,
    is_paid: false,
    is_shipped: false,
    is_validated: false,
    name: 'Canceled',
    template: 'order_canceled',
    updated_at: '2024-02-19T12:12:12+0100'
  }
},
{
  id: 7,
    collection: 'order_status_history',
  properties: {
    created_at: '2024-02-19T12:12:12+0100',
    date_add: '2024-02-19T12:12:12+01:00',
    id_order: 3,
    id_order_history: 7,
    id_order_state: 8,
    is_deleted: false,
    is_delivered: false,
    is_paid: false,
    is_shipped: false,
    is_validated: false,
    name: 'Payment error',
    template: 'payment_error',
    updated_at: '2024-02-19T12:12:12+0100'
  }
}
]
