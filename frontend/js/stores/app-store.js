import { defineStore } from 'pinia'
import { debugRequestedInSearch } from '../navigation'

const config = globalThis.eventbusConfig ?? {}

/**
 * The Support & debug page is not advertised to merchants. It is opened by
 * appending `&debug=1` to the module's admin URL — a single link the support
 * team can hand over, which both unlocks the page and lands on it. `debug=1` in
 * the hash does the same, see `resolveNavigation`.
 *
 * Once unlocked, the flag lives in sessionStorage so the page survives a reload
 * and a round trip through the other tabs, and closes again when the browser
 * tab does.
 */
const SUPPORT_DEBUG_STORAGE_KEY = 'eventbusSupportDebug'

function readSupportDebugUnlocked() {
  try {
    return globalThis.sessionStorage?.getItem(SUPPORT_DEBUG_STORAGE_KEY) === '1'
  } catch {
    // Private browsing modes can throw on access rather than return null
    return false
  }
}

/**
 * Whether `debug=1` sits on the admin URL's own query string — the part before
 * the hash, which the Vue router never sees.
 */
function supportDebugRequestedInUrl() {
  try {
    return debugRequestedInSearch(globalThis.location?.search)
  } catch {
    return false
  }
}

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
    supportDebugUnlocked: readSupportDebugUnlocked(),
    // Consumed once by the router, so the merchant lands on the page but can
    // still navigate away afterwards.
    supportDebugRedirectPending: supportDebugRequestedInUrl(),
  }),

  getters: {
    connectionsAvailable() {
      return this.psAccountsInstalled && !!this.shopId
    },
  },

  actions: {
    /**
     * Answers once whether to send the merchant to the Support & debug page,
     * and unlocks it on the way. Later calls answer false, so the other tabs
     * stay reachable.
     */
    consumeSupportDebugRedirect() {
      if (!this.supportDebugRedirectPending) return false

      this.supportDebugRedirectPending = false
      this.unlockSupportDebug()

      return true
    },

    unlockSupportDebug() {
      this.supportDebugUnlocked = true

      try {
        globalThis.sessionStorage?.setItem(SUPPORT_DEBUG_STORAGE_KEY, '1')
      } catch {
        // Losing the persistence is fine: the tab stays open for this page load
      }
    },
  },
})
