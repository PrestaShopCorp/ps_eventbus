import fixture from '../fixtures/latest/order_details.json'

// test type
const t: OrderDetails[] = fixture;

export type OrderDetails = {
  id: number,
  collection: string,
  properties: {
    category: number,
    conversion_rate: number,
    currency: string,
    id_order: number,
    id_order_detail: number,
    iso_code: string,
    product_attribute_id: number,
    product_id: number,
    product_quantity: number,
    refund: number,
    refund_tax_excl: number,
    unique_product_id: string,
    unit_price_tax_excl: number,
    unit_price_tax_incl: number
  }
}
