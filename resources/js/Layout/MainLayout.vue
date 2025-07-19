<script setup>
import Navigation from './Components/Navigation.vue';
import Footer from './Components/Footer.vue';
import { usePage } from '@inertiajs/vue3';
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