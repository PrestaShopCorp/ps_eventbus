/**
 * Centralized client for admin AJAX calls to AdminPsEventbusController.
 *
 * All requests go through the single `ajaxProcessDispatch` entry point.
 * The action name is sent in the JSON body and dispatched server-side
 * against an explicit allowlist.
 */
import { useAppStore } from '../stores/app-store'

/**
 * @param {string} action  Must be in the controller's allowlist
 * @param {object} [data]  Extra payload merged into the request body
 */
export async function callAjax(action, data) {
  const appStore = useAppStore()
  const url = appStore.eventbusAjaxPath + '&action=dispatch&ajax=1'

  const response = await fetch(url, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ action, ...data }),
  })

  const body = await response.text()
  let parsed

  try {
    parsed = JSON.parse(body)
  } catch {
    throw new Error(
      'Unexpected response from the AJAX endpoint '
      + '(HTTP ' + response.status + '): '
      + body.slice(0, 200),
    )
  }

  if (parsed.error) {
    throw new Error(parsed.message || 'Unknown error')
  }

  return parsed
}
