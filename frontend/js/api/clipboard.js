/**
 * Copy text to the clipboard.
 *
 * The PrestaShop back office is not always served over HTTPS, and
 * `navigator.clipboard` does not exist outside a secure context — which would
 * leave the copy button inert on exactly the shops that end up contacting
 * support. Hence the deprecated `execCommand` fallback.
 *
 * @param {string} text
 * @returns {Promise<boolean>}  Whether the text made it to the clipboard
 */
export async function copyToClipboard(text) {
  if (globalThis.navigator?.clipboard?.writeText) {
    try {
      await globalThis.navigator.clipboard.writeText(text)

      return true
    } catch {
      // Permission denied or insecure context: fall through
    }
  }

  return copyWithTextarea(text)
}

/**
 * @param {string} text
 * @returns {boolean}
 */
function copyWithTextarea(text) {
  const textarea = document.createElement('textarea')

  textarea.value = text
  textarea.setAttribute('readonly', '')
  // Off-screen rather than hidden: a display:none element cannot be selected
  textarea.style.position = 'fixed'
  textarea.style.top = '-1000px'
  textarea.style.opacity = '0'

  document.body.appendChild(textarea)

  try {
    textarea.select()
    textarea.setSelectionRange(0, text.length)

    return document.execCommand('copy')
  } catch {
    return false
  } finally {
    document.body.removeChild(textarea)
  }
}
