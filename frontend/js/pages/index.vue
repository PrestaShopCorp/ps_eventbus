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
  }

  #router-view {
    padding: 32px;
    background: $page-background;
    border-top: 1px solid $card-border;
  }

  #vue-app {
    margin-left: -15px;
    margin-top: -15px;
  }
</style>
