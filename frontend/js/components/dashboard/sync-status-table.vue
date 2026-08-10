<template>
  <section class="sync-status-table">
    <h3 class="sync-status-table__title">
      <PuikIcon icon="sync" class="sync-status-table__title-icon" />
      {{ $t('dashboard.syncTable.title') }}
    </h3>
    <p class="sync-status-table__subtitle">{{ $t('dashboard.syncTable.subtitle') }}</p>
    <PuikSpinnerLoader v-if="dashboardStore.syncSummaryLoading" size="md" />
    <PuikAlert v-else-if="dashboardStore.syncSummaryError" variant="danger">
      {{ dashboardStore.syncSummaryError }}
    </PuikAlert>
    <div v-else-if="dashboardStore.syncSummary.length === 0" class="sync-status-table__empty">
      {{ $t('dashboard.syncTable.empty') }}
    </div>
    <ul v-else class="sync-status-table__list">
      <li
        v-for="item in dashboardStore.requestedSyncSummary"
        :key="item.shopContent"
        class="sync-status-table__row"
      >
        <span class="sync-status-table__content-type">{{ item.shopContent }}</span>
        <PuikTag :content="getStatusLabel(item)" :variant="getStatusVariant(item)" class="sync-status-table__badge" />
      </li>
    </ul>
  </section>
</template>

<script setup>
  import { PuikIcon, PuikSpinnerLoader, PuikAlert, PuikTag } from '@prestashopcorp/puik-components'
  import { useI18n } from 'vue-i18n'
  import { useDashboardStore } from '../../stores/dashboard-store'

  const { t } = useI18n()
  const dashboardStore = useDashboardStore()

  function getStatusVariant(item) {
    if (!item.httpStatus) return 'neutral'
    if (item.httpStatus >= 400) return 'yellow'

    return 'green'
  }

  function getStatusLabel(item) {
    if (!item.httpStatus) return t('dashboard.syncStatus.pending')

    return `${item.httpStatus} — ${item.httpStatusText}`
  }
</script>

<style lang="scss" scoped>
  .sync-status-table {
    @include dashboard-card;

    &__title {
      @include dashboard-card-title;
    }

    &__title-icon {
      font-size: 20px;
      color: $accent;
    }

    &__subtitle {
      margin: 6px 0 12px;
      font-size: 13px;
      color: $text-secondary;
    }

    &__empty {
      padding: 24px;
      text-align: center;
      color: $text-secondary;
    }

    &__list {
      margin: 0;
      padding: 0;
      list-style: none;
    }

    &__row {
      display: flex;
      align-items: center;
      gap: $row-gap;
      padding: 14px 0;
      border-bottom: 1px solid $row-border;

      &:last-child {
        border-bottom: none;
      }
    }

    &__content-type {
      font-size: 14px;
      color: $text-primary;
    }

    &__badge {
      margin-left: auto;
      flex-shrink: 0;
    }
  }
</style>
