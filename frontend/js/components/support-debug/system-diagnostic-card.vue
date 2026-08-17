<template>
  <section class="system-diagnostic">
    <div class="system-diagnostic__header">
      <div>
        <h3 class="system-diagnostic__title">
          <PuikIcon icon="cloud_sync" class="system-diagnostic__title-icon" />
          {{ $t('supportDebug.diagnostic.title') }}
        </h3>
        <p class="system-diagnostic__subtitle">{{ $t('supportDebug.diagnostic.subtitle') }}</p>
      </div>
      <PuikButton
        variant="secondary"
        size="sm"
        :left-icon="supportDebugStore.copied ? 'check' : 'content_copy'"
        :disabled="rows.length === 0"
        @click="supportDebugStore.copyDiagnostic(rows)"
      >
        {{ supportDebugStore.copied ? $t('supportDebug.diagnostic.copied') : $t('supportDebug.diagnostic.copy') }}
      </PuikButton>
    </div>

    <PuikSpinnerLoader v-if="supportDebugStore.loading" size="md" />
    <template v-else>
      <PuikAlert v-if="supportDebugStore.error" variant="danger" class="system-diagnostic__alert">
        {{ supportDebugStore.error }}
      </PuikAlert>
      <PuikAlert v-if="supportDebugStore.copyFailed" variant="warning" class="system-diagnostic__alert">
        {{ $t('supportDebug.diagnostic.copyFailed') }}
      </PuikAlert>
      <div v-if="rows.length > 0" class="system-diagnostic__list">
        <!-- `id` identifies the row for the v-for key only; binding it would
             land as a DOM id attribute. -->
        <DiagnosticRow
          v-for="row in rows"
          :key="row.id"
          :label="row.label"
          :hint="row.hint"
          :value="row.value"
          :detail="row.detail"
          :badge="row.badge"
          :status="row.status"
          :muted="row.muted"
          :separated="row.separated"
        />
      </div>
    </template>
  </section>
</template>

<script setup>
  import { computed } from 'vue'
  import { useI18n } from 'vue-i18n'
  import { PuikIcon, PuikButton, PuikSpinnerLoader, PuikAlert } from '@prestashopcorp/puik-components'
  import { useSupportDebugStore } from '../../stores/support-debug-store'
  import DiagnosticRow from './diagnostic-row.vue'

  const { t, te } = useI18n()
  const supportDebugStore = useSupportDebugStore()

  function label(row) {
    if (row.env) return row.id
    if (row.module) return t('supportDebug.rows.moduleVersion', { module: row.module })

    return t(`supportDebug.rows.${row.id}.label`)
  }

  function hint(row) {
    if (row.minPhpVersion) return t('supportDebug.rows.phpVersion.minimum', { version: row.minPhpVersion })

    const hintKey = `supportDebug.rows.${row.id}.hint`

    return te(hintKey) ? t(hintKey) : ''
  }

  // Worded here, then handed back to the store for the clipboard, so the ticket
  // and the page say the same thing.
  const rows = computed(() => supportDebugStore.rows.map((row) => ({ ...row, label: label(row), hint: hint(row) })))
</script>

<style lang="scss" scoped>
  .system-diagnostic {
    @include dashboard-card;

    &__header {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 16px;
    }

    &__title {
      @include dashboard-card-title;
    }

    &__title-icon {
      font-size: 20px;
      color: $accent;
    }

    &__subtitle {
      margin: 6px 0 0;
      font-size: 13px;
      color: $text-secondary;
    }

    &__alert {
      margin-top: 16px;
    }

    &__list {
      margin-top: 16px;
    }
  }
</style>
