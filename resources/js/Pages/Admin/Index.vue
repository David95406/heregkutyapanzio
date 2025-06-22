<script setup>
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const redirectToHome = (() => {
    router.get(route('index.index'))
})
</script>

<template>
  <h1>Admin</h1>
  <button @click="redirectToHome">Go back</button>
</template>

<style scoped>

</style>