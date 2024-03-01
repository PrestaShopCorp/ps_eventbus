export type Bundle =   {
  id: number,
  collection: string,
  properties: {
    id_bundle: number,
    id_product: number,
    id_product_attribute: number,
    unique_product_id: string,
    quantity: number
  }
}
