<template>
  <div class="eventbus-app">
    <NavigationBar />
    <router-view id="router-view" />
  </div>
</template>

<script setup>
  import '~/@prestashopcorp/puik-theme/dist/index.css'
  import NavigationBar from '../components/navigation-bar/navigation-bar.vue'
</script>

<style lang="scss">
  .eventbus-app {
    background: $background-primary;
    min-height: 200px;
  }

  #router-view {
    padding: 24px;
  }
</style>
