import fixture from "../fixtures/apiCarts/cart_products.json"

// test type
const t: CartProducts[] = fixture;

export type CartProducts =   {
  id: string,
  collection: string,
  properties: {
    id_cart: string,
    id_product: string,
    id_product_attribute: string,
    quantity: number,
    created_at?: string,
    id_cart_product: string
  }
}
