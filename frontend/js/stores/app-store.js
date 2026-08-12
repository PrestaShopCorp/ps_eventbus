import { defineStore } from 'pinia'

const config = globalThis.eventbusConfig ?? {}

export const useAppStore = defineStore('app', {
  state: () => ({
    isoCode: config.isoCode ?? 'en',
    eventbusAjaxPath: config.eventbusAjaxPath ?? '',
    logoUrl: config.logoUrl ?? '',
    moduleVersion: config.moduleVersion ?? '0.0.0',
    healthCheckUrl: config.healthCheckUrl ?? '',
    shopId: config.shopId ?? null,
    shopContents: config.shopContents ?? [],
    defaultSyncedShopContents: config.defaultSyncedShopContents ?? [],
    psAccountsInstalled: config.psAccountsInstalled ?? false,
    mockMode: config.mockMode ?? true,
    cloudsyncSyncApiUrl: config.cloudsyncSyncApiUrl ?? '',
    cloudsyncReportingApiUrl: config.cloudsyncReportingApiUrl ?? '',
  }),

  getters: {
    connectionsAvailable() {
      return this.psAccountsInstalled && !!this.shopId
    },
  },
})
