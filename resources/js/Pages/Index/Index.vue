<script setup>
import { ref } from "vue"
import { router } from "@inertiajs/vue3";
import { route } from "ziggy-js";
const count = ref(0)

const redirectToAdmin = () => {
  route('admin.index')
}
</script>

<template>
  <header>
    <h1>Hello World!</h1>
  </header>
  <main>
    <button @click="count++">Click me: {{ count }}</button>
    <button @click="redirectToAdmin">Admin site</button>
  </main>
  <footer>
    <p>Hereg</p>
  </footer>
</template>

<style scoped>

</style>