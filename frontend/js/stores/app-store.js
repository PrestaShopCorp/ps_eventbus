import { defineStore } from 'pinia'

const config = globalThis.eventbusConfig ?? {}

export const useAppStore = defineStore('app', {
  state: () => ({
    isoCode: config.isoCode ?? 'en',
    eventbusAjaxPath: config.eventbusAjaxPath ?? '',
    logoUrl: config.logoUrl ?? '',
    moduleVersion: config.moduleVersion ?? '0.0.0',
  }),
})
