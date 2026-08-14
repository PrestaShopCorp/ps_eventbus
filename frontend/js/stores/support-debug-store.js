import { defineStore } from 'pinia'
import i18n from '../i18n'
import { useAppStore } from './app-store'
import { callAjax } from '../api/eventbus-ajax'
import { fetchCloudsyncStatus } from '../api/mock-interceptor'
import { copyToClipboard } from '../api/clipboard'

const UNKNOWN = '—'

/** How long the copy button stays in its confirmation state, in ms. */
const COPIED_FEEDBACK_DURATION = 2000

function t(key, params) {
  return i18n.global.t(key, params ?? {})
}

/**
 * Diagnostic of the whole shop, as displayed on the Support & debug page and
 * copied into a support ticket.
 *
 * `rows` is the single source of truth: the page renders it and the clipboard
 * is built from it, so what the merchant sends can never differ from what they
 * were shown.
 */
export const useSupportDebugStore = defineStore('supportDebug', {
  state: () => ({
    diagnostic: null,
    // Read from CloudSync rather than from the shop: this is the URL CloudSync
    // actually synchronizes with, which is the point of the comparison.
    cloudsyncTargetUrl: '',
    loading: false,
    error: null,
    copied: false,
    copyFailed: false,
  }),

  getters: {
    /**
     * @returns {Array<{id: string, label: string, hint: string, value: string, detail: string, badge: string, status: string, muted: boolean, separated: boolean}>}
     */
    rows() {
      if (!this.diagnostic) return []

      const d = this.diagnostic

      return [
        row('prestashopVersion', { value: d.prestashopVersion || UNKNOWN }),
        row('phpVersion', {
          value: d.phpVersion || UNKNOWN,
          badge: d.phpCompatible ? 'compatible' : 'incompatible',
          status: d.phpCompatible ? 'ok' : 'error',
          hint: d.phpCompatible ? '' : t('supportDebug.rows.phpVersion.minimum', { version: d.minPhpVersion }),
        }),
        ...(d.modules ?? []).map(moduleRow),
        // The probed URL is shown: it is the one endpoint the row is about, and
        // it appears in none of the environment variables below.
        row('cloudApi', {
          hint: t('supportDebug.rows.cloudApi.hint'),
          value: d.cloudApi?.url || UNKNOWN,
          muted: true,
          badge: d.cloudApi?.reachable ? 'reachable' : 'unreachable',
          status: d.cloudApi?.reachable ? 'ok' : 'error',
          detail: d.cloudApi?.reachable ? '' : d.cloudApi?.error || '',
        }),
        // Labelled by the environment variable name itself, so a support agent
        // can match the row against the module's configuration files.
        ...Object.entries(d.env ?? {}).map(([name, url]) => envRow(name, url)),
        sslRow(d.ssl ?? {}),
        row('cloudsyncTargetUrl', { value: this.cloudsyncTargetUrl || UNKNOWN, muted: true, separated: true }),
        row('accountsShopUrl', { value: d.accountsShopUrl || UNKNOWN, muted: true }),
      ]
    },

    /**
     * The diagnostic as a Markdown document, ready to paste into a support
     * ticket. Built from `rows`, plus a header carrying what identifies the
     * shop for the support team.
     *
     * @returns {string}
     */
    markdown() {
      if (!this.diagnostic) return ''

      const lines = [
        '## ' + t('supportDebug.copy.heading'),
        '',
        // The colon lives in the translations: French wants a space before it,
        // English does not.
        '- ' + t('supportDebug.copy.generatedAt') + ' ' + (this.diagnostic.generatedAt || UNKNOWN),
        '- ' + t('supportDebug.copy.shopId') + ' ' + (this.diagnostic.shopId || UNKNOWN),
        '',
        '| ' + t('supportDebug.copy.item') + ' | ' + t('supportDebug.copy.value') + ' | ' + t('supportDebug.copy.status') + ' |',
        '| --- | --- | --- |',
      ]

      for (const item of this.rows) {
        const label = [item.label, item.hint].filter(Boolean).join(' ')
        const value = [item.value, item.detail].filter(Boolean).join(' — ') || UNKNOWN
        const status = item.badge ? t(`supportDebug.badges.${item.badge}`) : ''

        lines.push(`| ${escapeCell(label)} | ${escapeCell(value)} | ${escapeCell(status)} |`)
      }

      return lines.join('\n')
    },
  },

  actions: {
    async loadDiagnostic() {
      this.loading = true
      this.error = null

      const appStore = useAppStore()

      // The CloudSync call is best effort: without a linked shop, or with the
      // Sync API down, the rest of the diagnostic is still worth showing — and
      // an unanswered target URL is itself a useful symptom.
      const [diagnostic] = await Promise.all([
        callAjax('getSystemDiagnostic').catch((e) => {
          this.error = e.message

          return null
        }),
        appStore.shopId
          ? fetchCloudsyncStatus(appStore.cloudsyncSyncApiUrl, appStore.shopId)
              .then((status) => {
                this.cloudsyncTargetUrl = status.shopUrl
              })
              .catch(() => {
                this.cloudsyncTargetUrl = ''
              })
          : Promise.resolve(),
      ])

      this.diagnostic = diagnostic
      this.loading = false
    },

    async copyDiagnostic() {
      this.copyFailed = false
      this.copied = await copyToClipboard(this.markdown)
      this.copyFailed = !this.copied

      if (this.copied) {
        setTimeout(() => {
          this.copied = false
        }, COPIED_FEEDBACK_DURATION)
      }
    },
  },
})

