import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { router } from './router'
import Index from './pages/index.vue'
import i18n, { loadLocaleMessages } from './i18n'

const locale = globalThis.eventbusConfig?.isoCode ?? 'en'

const app = createApp(Index)
const pinia = createPinia()

app.use(pinia)
app.use(router)
app.use(i18n)

await loadLocaleMessages(i18n, locale)

app.mount('#vue-app')
