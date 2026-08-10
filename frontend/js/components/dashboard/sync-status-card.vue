<template>
  <section class="sync-status-card">
    <PuikSpinnerLoader v-if="dashboardStore.syncSummaryLoading" size="md" />
    <PuikAlert v-else-if="dashboardStore.syncSummaryError" variant="danger">
      {{ dashboardStore.syncSummaryError }}
    </PuikAlert>
    <template v-else>
      <PuikIcon :icon="state.icon" :class="['sync-status-card__icon', `sync-status-card__icon--${state.tone}`]" />
      <h3 class="sync-status-card__title">{{ state.title }}</h3>
      <p class="sync-status-card__description">{{ state.description }}</p>
      <div v-if="state.showProgress" class="sync-status-card__progress">
        <PuikProgressBar :percentage="dashboardStore.syncProgress" class="sync-status-card__bar" />
        <span class="sync-status-card__percentage">{{ dashboardStore.syncProgress }}%</span>
      </div>
    </template>
  </section>
</template>

<script setup>
  import { computed } from 'vue'
  import { useI18n } from 'vue-i18n'
  import { PuikIcon, PuikProgressBar, PuikSpinnerLoader, PuikAlert } from '@prestashopcorp/puik-components'
  import { useDashboardStore, SYNC_STATUS } from '../../stores/dashboard-store'

  const { t } = useI18n()
  const dashboardStore = useDashboardStore()

  const lastSyncedLabel = computed(() => {
    const ts = dashboardStore.lastSyncedAt
    if (!ts) return ''

    const diffMin = Math.floor((Date.now() - ts) / 60000)
    const diffHours = Math.floor(diffMin / 60)
    const diffDays = Math.floor(diffHours / 24)

    if (diffMin < 1) return t('dashboard.timeAgo.justNow')
    if (diffMin < 60) return t('dashboard.timeAgo.minutesAgo', { n: diffMin })
    if (diffHours < 24) return t('dashboard.timeAgo.hoursAgo', { n: diffHours })

    return t('dashboard.timeAgo.daysAgo', { n: diffDays })
  })

  /**
   * The card covers the whole lifecycle of the sync:
   * - initial: first import still running, show the progress bar
   * - incremental: everything imported, changes are streamed continuously
   * - failed / offboarded: nothing is flowing
   */
  const state = computed(() => {
    const status = dashboardStore.globalSyncStatus

    if (status === SYNC_STATUS.syncing) {
      return {
        icon: 'rocket_launch',
        tone: 'accent',
        title: t('dashboard.syncCard.initial.title'),
        description: t('dashboard.syncCard.initial.description'),
        showProgress: true,
      }
    }

    if (status === SYNC_STATUS.synced) {
      return {
        icon: 'cloud_done',
        tone: 'ok',
        title: t('dashboard.syncCard.incremental.title'),
        description: lastSyncedLabel.value
          ? t('dashboard.syncCard.incremental.descriptionWithTime', { time: lastSyncedLabel.value })
          : t('dashboard.syncCard.incremental.description'),
        showProgress: false,
      }
    }

    if (status === SYNC_STATUS.failed) {
      return {
        icon: 'error',
        tone: 'error',
        title: t('dashboard.syncCard.failed.title'),
        description: t('dashboard.syncCard.failed.description'),
        showProgress: false,
      }
    }

    return {
      icon: 'cloud_off',
      tone: 'neutral',
      title: t('dashboard.syncCard.offboarded.title'),
      description: t('dashboard.syncCard.offboarded.description'),
      showProgress: false,
    }
  })
</script>

<style lang="scss" scoped>
  .sync-status-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 32px 24px 36px;
    margin-bottom: 24px;
    background-color: $card-background;
    border: 1px solid $card-border;
    border-radius: $card-radius;
    box-shadow: $card-shadow;
    text-align: center;

    &__icon {
      font-size: 32px;
      margin-bottom: 12px;

      &--accent {
        color: $accent;
      }

      &--ok {
        color: $status-ok;
      }

      &--error {
        color: $status-error;
      }

      &--neutral {
        color: $text-secondary;
      }
    }

    &__title {
      margin: 0 0 8px;
      font-size: 15px;
      font-weight: 700;
      color: $text-primary;
    }

    &__description {
      max-width: 480px;
      margin: 0;
      font-size: 13px;
      line-height: 1.5;
      color: $text-secondary;
    }

    &__progress {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      width: 100%;
      max-width: 380px;
      margin-top: 24px;
    }

    // The Puik track has no intrinsic width, so it collapses inside a centered
    // flex column unless it is stretched explicitly.
    &__bar {
      width: 100%;

      :deep(.progress-bar__content) {
        background-color: $accent;
      }
    }

    &__percentage {
      font-size: 12px;
      font-weight: 600;
      color: $text-secondary;
    }
  }
</style>
