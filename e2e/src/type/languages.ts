import fixture from '../fixtures/latest/apiLanguages/languages.json'

// test type
const t: Languages[] = fixture;

export type Languages = {
  id: number,
  collection: string,
  properties: {
    id_lang: number,
    name: string,
    active: boolean,
    iso_code: string,
    language_code: string,
    locale: string,
    date_format_lite: string,
    date_format_full: string,
    is_rtl: boolean,
    id_shop: number,
    created_at?: string,
    updated_at?: string
  }
}
