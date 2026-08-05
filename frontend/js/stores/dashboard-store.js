import { defineStore } from 'pinia'
import { useAppStore } from './app-store'
import { fetchSyncSummary, fetchCloudsyncStatus, requestServerAccessCheck } from '../api/mock-interceptor'

/**
 * A module row, resolved in order of severity: not installed at all, then not
 * operational, then behind the latest release, then fine. `upToDate` is null
 * when the latest version could not be determined, in which case no claim is
 * made about it.
 */
function buildModuleCheck(id, { installed, ready, version, latestVersion, upToDate }) {
  const detail = version ? `v${version}` : ''

  if (!installed) {
    return { id, status: 'error', badge: 'notInstalled', detail: '' }
  }

  if (!ready) {
    return { id, status: 'error', badge: 'ko', detail }
  }

  if (upToDate === false) {
    return { id, status: 'warning', badge: 'outdated', detail: `${detail} → v${latestVersion}` }
  }

  if (upToDate === null) {
    return { id, status: 'ok', badge: 'installed', detail }
  }

  return { id, status: 'ok', badge: 'upToDate', detail }
}

const SERVER_ACCESS_STATUS = {
  idle: 'idle',
  running: 'idle',
  reachable: 'ok',
  blocked: 'warning',
}

function formatCompatibilityDetail(compatibility) {
  const php = compatibility.phpCompatible ? `PHP ${compatibility.phpVersion}` : `PHP ${compatibility.phpVersion} < ${compatibility.minPhpVersion}`

  const prestashop = compatibility.prestashopCompatible
    ? `PrestaShop ${compatibility.prestashopVersion}`
    : `PrestaShop ${compatibility.prestashopVersion} < ${compatibility.minPrestashopVersion}`

  return `${php} · ${prestashop}`
}

