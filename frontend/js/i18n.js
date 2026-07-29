import { createI18n } from 'vue-i18n'

const locale = globalThis.eventbusConfig?.isoCode ?? 'en'

export async function loadLocaleMessages(i18n, locale) {
  try {
    if (!i18n.global.availableLocales.includes(locale)) {
      const messages = await import(`../translations/${locale}.json`)
      i18n.global.setLocaleMessage(locale, messages.default)
    }
    i18n.global.locale = locale
    return
  } catch {
    if (!i18n.global.availableLocales.includes('en')) {
      const messages = await import('../translations/en.json')
      i18n.global.setLocaleMessage('en', messages.default)
    }
    i18n.global.locale = 'en'
  }
}

const i18n = createI18n({
  locale,
  fallbackLocale: 'en',
  globalInjection: true,
  messages: {},
})

export default i18n
