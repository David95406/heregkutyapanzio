<script setup>
import { ref } from "vue"

const count = ref(0)
</script>

<template>
  <header>
    <h1>Hello World!</h1>
  </header>
  <main>
    <button @click="count++">Click me: {{ count }}</button>
  </main>
  <footer>
    <p>Hereg</p>
  </footer>
</template>

<style scoped>

</style>