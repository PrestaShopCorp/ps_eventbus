/**
 * API layer that transparently switches between real CloudSync endpoints and
 * mock data. The store always calls these functions; the `mockMode` flag in
 * appStore decides which path runs.
 *
 * Connections and CloudSync status always hit the real API. The Reporting API
 * endpoints remain mocked until they are deployed.
 */
import * as realApi from './cloudsync-api'
import * as mockData from './mock-data'
import { callAjax } from './eventbus-ajax'
import { useAppStore } from '../stores/app-store'

/** Always uses the real admin AJAX endpoint. */
export async function fetchConnections() {
  const data = await callAjax('getConnections')

  return data.services
}

export async function fetchSyncSummary(reportingApiUrl, shopId) {
  const appStore = useAppStore()

  if (appStore.mockMode) {
    return mockData.getMockSyncSummary(appStore.shopContents)
  }

  return realApi.fetchSyncSummary(reportingApiUrl, shopId)
}

/**
 * Always uses the real Sync API — the shop-sync-setup endpoint returns the
 * targetUrl attribute that CloudSync synchronizes with.
 */
export async function fetchCloudsyncStatus(syncApiUrl, shopId) {
  return realApi.fetchCloudsyncStatus(syncApiUrl, shopId)
}

export async function requestServerAccessCheck(syncApiUrl, shopId, healthCheckUrl) {
  return realApi.requestServerAccessCheck(syncApiUrl, shopId, healthCheckUrl)
}
