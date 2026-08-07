<template>
  <li :class="['connection-item', { 'connection-item--revoked': isRevoked }]">
    <img
      v-if="props.service.logoUrl && !logoFailed"
      :src="props.service.logoUrl"
      :alt="props.service.displayName"
      class="connection-item__logo"
      @error="logoFailed = true"
    />
    <PuikAvatar v-else type="initials" size="medium" single-initial :first-name="props.service.displayName" class="connection-item__logo" />

    <div class="connection-item__body">
      <div class="connection-item__heading">
        <span class="connection-item__name">{{ props.service.displayName }}</span>
        <PuikTag v-if="isRevoked" :content="$t('connections.revoked')" variant="neutral" />
      </div>
      <span class="connection-item__module-id">
        {{ $t('connections.moduleId', { moduleName: props.service.moduleName }) }}
      </span>
      <span v-if="isRevoked" class="connection-item__revoked-on">
        {{ $t('connections.revokedOn', { date: revokedOn }) }}
      </span>
      <ul v-else-if="props.service.consents.length" class="connection-item__consents">
        <li v-for="consent in props.service.consents" :key="consent">
          <PuikTag :content="consent" variant="neutral" />
        </li>
      </ul>
    </div>
  </li>
</template>

<script setup>
  import { computed, ref } from 'vue'
  import { useI18n } from 'vue-i18n'
  import { PuikAvatar, PuikTag } from '@prestashopcorp/puik-components'

  const { locale } = useI18n()

  const props = defineProps({
    service: { type: Object, required: true },
  })

  // A module can be installed and still ship no logo.png: falling back to the
  // avatar beats showing a broken image.
  const logoFailed = ref(false)

  const isRevoked = computed(() => !!props.service.revokedAt)

  const revokedOn = computed(() => {
    const date = new Date(props.service.revokedAt)

    if (Number.isNaN(date.getTime())) return props.service.revokedAt

    return new Intl.DateTimeFormat(locale.value, { year: 'numeric', month: 'short', day: 'numeric' }).format(date)
  })
</script>

<style lang="scss" scoped>
  .connection-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px 0;
    border-bottom: 1px solid $row-border;

    &:last-child {
      border-bottom: none;
    }

    &--revoked {
      opacity: 0.5;
    }

    &__logo {
      width: 32px;
      height: 32px;
      flex-shrink: 0;
      object-fit: contain;
      border-radius: 4px;
    }

    &__body {
      display: flex;
      flex-direction: column;
      gap: 4px;
      min-width: 0;
    }

    &__heading {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    &__name {
      font-size: 14px;
      font-weight: 600;
      color: $text-primary;
    }

    &__module-id,
    &__revoked-on {
      font-size: 12px;
      color: $text-secondary;
    }

    &__consents {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      margin: 4px 0 0;
      padding: 0;
      list-style: none;
    }
  }
</style>
