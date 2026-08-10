<template>
  <section class="health-check-section">
    <h3 class="health-check-section__title">
      <PuikIcon icon="monitor_heart" class="health-check-section__title-icon" />
      {{ $t('dashboard.healthCheck.title') }}
    </h3>
    <PuikSpinnerLoader v-if="dashboardStore.healthCheckLoading" size="md" />
    <PuikAlert v-else-if="dashboardStore.healthCheckError" variant="danger">
      {{ dashboardStore.healthCheckError }}
    </PuikAlert>
    <div v-else class="health-check-section__list">
      <HealthCheckItem
        v-for="check in dashboardStore.healthChecks"
        :key="check.id"
        :id="check.id"
        :status="check.status"
        :badge="check.badge"
        :detail="check.detail"
        :action="!!check.action"
        :action-loading="!!check.actionLoading"
        @action="runCheckAction(check)"
      />
    </div>
  </section>
</template>

<script setup>
  import { PuikIcon, PuikSpinnerLoader, PuikAlert } from '@prestashopcorp/puik-components'
  import { useDashboardStore } from '../../stores/dashboard-store'
  import HealthCheckItem from './health-check-item.vue'

  const dashboardStore = useDashboardStore()

  function runCheckAction(check) {
    if (check.action && typeof dashboardStore[check.action] === 'function') {
      dashboardStore[check.action]()
    }
  }
</script>

<style lang="scss" scoped>
  .health-check-section {
    @include dashboard-card;

    &__title {
      @include dashboard-card-title;
    }

    &__title-icon {
      font-size: 20px;
      color: $accent;
    }

    &__list {
      margin-top: 8px;
    }
  }
</style>
