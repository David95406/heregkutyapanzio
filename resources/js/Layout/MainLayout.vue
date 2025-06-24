<script setup>
import Navigation from './Components/Navigation.vue';
import Footer from './Components/Footer.vue';

// flash errors!
</script>

<template>
  <header>
    <Navigation />
  </header>
  <main>
    <slot></slot>
  </main>
  <footer>
    <Footer />
  </footer>
</template>

<style scoped>

</style>