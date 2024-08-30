import fixture from '../fixtures/latest/orders.json'

// test type
const t: Orders[] = fixture;

export type Orders = {
  id: number,
  collection: string,
  properties: {
    conversion_rate: number,
    created_at: string,
    currency: string,
    current_state: number,
    delivery_country_code: string,
    id_carrier: number,
    id_cart: number,
    id_customer: number,
    id_order: number,
    invoice_country_code: string,
    is_paid: boolean,
    is_shipped: number,
    is_validated: number,
    new_customer: boolean,
    payment_mode: string,
    payment_module: string,
    payment_name: string,
    reference: string,
    refund: number,
    refund_tax_excl: number,
    shipping_cost: number,
    status_label: string,
    total_paid_real: string, // TODO check this is the desired behaviour
    total_paid_tax: number,
    total_paid_tax_excl: number,
    total_paid_tax_incl: number,
    updated_at: string
  }
}
