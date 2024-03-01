export type Store =   {
  id: number,
  collection: string,
  properties: {
    id_store: number,
    id_country: number,
    id_state: number,
    city: string,
    postcode: number,
    active: boolean,
    created_at: string,
    updated_at: string,
    id_lang: number,
    name: string,
    address1: string,
    address2: string,
    hours:  string[][],
    id_shop: number
  }
}
