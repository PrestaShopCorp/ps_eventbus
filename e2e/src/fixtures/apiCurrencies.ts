import {Currency} from '../type/currency';

export const currencies_full: Currency[] = [
  {
    id: 1,
    collection: 'currencies',
    properties: {
      active: true,
      conversion_rate: 1,
      deleted: false,
      id_currency: 1,
      iso_code: 'EUR',
      name: 'Euro',
      precision: 2
    }
  },
  {
    id: 2,
    collection: 'currencies',
    properties: {
      active: true,
      conversion_rate: 1.078668,
      deleted: false,
      id_currency: 2,
      iso_code: 'USD',
      name: 'US Dollar',
      precision: 2
    }
  }
]
