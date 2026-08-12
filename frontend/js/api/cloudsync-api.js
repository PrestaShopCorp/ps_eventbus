/**
 * CloudSync API client — definitive fetch calls.
 *
 * Every function targets a real CloudSync endpoint. When the endpoints are not
 * yet deployed, the mock-interceptor wraps these calls and returns canned JSON
 * instead.
 */

/**
 * @param {string} reportingApiUrl  CloudSync Reporting API (e.g. .../reporting/v1)
 * @param {string} shopId           Shop UUID from ps_accounts
 *
 * @returns {Promise<Array<{shopContent: string, requested: boolean, firstSyncFinishedAt: string|null, lastSyncFinishedAt: string|null, httpStatus: number|null, httpStatusText: string|null}>>}
 *
 * @see https://docs.cloudsync.prestashop.com/api-doc/reporting-api
 */
export async function fetchSyncSummary(reportingApiUrl, shopId) {
  const response = await fetch(`${reportingApiUrl}/shop-sync-summary/${encodeURIComponent(shopId)}`)

  if (!response.ok) {
    throw new Error(`CloudSync API error: GET shop-sync-summary returned HTTP ${response.status}`)
  }

  return response.json()
}

/**
 * Retrieve the shop URL registered in CloudSync so the dashboard can compare
 * it with the one from ps_accounts.
 *
 * Uses the shop-sync-setup endpoint which returns a `targetUrl` attribute.
 *
 * @param {string} syncApiUrl  CloudSync Sync API (e.g. .../sync/v1)
 * @param {string} shopId      Shop UUID from ps_accounts
 *
 * @returns {Promise<{shopUrl: string}>}
 */
export async function fetchCloudsyncStatus(syncApiUrl, shopId) {
  const response = await fetch(`${syncApiUrl}/shop-sync-setup/${encodeURIComponent(shopId)}`)

  if (!response.ok) {
    throw new Error(`CloudSync API error: GET shop-sync-setup returned HTTP ${response.status}`)
  }

  const data = await response.json()

  return { shopUrl: data.targetUrl || '' }
}

/**
 * Ask CloudSync to call the shop's health check from the outside.
 *
 * @param {string} syncApiUrl      CloudSync Sync API (e.g. .../sync/v1)
 * @param {string} shopId          Shop UUID from ps_accounts
 * @param {string} healthCheckUrl  Public URL of the shop's health check controller
 *
 * @returns {Promise<{probedUrl: string, reachable: boolean, httpStatus: number|null, blockedBy: string|null}>}
 */
export async function requestServerAccessCheck(syncApiUrl, shopId, healthCheckUrl) {
  const response = await fetch(`${syncApiUrl}/shop/${encodeURIComponent(shopId)}/server-access-check`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ healthCheckUrl }),
  })

  if (!response.ok) {
    throw new Error(`CloudSync API error: POST server-access-check returned HTTP ${response.status}`)
  }

  return response.json()
}
