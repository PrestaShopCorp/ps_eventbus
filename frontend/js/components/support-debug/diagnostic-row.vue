<template>
  <div :class="['diagnostic-row', { 'diagnostic-row--separated': props.separated }]">
    <span class="diagnostic-row__label">
      {{ props.label }}
      <span v-if="props.hint" class="diagnostic-row__hint">{{ props.hint }}</span>
    </span>
    <div class="diagnostic-row__aside">
      <span v-if="props.detail" class="diagnostic-row__detail">{{ props.detail }}</span>
      <span v-if="props.value" :class="['diagnostic-row__value', { 'diagnostic-row__value--muted': props.muted }]">
        {{ props.value }}
      </span>
      <PuikTag v-if="props.badge" :content="$t(`supportDebug.badges.${props.badge}`)" :variant="tagVariant" />
    </div>
  </div>
</template>

<script setup>
  import { computed } from 'vue'
  import { PuikTag } from '@prestashopcorp/puik-components'

  const props = defineProps({
    label: { type: String, required: true },
    hint: { type: String, default: '' },
    value: { type: String, default: '' },
    detail: { type: String, default: '' },
    badge: { type: String, default: '' },
    status: { type: String, default: 'neutral' },
    muted: { type: Boolean, default: false },
    separated: { type: Boolean, default: false },
  })

  // PuikTag only ships colour names, not semantic variants — and has no red,
  // hence `neutral` for errors, the same mapping the dashboard already uses.
  const variants = {
    ok: 'green',
    warning: 'yellow',
    error: 'neutral',
    neutral: 'neutral',
  }

  const tagVariant = computed(() => variants[props.status] ?? 'neutral')
</script>

<style lang="scss" scoped>
  .diagnostic-row {
    display: flex;
    align-items: center;
    gap: $row-gap;
    padding: 12px 0;
    border-bottom: 1px solid $row-border;

    &:last-child {
      border-bottom: none;
    }

    // The two shop URLs sit apart from the module's own configuration
    &--separated {
      margin-top: 12px;
      border-top: 1px solid $card-border;
      padding-top: 20px;
    }

    &__label {
      font-size: 14px;
      color: $text-primary;
      min-width: 0;
    }

    &__hint {
      margin-left: 6px;
      font-size: 13px;
      color: $text-secondary;
    }

    &__aside {
      display: flex;
      align-items: center;
      gap: $row-gap;
      margin-left: auto;
      flex-shrink: 0;
      min-width: 0;
    }

    &__detail {
      font-size: 12px;
      color: $text-secondary;
      overflow-wrap: anywhere;
    }

    &__value {
      font-size: 14px;
      color: $text-primary;
      overflow-wrap: anywhere;

      &--muted {
        color: $text-secondary;
      }
    }
  }
</style>