export const useDashboardStore = defineStore('dashboard', {
  state: () => ({
    healthCheck: null,
    syncSummary: [],
    cloudsyncShopUrl: '',
    // 'idle' until the merchant asks CloudSync to probe the shop, then
    // 'running', then 'reachable' or 'blocked'
    serverAccess: { status: 'idle', message: '' },
    healthCheckLoading: false,
    healthCheckError: null,
    syncSummaryLoading: false,
    syncSummaryError: null,
  }),

  getters: {
    /**
     * Contents actually collected. The ones no third-party module subscribed to
     * are never synchronized by design, so counting them would hold the
     * progress below 100% and the card in "syncing" state forever.
     */
    requestedSyncSummary() {
      return this.syncSummary.filter((item) => item.requested !== false)
    },

    failedSyncSummary() {
      return this.requestedSyncSummary.filter((item) => item.httpStatus && item.httpStatus >= 400)
    },

    globalSyncStatus() {
      const requested = this.requestedSyncSummary

      if (requested.length === 0) {
        return 'offboarded'
      }

      if (this.failedSyncSummary.length > 0) return 'failed'

      const allFinished = requested.every((item) => item.firstSyncFinishedAt)
      const anyFinished = requested.some((item) => item.firstSyncFinishedAt)

      if (allFinished) return 'synced'
      if (anyFinished) return 'syncing'

      return 'offboarded'
    },

    lastSyncedAt() {
      const timestamps = this.requestedSyncSummary.filter((item) => item.lastSyncFinishedAt).map((item) => new Date(item.lastSyncFinishedAt).getTime())

      return timestamps.length > 0 ? Math.max(...timestamps) : null
    },

    syncProgress() {
      const requested = this.requestedSyncSummary

      if (requested.length === 0) return 0

      const completed = requested.filter((item) => item.firstSyncFinishedAt).length

      return Math.round((completed / requested.length) * 100)
    },

    /**
     * Checks displayed in the "Sync health check" card.
     *
     * Three of them are answered by the module itself (PHP ajax endpoint): the
     * two module states and the PHP / PrestaShop compatibility.
     *
     * `urlMatching` compares the shop URL registered against the PrestaShop
     * Account with the one CloudSync synchronizes with, so it needs both sides.
     * `serverAccess` can only be answered from the outside, so it is run on
     * demand: the merchant asks CloudSync to call the shop back. Both
     * CloudSync-side values are still mocked.
     */
    healthChecks() {
      if (!this.healthCheck) return []

      const { psAccount, psEventbus, compatibility, accountsShopUrl } = this.healthCheck

      const urlsMatch = !!accountsShopUrl && !!this.cloudsyncShopUrl && accountsShopUrl === this.cloudsyncShopUrl

      return [
        buildModuleCheck('psAccount', {
          installed: psAccount.installed,
          // ps_accounts is only useful once the shop is linked to an account
          ready: psAccount.linked,
          version: psAccount.version,
          latestVersion: psAccount.latestVersion,
          upToDate: psAccount.upToDate,
        }),
        buildModuleCheck('psEventbus', {
          installed: true,
          // Its own tables are what make the module operational
          ready: psEventbus.tablesInstalled,
          version: psEventbus.version,
          latestVersion: psEventbus.latestVersion,
          upToDate: psEventbus.upToDate,
        }),
        {
          id: 'urlMatching',
          status: urlsMatch ? 'ok' : 'warning',
          badge: urlsMatch ? 'match' : 'mismatch',
          detail: urlsMatch ? '' : `${accountsShopUrl || '—'} ≠ ${this.cloudsyncShopUrl || '—'}`,
        },
        {
          id: 'phpCompatibility',
          status: compatibility.compatible ? 'ok' : 'error',
          badge: compatibility.compatible ? 'compatible' : 'ko',
          detail: formatCompatibilityDetail(compatibility),
        },
        {
          id: 'serverAccess',
          status: SERVER_ACCESS_STATUS[this.serverAccess.status] ?? 'warning',
          badge: this.serverAccess.status === 'idle' ? '' : this.serverAccess.status,
          detail: this.serverAccess.message,
          // Rendered as a button on the row: nothing is probed until asked
          action: 'runServerAccessCheck',
          actionLoading: this.serverAccess.status === 'running',
        },
      ]
    },
  },

  actions: {
    async fetchHealthCheck() {
      const appStore = useAppStore()
      this.healthCheckLoading = true
      this.healthCheckError = null

      try {
        const url = appStore.eventbusAjaxPath + '&action=getHealthCheck&ajax=1'
        const response = await fetch(url)
        const body = await response.text()
        let data

        try {
          data = JSON.parse(body)
        } catch {
          // A PHP notice, a redirect to the login page or a WAF page ends up here
          throw new Error(`Unexpected response from the health check endpoint (HTTP ${response.status}): ${body.slice(0, 200)}`)
        }

        if (data.error) {
          this.healthCheckError = data.message
        } else {
          this.healthCheck = data
        }
      } catch (e) {
        this.healthCheckError = e.message
      } finally {
        this.healthCheckLoading = false
      }
    },

    async fetchSyncSummary() {
      const appStore = useAppStore()
      this.syncSummaryLoading = true
      this.syncSummaryError = null

      try {
        this.syncSummary = await fetchSyncSummary(appStore.cloudsyncApiUrl, appStore.shopId)
      } catch (e) {
        this.syncSummaryError = e.message
      } finally {
        this.syncSummaryLoading = false
      }
    },

    async fetchCloudsyncStatus() {
      const appStore = useAppStore()

      try {
        const status = await fetchCloudsyncStatus(
          appStore.cloudsyncApiUrl,
          appStore.shopId,
          this.healthCheck ? this.healthCheck.accountsShopUrl : '',
        )

        this.cloudsyncShopUrl = status.shopUrl
      } catch (e) {
        this.cloudsyncShopUrl = ''
      }
    },

    /**
     * Asks CloudSync to call the shop's health check from its own network and
     * report back. Triggered by the merchant, never on page load: it costs a
     * round trip through CloudSync.
     */
    async runServerAccessCheck() {
      const appStore = useAppStore()

      if (this.serverAccess.status === 'running') return

      this.serverAccess = { status: 'running', message: '' }

      try {
        const result = await requestServerAccessCheck(appStore.cloudsyncApiUrl, appStore.shopId, appStore.healthCheckUrl)

        this.serverAccess = result.reachable
          ? { status: 'reachable', message: result.probedUrl }
          : {
              status: 'blocked',
              message: [result.blockedBy, result.httpStatus].filter(Boolean).join(' · HTTP '),
            }
      } catch (e) {
        this.serverAccess = { status: 'blocked', message: e.message }
      }
    },

    async loadDashboard() {
      await Promise.all([this.fetchHealthCheck(), this.fetchSyncSummary()])

      // Needs the Account URL from the health check to compare it against
      await this.fetchCloudsyncStatus()
    },
  },
})
