<template>
  <div class="eventbus-page">
    <SystemDiagnosticCard />

    <PuikAlert
      variant="info"
      :description="$t('supportDebug.help.description')"
      :link-label="$t('supportDebug.help.linkLabel')"
      :external-link="careCenterUrl"
      right-icon-link="open_in_new"
    />
  </div>
</template>

<script setup>
  import { computed, onMounted } from 'vue'
  import { PuikAlert } from '@prestashopcorp/puik-components'
  import { useAppStore } from '../../stores/app-store'
  import { useSupportDebugStore } from '../../stores/support-debug-store'
  import SystemDiagnosticCard from '../../components/support-debug/system-diagnostic-card.vue'

  /**
   * Care Center entry points, listed one by one rather than derived from the
   * locale: the path segments (`connexion`, `nous-contacter`) are themselves
   * translated, so substituting the language segment would produce 404s. Any
   * locale without its own entry falls back to the French one, which exists.
   */
  const CARE_CENTER_URLS = {
    fr: 'https://care-center.prestashop.com/fr/connexion?back=https%3A%2F%2Fcare-center.prestashop.com%2Ffr%2Fnous-contacter',
  }

  const appStore = useAppStore()
  const supportDebugStore = useSupportDebugStore()

  const careCenterUrl = computed(() => CARE_CENTER_URLS[appStore.isoCode] ?? CARE_CENTER_URLS.fr)

  onMounted(() => {
    supportDebugStore.loadDiagnostic()
  })
</script>

<style lang="scss" scoped>
  .eventbus-page {
    padding: 24px;
  }
</style>
