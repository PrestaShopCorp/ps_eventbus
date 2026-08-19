import { test, describe } from 'node:test'
import assert from 'node:assert/strict'
import { debugRequestedInSearch, resolveNavigation } from './navigation.js'

/**
 * Stands in for the Pinia store, implementing the contract `resolveNavigation`
 * relies on: the redirect is answered once, and answering it unlocks the page.
 */
function storeDouble({ redirectPending = false, unlocked = false, connectionsAvailable = true } = {}) {
  return {
    supportDebugRedirectPending: redirectPending,
    supportDebugUnlocked: unlocked,
    connectionsAvailable,

    consumeSupportDebugRedirect() {
      if (!this.supportDebugRedirectPending) return false

      this.supportDebugRedirectPending = false
      this.unlockSupportDebug()

      return true
    },

    unlockSupportDebug() {
      this.supportDebugUnlocked = true
    },
  }
}

const route = (name, query = {}) => ({ name, query })

describe('debugRequestedInSearch', () => {
  test('accepts debug=1 as a query parameter of the admin URL', () => {
    assert.equal(debugRequestedInSearch('?controller=AdminPsEventbus&token=abc123&debug=1'), true)
  })

  test('rejects a second "?" swallowing debug into the token value', () => {
    assert.equal(debugRequestedInSearch('?controller=AdminPsEventbus&token=abc123?debug=1'), false)
  })

  test('rejects an admin URL without the parameter', () => {
    assert.equal(debugRequestedInSearch('?controller=AdminPsEventbus&token=abc123'), false)
  })

  test('rejects other values', () => {
    assert.equal(debugRequestedInSearch('?debug=0'), false)
    assert.equal(debugRequestedInSearch('?debug'), false)
  })

  test('tolerates a missing search string', () => {
    assert.equal(debugRequestedInSearch(''), false)
    assert.equal(debugRequestedInSearch(undefined), false)
  })
})

describe('resolveNavigation, support & debug unlocking', () => {
  test('redirects to support & debug when the admin URL carried debug=1', () => {
    const appStore = storeDouble({ redirectPending: true })

    assert.deepEqual(resolveNavigation(route('dashboard'), appStore), { name: 'supportDebug', query: { debug: '1' } })
    assert.equal(appStore.supportDebugUnlocked, true)
  })

  test('redirects to support & debug when debug=1 sits in the hash of another route', () => {
    const appStore = storeDouble()

    assert.deepEqual(resolveNavigation(route('dashboard', { debug: '1' }), appStore), { name: 'supportDebug', query: { debug: '1' } })
    assert.equal(appStore.supportDebugUnlocked, true)
  })

  test('redirects from the connections route too, disabled or not', () => {
    const appStore = storeDouble({ connectionsAvailable: false })

    assert.deepEqual(resolveNavigation(route('connections', { debug: '1' }), appStore), { name: 'supportDebug', query: { debug: '1' } })
    assert.equal(appStore.supportDebugUnlocked, true)
  })

  test('unlocks and allows the page when debug=1 is on the support & debug route itself', () => {
    const appStore = storeDouble()

    assert.equal(resolveNavigation(route('supportDebug', { debug: '1' }), appStore), true)
    assert.equal(appStore.supportDebugUnlocked, true)
  })

  test('does not redirect the route it would redirect to, so the guard settles', () => {
    const appStore = storeDouble({ redirectPending: true })
    const target = resolveNavigation(route('dashboard'), appStore)

    assert.equal(resolveNavigation(route(target.name, target.query), appStore), true)
  })

  test('lets the merchant navigate away once the redirect has been answered', () => {
    const appStore = storeDouble({ redirectPending: true })

    resolveNavigation(route('dashboard'), appStore)

    assert.equal(resolveNavigation(route('dashboard'), appStore), true)
  })
})

describe('resolveNavigation, locked support & debug', () => {
  test('sends a hand-typed support & debug URL back to the dashboard', () => {
    assert.deepEqual(resolveNavigation(route('supportDebug'), storeDouble()), { name: 'dashboard' })
  })

  test('allows the page once unlocked, without the parameter', () => {
    assert.equal(resolveNavigation(route('supportDebug'), storeDouble({ unlocked: true })), true)
  })
})

describe('resolveNavigation, connections', () => {
  test('sends a hand-typed connections URL back to the dashboard when unavailable', () => {
    assert.deepEqual(resolveNavigation(route('connections'), storeDouble({ connectionsAvailable: false })), { name: 'dashboard' })
  })

  test('allows connections when available', () => {
    assert.equal(resolveNavigation(route('connections'), storeDouble({ connectionsAvailable: true })), true)
  })
})

describe('resolveNavigation, dashboard', () => {
  test('always allows the dashboard', () => {
    assert.equal(resolveNavigation(route('dashboard'), storeDouble()), true)
  })
})
