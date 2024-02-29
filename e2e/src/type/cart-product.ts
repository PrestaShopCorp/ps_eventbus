export type Cart_Product =   {
  id: string,
  collection: string,
  properties: {
    id_cart: string,
    id_product: string,
    id_product_attribute: string,
    quantity: number,
    created_at: string,
    id_cart_product: string
  }
}
