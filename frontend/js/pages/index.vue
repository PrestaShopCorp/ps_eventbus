<template>
  <div class="eventbus-app">
    <Header />
    <NavigationBar />
    <router-view id="router-view" />
  </div>
</template>

<script setup>
  import '~/@prestashopcorp/puik-theme/dist/index.css'
  import Header from '../components/header/header.vue'
  import NavigationBar from '../components/navigation-bar/navigation-bar.vue'
</script>

<style lang="scss">
  .page-head {
    display: none;
  }

  .eventbus-app {
    min-height: 200px;
    background: $page-background;
  }

  #router-view {
    padding: 32px;
    max-width: 60%;
  }
</style>
