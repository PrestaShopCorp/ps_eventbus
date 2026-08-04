<template>
  <div class="health-check-item">
    <PuikIcon :icon="icon" :class="['health-check-item__icon', `health-check-item__icon--${props.status}`]" />
    <div class="health-check-item__text">
      <span class="health-check-item__label">
        {{ $t(`dashboard.healthCheck.checks.${props.id}.label`) }}
        <span v-if="hint" class="health-check-item__hint">{{ hint }}</span>
      </span>
      <span v-if="props.detail" class="health-check-item__detail">{{ props.detail }}</span>
    </div>
    <div class="health-check-item__aside">
      <PuikTag v-if="props.badge" :content="$t(`dashboard.healthCheck.badges.${props.badge}`)" :variant="tagVariant" />
      <PuikButton v-if="props.action" variant="tertiary" size="sm" :loading="props.actionLoading" :disabled="props.actionLoading" @click="emit('action')">
        {{ $t(`dashboard.healthCheck.checks.${props.id}.action`) }}
      </PuikButton>
    </div>
  </div>
</template>

<script setup>
  import { computed } from 'vue'
  import { useI18n } from 'vue-i18n'
  import { PuikIcon, PuikTag, PuikButton } from '@prestashopcorp/puik-components'

  const { t, te } = useI18n()

  const props = defineProps({
    id: { type: String, required: true },
    status: { type: String, default: 'ok' },
    badge: { type: String, default: '' },
    detail: { type: String, default: '' },
    action: { type: Boolean, default: false },
    actionLoading: { type: Boolean, default: false },
  })

  const emit = defineEmits(['action'])

  const icons = {
    ok: 'check_circle',
    warning: 'warning',
    error: 'cancel',
    idle: 'help',
  }

  // PuikTag only ships colour names, not semantic variants
  const variants = {
    ok: 'green',
    warning: 'yellow',
    error: 'neutral',
    idle: 'neutral',
  }

  const icon = computed(() => icons[props.status] ?? icons.ok)
  const tagVariant = computed(() => variants[props.status] ?? 'neutral')

  const hint = computed(() => {
    const key = `dashboard.healthCheck.checks.${props.id}.hint`

    return te(key) ? t(key) : ''
  })
</script>

<style lang="scss" scoped>
  .health-check-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 0;
    border-bottom: 1px solid $row-border;

    &:last-child {
      border-bottom: none;
    }

    &__icon {
      font-size: 20px;
      flex-shrink: 0;

      &--ok {
        color: $status-ok;
      }

      &--warning {
        color: $status-warning;
      }

      &--error {
        color: $status-error;
      }

      &--idle {
        color: $text-secondary;
      }
    }

    &__text {
      display: flex;
      flex-direction: column;
      gap: 2px;
      min-width: 0;
    }

    &__label {
      font-size: 14px;
      color: $text-primary;
    }

    &__hint {
      margin-left: 6px;
      font-size: 13px;
      color: $text-secondary;
    }

    &__detail {
      font-size: 12px;
      color: $text-secondary;
    }

    &__aside {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-left: auto;
      flex-shrink: 0;
    }
  }
</style>
