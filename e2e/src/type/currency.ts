import fixture from "../fixtures/latest/currencies.json";

// test type
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const t: Currencies[] = fixture;

export type Currencies = {
  id: number;
  collection: string;
  properties: {
    active: boolean;
    conversion_rate: number;
    deleted: boolean;
    id_currency: number;
    iso_code: string;
    name: string;
    precision: number;
  };
};
