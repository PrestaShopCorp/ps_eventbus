/**
 * API layer that transparently switches between real CloudSync endpoints and
 * mock data. The store always calls these functions; the `mockMode` flag in
 * appStore decides which path runs.
 *
 * To go live, set `mockMode: false` in the PHP eventbusConfig.
 */
import * as realApi from './cloudsync-api'
import * as mockData from './mock-data'
import { useAppStore } from '../stores/app-store'

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
 * @param {string} baseUrl
 * @param {string} shopId
 * @param {string} accountsShopUrl  Needed by the mock to mirror the Account URL
 * @returns {Promise<{shopUrl: string}>}
 */
export async function fetchCloudsyncStatus(baseUrl, shopId, accountsShopUrl) {
  const app = useAppStore()

  if (app.mockMode) {
    return mockData.getMockCloudsyncStatus(accountsShopUrl)
  }

  return realApi.fetchCloudsyncStatus(baseUrl, shopId)
}

/**
 * @param {string} baseUrl
 * @param {string} shopId
 * @param {string} healthCheckUrl
 * @returns {Promise<{probedUrl: string, reachable: boolean, httpStatus: number|null, blockedBy: string|null}>}
 */
export async function requestServerAccessCheck(baseUrl, shopId, healthCheckUrl) {
  const app = useAppStore()

  if (app.mockMode) {
    return mockData.requestMockServerAccessCheck(healthCheckUrl)
  }

  return realApi.requestServerAccessCheck(baseUrl, shopId, healthCheckUrl)
}
