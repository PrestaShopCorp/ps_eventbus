<template>
  <div class="eventbus-header">
    <div class="eventbus-header__content">
      <img :src="appStore.logoUrl" alt="ps_eventbus" class="eventbus-header__logo" />
      <div class="eventbus-header__info">
        <span class="eventbus-header__name">ps_eventbus</span>
        <span class="eventbus-header__version">v{{ appStore.moduleVersion }}</span>
      </div>
    </div>
    <div class="eventbus-header__separator" />
  </div>
</template>

<script setup>
  import { useAppStore } from '../../stores/app-store'

  const appStore = useAppStore()
</script>

<style lang="scss" scoped>
  .eventbus-header {
    &__content {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 20px 24px 16px;
    }

    &__logo {
      width: 40px;
      height: 40px;
      object-fit: contain;
    }

    &__info {
      display: flex;
      flex-direction: column;
    }

    &__name {
      font-size: 16px;
      font-weight: 600;
      color: $text-primary;
      line-height: 1.2;
    }

    &__version {
      font-size: 12px;
      color: $text-secondary;
      line-height: 1.2;
    }

    &__separator {
      height: 1px;
      background-color: #e0e0e0;
    }
  }
</style>
