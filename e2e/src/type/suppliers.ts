import fixture from '../fixtures/latest/suppliers.json'

// test type
const t: Suppliers[] = fixture;

export type Suppliers = {
  id: number,
  collection: string,
  properties: {
    id_supplier: number,
    name: string,
    created_at: string,
    updated_at: string,
    active: boolean,
    id_lang: number,
    description: string,
    meta_title: string,
    meta_keywords: string,
    meta_description: string,
    id_shop: number
  }
}
