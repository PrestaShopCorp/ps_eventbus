import fixture from '../fixtures/latest/apiProducts/products.json'

// test type
const t: Products[] = fixture;

export type Products = {
  id: string,
  collection: string,
  properties: {
    id_product: number,
    id_manufacturer: number,
    id_supplier: number,
    id_attribute: number,
    is_default_attribute: boolean,
    name: string,
    description: string,
    description_short: string,
    link_rewrite: string,
    default_category: string,
    id_category_default: number,
    reference: string,
    upc: string,
    ean: string,
    condition: string,
    visibility: string,
    active: boolean,
    quantity: number,
    manufacturer: string,
    weight: number,
    price_tax_excl: number,
    created_at: string,
    updated_at: string,
    available_for_order: boolean,
    available_date: string,
    is_bundle: boolean,
    is_virtual: boolean,
    mpn: string,
    width: string, // TODO : wrong cast
    height: string, // TODO : wrong cast
    depth: string, // TODO : wrong cast
    additional_delivery_times: number,
    additional_shipping_cost: string,
    delivery_in_stock: string,
    delivery_out_stock: string,
    isbn: string,
    features: {},
    attributes: {},
    images: string,
    cover: string,
    iso_code: string,
    unique_product_id: string,
    id_product_attribute: string,
    link: string,
    price_tax_incl: number,
    sale_price_tax_excl: number,
    sale_price_tax_incl: number,
    tax: number,
    sale_tax: number,
    category_path: string,
    category_id_path: string
  }
}
