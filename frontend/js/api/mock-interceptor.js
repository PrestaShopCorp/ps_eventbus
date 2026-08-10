/**
 * API layer that transparently switches between real CloudSync endpoints and
 * mock data. The store always calls these functions; the `mockMode` flag in
 * appStore decides which path runs.
 *
 * Connections and CloudSync status always hit the real Sync API (authenticated
 * with the Accounts token server-side). The Reporting API endpoints remain
 * mocked until they are deployed.
 */
import * as realApi from './cloudsync-api'
import * as mockData from './mock-data'
import { useAppStore } from '../stores/app-store'

/**
 * Always uses the real Sync API — the backend proxies the call and
 * authenticates with the merchant's Accounts token.
 *
 * @returns {Promise<Array>}
 */
export async function fetchConnections() {
  const app = useAppStore()
  const query = new URLSearchParams({ action: 'getConnections', ajax: '1' })
  const response = await fetch(`${app.eventbusAjaxPath}&${query.toString()}`)
  const data = await response.json()

  if (data && data.error) {
    throw new Error(data.message)
  }

  return data.services
}

/**
 * @param {string} baseUrl
 * @param {string} shopId
 * @returns {Promise<Array>}
 */
export async function fetchSyncSummary(baseUrl, shopId) {
  const app = useAppStore()

  if (app.mockMode) {
    return mockData.getMockSyncSummary(app.shopContents)
  }

  return realApi.fetchSyncSummary(baseUrl, shopId)
}

/**
 * Always uses the real Sync API — the shop-sync-setup endpoint returns the
 * targetUrl attribute that CloudSync synchronizes with.
 *
 * @param {string} baseUrl
 * @param {string} shopId
 * @returns {Promise<{shopUrl: string}>}
 */
export async function fetchCloudsyncStatus(baseUrl, shopId) {
  return realApi.fetchCloudsyncStatus(baseUrl, shopId)
}

/**
 * @param {string} baseUrl
 * @param {string} shopId
 * @param {string} healthCheckUrl
 * @returns {Promise<{probedUrl: string, reachable: boolean, httpStatus: number|null, blockedBy: string|null}>}
 */
export async function requestServerAccessCheck(baseUrl, shopId, healthCheckUrl) {
  return realApi.requestServerAccessCheck(baseUrl, shopId, healthCheckUrl)
}
