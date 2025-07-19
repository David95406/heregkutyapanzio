<script setup>
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import AdminLayout from '../../Layout/AdminLayout.vue';
import { computed } from 'vue';
import { getDayFromDate } from '../../utils';

defineOptions({
  layout: AdminLayout
})

const props = defineProps({
  bookings: Array
})

const getType = (booking) => {
  return getDayFromDate(booking.start_date) == getDayFromDate(booking.end_date) ? "Napközi" : "Panzió"
}

const bookings = computed(() => props.bookings.sort((b1, b2) => new Date(b2.created_at) - new Date(b1.created_at))
  .map((booking) => ({...booking, type: getType(booking)})))

const redirectToHome = (() => {
  router.get(route('index'))
})

const redirectToSettings = () => {
  router.get(route("admin.settings"))
}
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Admin</h1>
    <h2 class="text-xl font-semibold mb-6">Foglalások</h2>
    <div class="space-x-4">
      <button @click="redirectToHome" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Vissza a főoldalra</button>
      <button @click="redirectToSettings" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Settings</button>
    </div>
  </div>
  <div v-for="booking in bookings">
    <p>{{ booking }}</p>
    <br>
  </div>
</template>

<style scoped></style>