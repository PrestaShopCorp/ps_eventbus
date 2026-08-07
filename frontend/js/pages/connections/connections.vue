<template>
  <div class="eventbus-page">
    <section class="connections">
      <h3 class="connections__title">
        <PuikIcon icon="verified_user" class="connections__title-icon" />
        {{ $t('connections.title') }}
      </h3>
      <p class="connections__intro">{{ $t('connections.intro') }}</p>

      <PuikSpinnerLoader v-if="connectionsStore.loading" size="md" />
      <PuikAlert v-else-if="connectionsStore.error" variant="danger">
        {{ connectionsStore.error }}
      </PuikAlert>
      <div v-else-if="connectionsStore.services.length === 0" class="connections__empty">
        {{ $t('connections.empty') }}
      </div>
      <ul v-else class="connections__list">
        <ConnectionItem v-for="service in connectionsStore.services" :key="service.moduleName" :service="service" />
      </ul>
    </section>

    <PuikAlert
      variant="info"
      :title="$t('connections.defaultSync.title')"
      :description="$t('connections.defaultSync.description', { contents: defaultContents })"
    />
  </div>
</template>

<script setup>
  import { computed, onMounted } from 'vue'
  import { PuikIcon, PuikSpinnerLoader, PuikAlert } from '@prestashopcorp/puik-components'
  import { useAppStore } from '../../stores/app-store'
  import { useConnectionsStore } from '../../stores/connections-store'
  import ConnectionItem from '../../components/connections/connection-item.vue'

  const appStore = useAppStore()
  const connectionsStore = useConnectionsStore()

  const defaultContents = computed(() => appStore.defaultSyncedShopContents.join(', '))

  onMounted(() => {
    connectionsStore.loadConnections()
  })
</script>

<style lang="scss" scoped>
  .eventbus-page {
    padding: 24px;
  }

  .connections {
    @include dashboard-card;

    &__title {
      @include dashboard-card-title;
    }

    &__title-icon {
      font-size: 20px;
      color: $accent;
    }

    &__intro {
      margin: 8px 0 4px;
      font-size: 13px;
      color: $text-secondary;
    }

    &__empty {
      padding: 24px;
      text-align: center;
      color: $text-secondary;
    }

    &__list {
      margin: 8px 0 0;
      padding: 0;
      list-style: none;
    }
  }
</style>
