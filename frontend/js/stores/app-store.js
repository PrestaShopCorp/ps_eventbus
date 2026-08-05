import { defineStore } from 'pinia'

const config = globalThis.eventbusConfig ?? {}

export const useAppStore = defineStore('app', {
  state: () => ({
    isoCode: config.isoCode ?? 'en',
    eventbusAjaxPath: config.eventbusAjaxPath ?? '',
    logoUrl: config.logoUrl ?? '',
    moduleVersion: config.moduleVersion ?? '0.0.0',
    healthCheckUrl: config.healthCheckUrl ?? '',
    shopId: config.shopId ?? '',
    // Canonical list from Config::SHOP_CONTENTS, so the dashboard never has to
    // maintain its own copy
    shopContents: config.shopContents ?? [],
    // When true, API calls return canned mock data instead of hitting CloudSync
    mockMode: config.mockMode ?? true,
    cloudsyncApiUrl: config.cloudsyncApiUrl ?? '',
  }),
})
