import { defineStore } from 'pinia'

const config = globalThis.eventbusConfig ?? {}

export const useAppStore = defineStore('app', {
  state: () => ({
    isoCode: config.isoCode ?? 'en',
    eventbusAjaxPath: config.eventbusAjaxPath ?? '',
  }),
})
