<script setup>
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import AdminLayout from '../../Layout/AdminLayout.vue';
import { computed, ref } from 'vue';
import Booking from '../../classes/Booking';

defineOptions({
  layout: AdminLayout
})

const props = defineProps({
  bookings: Array
})

const range = ref({
    start: null,
    end: null,
});

// Booking osztályok létrehozása
const bookingInstances = computed(() => {
  return props.bookings.map(booking => new Booking(booking));
});

const acceptedVerified = computed(() => {
  return bookingInstances.value.filter((booking) => 
    booking.getAccepted() && booking.getVerified_at());
});

const getBookingIsDayCare = (booking) => {
  return booking.isDayCare() ? 'blue' : 'green';
};

const attrs = computed(() => {
  return acceptedVerified.value.map((booking, index) => ({
    key: `booking_${booking.getId()}_${index}`,
    highlight: {
      start: { fillMode: 'solid', color: getBookingIsDayCare(booking)},
      base: { fillMode: 'light', color: getBookingIsDayCare(booking)},
      end: { fillMode: 'solid', color: getBookingIsDayCare(booking)},
    },
    dates: {
      start: booking.getStart_date(),
      end: booking.getEnd_date(),
    },
    popover: {
      label: booking.getName(),
      visibility: 'hover',
    },
  }));
});

const disabledDates = ref([]);

const bookingStatuses = ref(new Map())

const accept = (bookingId) => {
  router.patch(route("admin.booking.accept", { booking: bookingId }), {}, {
    preserveScroll: true,
  });
}

const deny = (bookingId) => {
  if (confirm('Biztosan elutasítja?')) {
    router.patch(route("admin.booking.deny", { booking: bookingId }), {}, {
      preserveScroll: true,
    });
  }
}

const getBookingStatus = (bookingId) => {
  return bookingStatuses.value.get(bookingId) || null
}

const getBookingStatusText = (booking) => {
  return booking.getAccepted() ? 'Elfogadva' : 'Elutasítva'
}

// Rendezett bookingok
const bookings = computed(() => {
  return bookingInstances.value.sort((b1, b2) => 
    b2.getCreated_at() - b1.getCreated_at());
});

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
      <button @click="redirectToHome" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Vissza a
        főoldalra</button>
      <button @click="redirectToSettings"
        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Settings</button>
    </div>
  </div>
  <div class="overflow-x-auto mt-6">
    <table v-if="bookings.length != 0" class="min-w-full bg-white border border-gray-200 rounded-lg">
      <thead>
        <tr class="bg-gray-100">
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Létrehozva</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foglalási név</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email cím</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefonszám</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Megjegyzés</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Típus</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kezdeti dátum</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vége dátum</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Megerősített email</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Műveletek</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <tr v-for="booking in bookings" class="hover:bg-gray-50">
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ booking.getCreated_at() }}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ booking.getName() }}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ booking.getEmail() }}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ booking.getPhone() }}</td>
          <td class="px-4 py-3 text-sm text-gray-700 max-w-xs truncate">{{ booking.getDescription() }}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
            <span class="px-2 py-1 text-xs rounded-full"
              :class="booking.getBookingTypeString() === 'Napközi' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'">
              {{ booking.getBookingTypeString() }}
            </span>
          </td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ booking.getStart_date() }}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ booking.getEnd_date() }}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ booking.getVerificationText() }}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm space-x-2">
            <div v-if="booking.getAccepted() == null">
              <button v-if="!getBookingStatus(booking.getId())" @click="accept(booking.getId())"
                class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition">Elfogadás</button>
              <button v-if="!getBookingStatus(booking.getId())" @click="deny(booking.getId())"
                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">Elutasítás</button>
            </div>
            <div v-else>
              <p :class="booking.getAccepted() ? 'text-green-400' : 'text-red-400'">
                {{ getBookingStatusText(booking) }}</p>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <h1 v-else class="text-2xl manrope-bold text-center">A foglalási lista üres</h1>
  </div>
  <VDatePicker mode="date" v-model.range="range" :attributes='attrs' :disabled-dates="disabledDates" />
</template>

<style scoped></style>