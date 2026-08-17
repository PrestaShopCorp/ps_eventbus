import { defineStore } from 'pinia'
import i18n from '../i18n'
import { useAppStore } from './app-store'
import { callAjax } from '../api/eventbus-ajax'
import { fetchSyncSummary, fetchCloudsyncStatus, requestServerAccessCheck } from '../api/mock-interceptor'

export const SYNC_STATUS = {
  offboarded: 'offboarded',
  syncing: 'syncing',
  synced: 'synced',
  failed: 'failed',
}

export const SERVER_ACCESS = {
  idle: 'idle',
  running: 'running',
  reachable: 'reachable',
  blocked: 'blocked',
}

/**
 * A module row, resolved in order of severity: not installed at all, then not
 * operational, then behind the latest release, then fine. `upToDate` is null
 * when the latest version could not be determined, in which case no claim is
 * made about it.
 */
function buildModuleCheck(id, { installed, ready, readyIssue, version, latestVersion, upToDate }) {
  const detail = version ? `v${version}` : ''

  if (!installed) {
    return { id, status: 'error', badge: 'notInstalled', detail: '' }
  }

  if (!ready) {
    return { id, status: 'error', badge: 'ko', detail: readyIssue || detail }
  }

  if (upToDate === false) {
    return { id, status: 'warning', badge: 'outdated', detail: `${detail} → v${latestVersion}` }
  }

  if (upToDate === null) {
    return { id, status: 'ok', badge: 'installed', detail }
  }

  return { id, status: 'ok', badge: 'upToDate', detail }
}

const SERVER_ACCESS_STATUS_MAP = {
  [SERVER_ACCESS.idle]: 'idle',
  [SERVER_ACCESS.running]: 'idle',
  [SERVER_ACCESS.reachable]: 'ok',
  [SERVER_ACCESS.blocked]: 'warning',
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
      return this.syncSummary.filter((content) => content.requested !== false)
    },

    failedSyncSummary() {
      return this.requestedSyncSummary.filter((content) => content.httpStatus && content.httpStatus >= 400)
    },

    globalSyncStatus() {
      const requested = this.requestedSyncSummary

      if (requested.length === 0) {
        return SYNC_STATUS.offboarded
      }

      if (this.failedSyncSummary.length > 0) return SYNC_STATUS.failed

      const allFinished = requested.every((content) => content.firstSyncFinishedAt)
      const anyFinished = requested.some((content) => content.firstSyncFinishedAt)

      if (allFinished) return SYNC_STATUS.synced
      if (anyFinished) return SYNC_STATUS.syncing

      return SYNC_STATUS.offboarded
    },

    lastSyncedAt() {
      const timestamps = this.requestedSyncSummary
        .filter((content) => content.lastSyncFinishedAt)
        .map((content) => new Date(content.lastSyncFinishedAt).getTime())

      return timestamps.length > 0 ? Math.max(...timestamps) : null
    },

    syncProgress() {
      const requested = this.requestedSyncSummary

      if (requested.length === 0) return 0

      const completed = requested.filter((content) => content.firstSyncFinishedAt).length

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
          ready: psAccount.linked,
          readyIssue: i18n.global.t('dashboard.healthCheck.issues.psAccountNotLinked'),
          version: psAccount.version,
          latestVersion: psAccount.latestVersion,
          upToDate: psAccount.upToDate,
        }),
        buildModuleCheck('psEventbus', {
          installed: true,
          ready: psEventbus.tablesInstalled,
          readyIssue: i18n.global.t('dashboard.healthCheck.issues.psEventbusTablesMissing'),
          version: psEventbus.version,
          latestVersion: psEventbus.latestVersion,
          upToDate: psEventbus.upToDate,
        }),
        {
          id: 'urlMatching',
          status: !psAccount.linked ? 'idle' : urlsMatch ? 'ok' : 'warning',
          badge: !psAccount.linked ? '' : urlsMatch ? 'match' : 'mismatch',
          detail: !psAccount.linked
            ? i18n.global.t('dashboard.healthCheck.issues.urlMatchingRequiresAccount')
            : urlsMatch ? '' : `${accountsShopUrl || '—'} ≠ ${this.cloudsyncShopUrl || '—'}`,
        },
        {
          id: 'phpCompatibility',
          status: compatibility.compatible ? 'ok' : 'error',
          badge: compatibility.compatible ? 'compatible' : 'ko',
          detail: formatCompatibilityDetail(compatibility),
        },
        {
          id: 'serverAccess',
          status: SERVER_ACCESS_STATUS_MAP[this.serverAccess.status] ?? 'warning',
          badge: this.serverAccess.status === SERVER_ACCESS.idle ? '' : this.serverAccess.status,
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
      this.healthCheckLoading = true
      this.healthCheckError = null

      try {
        this.healthCheck = await callAjax('getHealthCheck')
      } catch (error) {
        this.healthCheckError = error.message
      } finally {
        this.healthCheckLoading = false
      }
    },

    async fetchSyncSummary() {
      const appStore = useAppStore()
      this.syncSummaryLoading = true
      this.syncSummaryError = null

      try {
        this.syncSummary = await fetchSyncSummary(appStore.cloudsyncReportingApiUrl, appStore.shopId)
      } catch (error) {
        this.syncSummaryError = error.message
      } finally {
        this.syncSummaryLoading = false
      }
    },

    async fetchCloudsyncStatus() {
      const appStore = useAppStore()

      try {
        const status = await fetchCloudsyncStatus(appStore.cloudsyncSyncApiUrl, appStore.shopId)

        this.cloudsyncShopUrl = status.shopUrl
      } catch {
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

      if (this.serverAccess.status === SERVER_ACCESS.running) return

      this.serverAccess = { status: SERVER_ACCESS.running, message: '' }

      try {
        const result = await requestServerAccessCheck(appStore.cloudsyncSyncApiUrl, appStore.shopId, appStore.healthCheckUrl)

        this.serverAccess = result.reachable
          ? { status: SERVER_ACCESS.reachable, message: result.probedUrl }
          : {
              status: SERVER_ACCESS.blocked,
              message: [result.blockedBy, result.httpStatus].filter(Boolean).join(' · HTTP '),
            }
      } catch (error) {
        this.serverAccess = { status: SERVER_ACCESS.blocked, message: error.message }
      }
    },

    async loadDashboard() {
      await Promise.all([this.fetchHealthCheck(), this.fetchSyncSummary()])

      // Needs the Account URL from the health check to compare it against
      await this.fetchCloudsyncStatus()
    },
  },
})
