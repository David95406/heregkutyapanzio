<script setup>
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import AdminLayout from '../../Layout/AdminLayout.vue';

defineOptions({
  layout: AdminLayout
})

const redirectToHome = (() => {
  router.get(route('index'))
})

const redirectToSettings = () => {
  router.get(route("admin.settings"))
}
</script>

<template>
  <h1>Admin</h1>
  <button @click="redirectToHome">Go back</button>
  <br>
  <button @click="redirectToSettings">Settings</button>
</template>

<style scoped></style>