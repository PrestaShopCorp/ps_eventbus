/**
 * Contents no third-party module asked for, so CloudSync never collects them.
 * Mocked selection, for the sake of the example.
 */
const MOCK_NOT_REQUESTED = ['wishlists', 'wishlist_products', 'employees', 'translations', 'taxonomies', 'stock_movements']

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
