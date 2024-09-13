import fixture from "../fixtures/latest/apiCarriers/carriers.json";

// test type
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const t: Carriers[] = fixture;

export type Carriers = {
  collection: string;
  id: string;
  properties: {
    active: boolean;
    carrier_taxes_rates_group_id: string;
    currency: string;
    delay: string;
    deleted: boolean;
    disable_carrier_when_out_of_range: boolean;
    external_module_name: string;
    free_shipping_starts_at_price: number;
    free_shipping_starts_at_weight: number;
    grade: number;
    id_carrier: string;
    id_reference: string;
    is_free: boolean;
    is_module: boolean;
    max_depth: number;
    max_height: number;
    max_weight: number;
    max_width: number;
    name: string;
    need_range: boolean;
    shipping_external: boolean;
    shipping_handling: number;
    url: string;
    weight_unit: string;
  };
};