/**
 * @param {string} id  Translation key under `supportDebug.rows`
 * @param {object} overrides
 */
function row(id, overrides) {
  return {
    id,
    label: t(`supportDebug.rows.${id}.label`),
    hint: '',
    value: '',
    detail: '',
    badge: '',
    status: 'neutral',
    muted: false,
    separated: false,
    ...overrides,
  }
}

/**
 * @param {string} name  Environment variable name, used verbatim as the label
 * @param {string} url
 */
function envRow(name, url) {
  return {
    id: name,
    label: name,
    hint: '',
    value: url || UNKNOWN,
    detail: '',
    badge: '',
    status: 'neutral',
    muted: true,
    separated: false,
  }
}

/**
 * A module that reached the payload but has no version was resolved as absent,
 * which only happens for the two modules the page always reports.
 *
 * @param {{id: string, label: string, version: string|null}} module
 */
function moduleRow(module) {
  return {
    id: module.id,
    label: t('supportDebug.rows.moduleVersion', { module: module.label }),
    hint: '',
    value: module.version ? `v${module.version}` : '',
    detail: '',
    badge: module.version ? '' : 'notInstalled',
    status: module.version ? 'neutral' : 'error',
    muted: false,
    separated: false,
  }
}

/**
 * @param {{https: boolean, valid: boolean|null, expiresAt: string|null, error: string|null}} ssl
 */
function sslRow(ssl) {
  const hint = t('supportDebug.rows.ssl.hint')

  if (!ssl.https) {
    return row('ssl', { hint, badge: 'notEnabled', status: 'warning' })
  }

  if (ssl.valid === null) {
    return row('ssl', { hint, badge: 'unknown', status: 'warning', detail: ssl.error || '' })
  }

  return row('ssl', {
    hint,
    badge: ssl.valid ? 'valid' : 'invalid',
    status: ssl.valid ? 'ok' : 'error',
    detail: ssl.valid ? (ssl.expiresAt ? t('supportDebug.rows.ssl.expiresAt', { date: formatDate(ssl.expiresAt) }) : '') : ssl.error || '',
  })
}

/**
 * @param {string} isoDate
 * @returns {string}
 */
function formatDate(isoDate) {
  const date = new Date(isoDate)

  return Number.isNaN(date.getTime()) ? isoDate : date.toISOString().slice(0, 10)
}

/**
 * Pipes would break out of the Markdown table cell they sit in.
 *
 * @param {string} value
 * @returns {string}
 */
function escapeCell(value) {
  return String(value).replace(/\|/g, '\\|').replace(/\n/g, ' ')
}
