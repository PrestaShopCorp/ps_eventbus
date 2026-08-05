/**
 * Contents no third-party module asked for, so CloudSync never collects them.
 * Mocked selection, for the sake of the example.
 */
const MOCK_NOT_REQUESTED = ['wishlists', 'wishlist_products', 'employees', 'translations', 'taxonomies', 'stock_movements']

/**
 * Contents whose last upload failed. Mocked selection, for the sake of the
 * example.
 */
const MOCK_FAILED = {}

/**
 * Mock sync summary matching the Reporting API schema:
 * GET /v1/reporting/shop-sync-summary/{shopId}
 *
 * Each item: { shopContent, requested, firstSyncFinishedAt, lastSyncFinishedAt,
 * httpStatus, httpStatusText }. The HTTP status is the result of the last upload
 * to the CloudSync cloud. `requested` is false when no third-party module
 * subscribed to that content, in which case it is never synchronized at all.
 *
 * @see https://docs.cloudsync.prestashop.com/api-doc/reporting-api
 */
export function getMockSyncSummary(shopContents) {
  const now = Date.now()
  const day = 86400000

  return shopContents.map((shopContent, index) => {
    if (MOCK_NOT_REQUESTED.includes(shopContent)) {
      return {
        shopContent,
        requested: false,
        firstSyncFinishedAt: null,
        lastSyncFinishedAt: null,
        httpStatus: null,
        httpStatusText: null,
      }
    }

    const failure = MOCK_FAILED[shopContent]

    // First half of requested contents have finished their initial sync,
    // the rest have not yet — this puts globalSyncStatus into 'syncing'.
    const finished = index < shopContents.length / 2

    return {
      shopContent,
      requested: true,
      firstSyncFinishedAt: finished ? new Date(now - day * 3).toISOString() : null,
      lastSyncFinishedAt: finished ? new Date(now - 60000 * (index + 1)).toISOString() : null,
      httpStatus: finished ? 200 : null,
      httpStatusText: finished ? 'OK' : null,
    }
  })
}

/**
 * Mock of the shop URL CloudSync actually synchronizes with, compared against
 * the one registered in PrestaShop Account to detect a mismatch. No endpoint
 * serves it yet.
 */
export function getMockCloudsyncStatus(accountsShopUrl) {
  return {
    // Mirrors the Account URL so the check reads "Match" until a real endpoint
    // provides the URL CloudSync is actually configured with.
    shopUrl: accountsShopUrl,
  }
}

/**
 * Mock of the round trip that asks CloudSync to call the shop's health check
 * front controller from the outside and report back whether it got through.
 *
 * This has to be triggered from CloudSync rather than from the browser: only a
 * request coming from CloudSync's own network can reveal that a WAF, a firewall
 * or a Cloudflare challenge stands between the two. The endpoint does not exist
 * yet, so the shape of the request and of the answer below is provisional.
 */
export async function requestMockServerAccessCheck(healthCheckUrl) {
  await new Promise((resolve) => setTimeout(resolve, 1200))

  return {
    // Echoed back so the UI can show which URL was probed
    probedUrl: healthCheckUrl,
    reachable: false,
    httpStatus: 403,
    blockedBy: 'Cloudflare',
  }
}
