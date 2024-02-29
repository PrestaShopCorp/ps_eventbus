export type Currency =  {
    id: number,
    collection: string,
    properties: {
      active: boolean,
      conversion_rate: number,
      deleted: boolean,
      id_currency: number,
      iso_code: string,
      name: string,
      precision: number
    }
}

