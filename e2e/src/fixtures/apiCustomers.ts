import {Customer} from '../type/customer';

export const customers_full: Customer[] = [
  {
    id: '1',
    collection: 'customers',
    properties: {
      active: false,
      created_at: '2024-02-19T12:12:05+0100',
      deleted: false,
      email_hash: '02c1ece2f6e294819d722656d18140f0f0b103e63056b1b5aa22a4932fd41779',
      id_customer: 1,
      id_lang: 1,
      is_guest: false,
      newsletter: false,
      newsletter_date_add: '-0001-11-30T00:00:00+0009',
      optin: false,
      updated_at: '2024-02-19T12:12:05+0100'
    }
  },
  {
    id: '2',
    collection: 'customers',
    properties: {
      active: true,
      created_at: '2024-02-19T12:12:12+0100',
      deleted: false,
      email_hash: 'abf48c68c3b53f7f60a1ba1327701aae275a2555e999b60c72becbf309c6d9ad',
      id_customer: 2,
      id_lang: 1,
      is_guest: false,
      newsletter: true,
      newsletter_date_add: '2013-12-13T08:19:15+0100',
      optin: true,
      updated_at: '2024-02-19T12:12:12+0100'
    }
  }
]
