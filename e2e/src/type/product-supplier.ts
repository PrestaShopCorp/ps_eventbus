export type Product_supplier = {
  id: number,
  collection: string,
  properties: {
    id_product_supplier: number,
    id_product: number,
    id_product_attribute: number,
    id_supplier: number,
    product_supplier_reference: string,
    product_supplier_price_te: number,
    id_currency: number
  }
}
