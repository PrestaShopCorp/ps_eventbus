import fixture from '../fixtures/latest/shops.json'

// test type
// eslint-disable-next-line @typescript-eslint/no-unused-vars
const t: Shops[] = fixture;

export type Shops = {
  collection: string;
  id: string;
  properties: {
    cart_is_persistent: boolean;
    cms_version: string;
    country_code: string;
    created_at: string;
    currencies: string;
    default_currency: string;
    default_language: string;
    dimension_unit: string;
    distance_unit: string;
    folder_created_at: string;
    http_server: string;
    is_order_return_enabled: boolean;
    languages: string;
    multi_shop_count: number;
    order_return_nb_days: number;
    php_version: string;
    ssl: boolean;
    timezone: string;
    url: string;
    url_is_simplified: boolean;
    volume_unit: string;
    weight_unit: string;
  };
};
