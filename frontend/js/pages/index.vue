<template>
  <div class="eventbus-app">
    <router-view />
  </div>
</template>

<script setup>
  import '~/@prestashopcorp/puik-theme/dist/index.css'
</script>

<style lang="scss" scoped>
  .eventbus-app {
    background: $background-primary;
    min-height: 200px;
  }
</style>
