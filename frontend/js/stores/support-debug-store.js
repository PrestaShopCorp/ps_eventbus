import { defineStore } from 'pinia'
import i18n from '../i18n'
import { useAppStore } from './app-store'
import { callAjax } from '../api/eventbus-ajax'
import { fetchCloudsyncStatus } from '../api/mock-interceptor'
import { copyToClipboard } from '../api/clipboard'

const UNKNOWN = '—'
const COPIED_FEEDBACK_DURATION = 2000

function t(key, params) {
  return i18n.global.t(key, params ?? {})
}

/**
 * Diagnostic of the whole shop, as displayed on the Support & debug page and
 * copied into a support ticket.
 *
 * `rows` is the single source of truth: the page renders it and passes those
 * same rows back to `copyDiagnostic`, so what the merchant sends can never
 * differ from what they were shown.
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
     * The diagnostic as data: no label and no hint. SystemDiagnosticCard words
     * them from `id`, `module` and `minPhpVersion`, then hands the rows back to
     * `copyDiagnostic`. Only `detail` is content, hence resolved here.
     */
    rows() {
      const diagnostic = this.diagnostic

      if (!diagnostic) return []

      const phpCompatible = Boolean(diagnostic.phpCompatible)
      const cloudApi = diagnostic.cloudApi ?? {}

      return [
        { id: 'prestashopVersion', value: diagnostic.prestashopVersion || UNKNOWN },
        {
          id: 'phpVersion',
          value: diagnostic.phpVersion || UNKNOWN,
          minPhpVersion: phpCompatible ? '' : diagnostic.minPhpVersion,
          badge: phpCompatible ? 'compatible' : 'incompatible',
          status: phpCompatible ? 'ok' : 'error',
        },
        // A module that reached the payload without a version was resolved as absent.
        ...(diagnostic.modules ?? []).map((module) => ({
          id: module.id,
          module: module.label,
          value: module.version ? `v${module.version}` : '',
          badge: module.version ? '' : 'notInstalled',
          status: module.version ? 'neutral' : 'error',
        })),
        // The probed URL is worth showing: it appears in none of the environment
        // variables below.
        {
          id: 'cloudApi',
          value: cloudApi.url || UNKNOWN,
          detail: cloudApi.reachable ? '' : cloudApi.error || '',
          badge: cloudApi.reachable ? 'reachable' : 'unreachable',
          status: cloudApi.reachable ? 'ok' : 'error',
          muted: true,
        },
        // `id` is the environment variable name, which the page uses verbatim as
        // the label so a support agent can match the row against the module's
        // configuration files.
        ...Object.entries(diagnostic.env ?? {}).map(([name, url]) => ({ id: name, env: true, value: url || UNKNOWN, muted: true })),
        { id: 'ssl', ...sslState(diagnostic.ssl ?? {}) },
        { id: 'cloudsyncTargetUrl', value: this.cloudsyncTargetUrl || UNKNOWN, muted: true, separated: true },
        { id: 'accountsShopUrl', value: diagnostic.accountsShopUrl || UNKNOWN, muted: true },
      ]
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
        callAjax('getSystemDiagnostic').catch((error) => {
          this.error = error.message

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

    /** @param {Array<object>} rows  The rows as the page worded them. */
    async copyDiagnostic(rows) {
      this.copyFailed = false
      this.copied = await copyToClipboard(markdown(rows, this.diagnostic))
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
 * The diagnostic as a Markdown document, ready to paste into a support ticket:
 * the rows the page displayed, plus a header carrying what identifies the shop
 * for the support team.
 */
function markdown(rows, diagnostic) {
  if (!diagnostic) return ''

  const lines = [
    '## ' + t('supportDebug.copy.heading'),
    '',
    // The colon lives in the translations: French wants a space before it,
    // English does not.
    '- ' + t('supportDebug.copy.generatedAt') + ' ' + (diagnostic.generatedAt || UNKNOWN),
    '- ' + t('supportDebug.copy.shopId') + ' ' + (diagnostic.shopId || UNKNOWN),
    '',
    '| ' + t('supportDebug.copy.item') + ' | ' + t('supportDebug.copy.value') + ' | ' + t('supportDebug.copy.status') + ' |',
    '| --- | --- | --- |',
  ]

  for (const row of rows) {
    const label = [row.label, row.hint].filter(Boolean).join(' ')
    const value = [row.value, row.detail].filter(Boolean).join(' — ') || UNKNOWN
    const status = row.badge ? t(`supportDebug.badges.${row.badge}`) : ''

    lines.push(`| ${escapeCell(label)} | ${escapeCell(value)} | ${escapeCell(status)} |`)
  }

  return lines.join('\n')
}

function sslState(ssl) {
  if (!ssl.https) return { badge: 'notEnabled', status: 'warning' }
  if (ssl.valid === null) return { badge: 'unknown', status: 'warning', detail: ssl.error || '' }
  if (!ssl.valid) return { badge: 'invalid', status: 'error', detail: ssl.error || '' }

  return {
    badge: 'valid',
    status: 'ok',
    detail: ssl.expiresAt ? t('supportDebug.rows.ssl.expiresAt', { date: formatDate(ssl.expiresAt) }) : '',
  }
}

function formatDate(isoDate) {
  const date = new Date(isoDate)

  return Number.isNaN(date.getTime()) ? isoDate : date.toISOString().slice(0, 10)
}

/** Pipes would break out of the Markdown table cell they sit in. */
function escapeCell(value) {
  return String(value).replace(/\|/g, '\\|').replace(/\n/g, ' ')
}
