/**
 * Navigation rules, kept free of Vue, Pinia and browser imports so they can be
 * unit-tested with plain Node. The router wires them in `router.js`, the store
 * reads the admin URL through `debugRequestedInSearch`.
 */

/**
 * Used on the admin URL's own query string — the part before the hash, which
 * the hash router never sees.
 */
export function debugRequestedInSearch(search) {
  return new URLSearchParams(search ?? '').get('debug') === '1'
}

/**
 * Decides what the router should do with an incoming route: `true` to let it
 * through, or the route to go to instead.
 */
export function resolveNavigation(to, appStore) {
  // Two ways to ask for Support & debug, both of which unlock the page and land
  // on it, whatever route was asked for: `&debug=1` on the admin URL, answered
  // once by the store, and `debug=1` in the hash — the form you get by appending
  // it to the URL the browser displays, which already ends with `#/dashboard`.
  //
  // The admin URL is answered only on the first navigation: the tab is unlocked
  // from then on, and must stay navigable away from.
  const debugRequested = appStore.consumeSupportDebugRedirect() || to.query?.debug === '1'

  if (debugRequested) appStore.unlockSupportDebug()

  // Support & debug has no tab until it is unlocked.
  if (to.name === 'supportDebug') {
    return appStore.supportDebugUnlocked ? true : { name: 'dashboard' }
  }

  // The parameter is deliberately carried over, so the URL stays copyable.
  if (debugRequested) {
    return { name: 'supportDebug', query: { debug: '1' } }
  }

  // The tab is already disabled, but the hash URL can still be typed by hand.
  if (to.name === 'connections') {
    return appStore.connectionsAvailable ? true : { name: 'dashboard' }
  }

  return true
}
