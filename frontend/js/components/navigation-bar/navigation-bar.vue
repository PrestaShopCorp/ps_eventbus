<script setup>
  import { PuikTabNavigation, PuikTabNavigationGroupTitles, PuikTabNavigationTitle, PuikIcon, PuikTooltip } from '@prestashopcorp/puik-components'
  import { computed } from 'vue'
  import { useI18n } from 'vue-i18n'
  import { useRouter, useRoute } from 'vue-router'
  import { useAppStore } from '../../stores/app-store'

  const { t } = useI18n()
  const router = useRouter()
  const route = useRoute()
  const appStore = useAppStore()

  const navigationOrder = ['dashboard', 'connections', 'supportDebug']

  const navigationIcons = {
    dashboard: 'dashboard',
    connections: 'handyman',
    supportDebug: 'bug_report',
  }

  /**
   * Connections needs a shop UUID to query CloudSync. Without one the page has
   * nothing to show, so the tab is disabled and explains why on hover.
   */
  function disabledReason(routeName) {
    if (routeName !== 'connections' || appStore.connectionsAvailable) return ''

    return appStore.psAccountsInstalled ? t('tabs.disabled.shopNotLinked') : t('tabs.disabled.noAccountModule')
  }

  const visibleRoutes = computed(() => {
    const allRoutes = router.getRoutes()

    return navigationOrder
      .map((name) => allRoutes.find((r) => r.name === name))
      .filter(Boolean)
      .map((r, index) => ({
        ...r,
        position: index,
        icon: navigationIcons[r.name],
        disabled: r.name === 'connections' && !appStore.connectionsAvailable,
        disabledReason: disabledReason(r.name),
      }))
  })

  const currentRoutePosition = computed(() => {
    const current = visibleRoutes.value.find((visibleRoute) => visibleRoute.name === route.name)
    return current ? Number(current.position) : 0
  })

  function onTabChange(tabId) {
    const nextRoute = visibleRoutes.value.find((r) => r.position === tabId)
    if (!nextRoute || nextRoute.disabled || nextRoute.name === route.name) return
    router.push({ name: nextRoute.name })
  }
</script>

<template>
  <PuikTabNavigation
    name="app-navigation"
    id="eventbus-tabs"
    :key="currentRoutePosition"
    :default-position="currentRoutePosition"
    @change-active-tab="onTabChange"
  >
    <PuikTabNavigationGroupTitles aria-label="navigation">
      <PuikTabNavigationTitle v-for="r in visibleRoutes" :key="r.path" :position="r.position" :disabled="r.disabled">
        <!-- A disabled <button> emits no hover events, so the tooltip has to wrap
             the label rather than the tab itself. -->
        <PuikTooltip v-if="r.disabled" :description="r.disabledReason" position="bottom">
          <span class="eventbus-tab">
            <PuikIcon v-if="r.icon" :icon="r.icon" class="eventbus-tab__icon" />
            {{ $t(`tabs.${r.name}`) }}
          </span>
        </PuikTooltip>
        <span v-else class="eventbus-tab">
          <PuikIcon v-if="r.icon" :icon="r.icon" class="eventbus-tab__icon" />
          {{ $t(`tabs.${r.name}`) }}
        </span>
      </PuikTabNavigationTitle>
    </PuikTabNavigationGroupTitles>
  </PuikTabNavigation>
</template>

<style lang="scss" scoped>
  #eventbus-tabs {
    background-color: $background-primary;
    border-bottom: 1px solid $card-border;
    border-top: 1px solid $card-border;
    padding-left: 10px;
  }

  .eventbus-tab {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    &__icon {
      font-size: 20px;
    }
  }
</style>
