import fixture from '../fixtures/latest/stores.json'

// test type
const t: Stores[] = fixture;

export type Stores = {
  id: number,
  collection: string,
  properties: {
    id_store: number,
    id_country: number,
    id_state: number,
    city: string,
    postcode: string,
    active: boolean,
    created_at: string,
    updated_at: string,
    id_lang: number,
    name: string,
    address1: string,
    address2: string,
    hours: string, // TODO : actually json array inside a string -> transition to a nested array ?
    id_shop: number
  }
}
