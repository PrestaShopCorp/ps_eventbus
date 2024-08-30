import fixture from "../fixtures/latest/carrier_details.json"

// test type
const t: CarrierDetails[] = fixture;

export type CarrierDetails = {
  collection: string;
  id: string;
  properties: {
    country_ids: string;
    delimiter1: number;
    delimiter2: number;
    id_carrier_detail: string;
    id_range: string;
    id_reference: string;
    id_zone: string;
    price: number;
    shipping_method: string;
    state_ids: string;
  }
}
