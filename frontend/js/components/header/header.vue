<template>
  <header class="eventbus-header">
    <div class="eventbus-header__content">
      <span class="eventbus-header__logo-wrapper">
        <img :src="appStore.logoUrl" alt="ps_eventbus" class="eventbus-header__logo" />
      </span>
      <div class="eventbus-header__info">
        <span class="eventbus-header__name">{{ $t('header.title') }}</span>
        <span class="eventbus-header__version">v{{ appStore.moduleVersion }}</span>
      </div>
    </div>
    <div class="eventbus-header__separator" />
  </header>
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
      gap: 16px;
      padding: 24px 32px 20px;
    }

    &__logo-wrapper {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 56px;
      height: 56px;
      flex-shrink: 0;
      border-radius: 50%;
      background-color: $accent-soft;
    }

    &__logo {
      width: 32px;
      height: 32px;
      object-fit: contain;
    }

    &__info {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    &__name {
      font-size: 15px;
      font-weight: 700;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: $text-primary;
      line-height: 1.2;
    }

    &__version {
      font-size: 12px;
      color: $text-secondary;
      line-height: 1.2;
    }
  }
</style>
