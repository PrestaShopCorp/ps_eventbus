export type HealthCheck = {
  "prestashop_version"?: string,
  "ps_eventbus_version"?: string,
  "ps_accounts_version"?: string,
  "php_version"?: string,
  "shop_id"?: string,
  "ps_account": boolean,
  "is_valid_jwt": boolean,
  "ps_eventbus": boolean,
  "env": {
    "EVENT_BUS_PROXY_API_URL": string,
    "EVENT_BUS_SYNC_API_URL": string,
    "EVENT_BUS_LIVE_SYNC_API_URL": string
  },
  "httpCode": number
}
