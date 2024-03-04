import fixture from "../fixtures/apiCarts/carts.json"

// test type
const t: Carts[] = fixture;

export type Carts = {
  id: string,
  collection: string,
  properties: {
    id_cart: string,
    created_at: string,
    updated_at: string
  }
}
