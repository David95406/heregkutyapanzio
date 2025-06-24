<script setup>
import Navigation from '../../Components/Navigation.vue';
import Main from './Components/Main.vue';
import Footer from '../../Components/Footer.vue';
</script>

<template>
  <header>
    <Navigation />
  </header>
  <main>
    <section class="@container">
      <Main />
    </section>
  </main>
  <footer>
    <Footer />
  </footer>
</template>

<style scoped></style>
