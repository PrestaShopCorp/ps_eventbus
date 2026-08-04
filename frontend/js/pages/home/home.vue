<template>
  <div class="eventbus-page">
    <SyncStatusCard />
    <HealthCheckSection />
    <SyncStatusTable />
  </div>
</template>

<script setup>
  import { onMounted } from 'vue'
  import { useDashboardStore } from '../../stores/dashboard-store'
  import SyncStatusCard from '../../components/dashboard/sync-status-card.vue'
  import HealthCheckSection from '../../components/dashboard/health-check-section.vue'
  import SyncStatusTable from '../../components/dashboard/sync-status-table.vue'

  const dashboardStore = useDashboardStore()

  onMounted(() => {
    dashboardStore.loadDashboard()
  })
</script>
