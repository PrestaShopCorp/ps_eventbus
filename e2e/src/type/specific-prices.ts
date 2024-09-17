import fixture from '../fixtures/latest/specific_prices.json'

// test type
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const t: SpecificPrices[] = fixture;

export type SpecificPrices = {
  id: number;
  collection: string;
  properties: {
    id_specific_price: number;
    id_product: number;
    id_shop: number;
    id_shop_group: number;
    id_currency: number;
    id_country: number;
    id_group: number;
    id_customer: number;
    id_product_attribute: number;
    price: number;
    from_quantity: number;
    reduction: number;
    reduction_tax: number;
    reduction_type: string;
    country: string;
    currency: string;
    price_tax_included: number;
    price_tax_excluded: number;
    sale_price_tax_incl: number;
    sale_price_tax_excl: number;
    discount_percentage: number;
    discount_value_tax_incl: number;
    discount_value_tax_excl: number;
  };
};
