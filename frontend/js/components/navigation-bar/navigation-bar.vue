<script setup>
  import { PuikTabNavigation, PuikTabNavigationGroupTitles, PuikTabNavigationTitle, PuikIcon } from '@prestashopcorp/puik-components'
  import { computed } from 'vue'
  import { useRouter, useRoute } from 'vue-router'

  const router = useRouter()
  const route = useRoute()

  const navigationOrder = ['dashboard', 'connections', 'supportDebug']

  const navigationIcons = {
    dashboard: 'dashboard',
    connections: 'handyman',
    supportDebug: 'bug_report',
  }

  const visibleRoutes = computed(() => {
    const allRoutes = router.getRoutes()

    return navigationOrder
      .map((name) => allRoutes.find((r) => r.name === name))
      .filter(Boolean)
      .map((r, index) => ({ ...r, position: index, icon: navigationIcons[r.name] }))
  })

  const currentRoutePosition = computed(() => {
    const current = visibleRoutes.value.find((visibleRoute) => visibleRoute.name === route.name)
    return current ? Number(current.position) : 0
  })

  function onTabChange(tabId) {
    const nextRoute = visibleRoutes.value.find((r) => r.position === tabId)
    if (!nextRoute || nextRoute.name === route.name) return
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
      <PuikTabNavigationTitle v-for="r in visibleRoutes" :key="r.path" :position="r.position">
        <span class="eventbus-tab">
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
