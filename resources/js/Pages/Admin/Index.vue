<script setup>
import { Link, router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import AdminLayout from '../../Layout/AdminLayout.vue';
import { computed, reactive, ref, watch } from 'vue';
import Booking from '../../classes/Booking';
import BookingModal from '../../Components/BookingModal.vue';
import { formatDate } from '../../utils';
import { makeToast } from '../../toast';

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
      start: { fillMode: 'solid', color: getBookingIsDayCare(booking) },
      base: { fillMode: 'light', color: getBookingIsDayCare(booking) },
      end: { fillMode: 'solid', color: getBookingIsDayCare(booking) },
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

const accept = (bookingId, isModal = false) => {
  if (confirm("Biztosan megerősíti ezt a foglalást?")) {
    router.patch(route("admin.booking.accept", { booking: bookingId }), {}, {
      preserveScroll: true,
      onSuccess: () => {
        makeToast('Foglalás sikeresen elfogadva!', 'success');
        if (isModal) bookingModalView.refresh();
      },
      onError: () => {
        makeToast('Hiba történt a művelet során.', 'error');
      }
    });
  }
}

const deny = (bookingId, isModal = false) => {
  if (confirm('Biztosan elutasítja ezt a foglalást?')) {
    router.patch(route("admin.booking.deny", { booking: bookingId }), {}, {
      preserveScroll: true,
      onSuccess: () => {
        makeToast('Foglalás sikeresen elutasítva!', 'success');
        if (isModal) bookingModalView.refresh();
      },
      onError: () => {
        makeToast('Hiba történt a művelet során.', 'error');
      }
    })
  }
}

const getBookingStatus = (bookingId) => {
  return bookingStatuses.value.get(bookingId) || null
}

const getBookingStatusText = (booking) => {
  return booking.getAccepted() ? 'Elfogadva' : 'Elutasítva'
}

const bookingModalView = reactive({
  show: false,
  booking: null,
  open(booking) {
    this.show = true
    this.booking = booking
  },
  exit() {
    this.show = false
    this.booking = null
  },
  refresh() {
    if (this.booking) {
      this.booking = bookings.value.find((booking) => booking.getId() == this.booking.getId())
    }
  },
})

const sortingCheckboxes = reactive({
  all: true,
  pendig_email: false, // nincs megerositett email user siderol
  pendig_booking: false, // needs action = megerositett email
  accepted_booking: false,
  rejected_booking: false,
})

watch(() => sortingCheckboxes.all, (newValue) => {
  if (newValue) {
    sortingCheckboxes.pendig_email = false;
    sortingCheckboxes.pendig_booking = false;
    sortingCheckboxes.accepted_booking = false;
    sortingCheckboxes.rejected_booking = false;
  }
})

// Ha bármelyik más checkbox-ot bejelölik, az "Összes" kijelölést töröljük
watch([
  () => sortingCheckboxes.pendig_email,
  () => sortingCheckboxes.pendig_booking,
  () => sortingCheckboxes.accepted_booking,
  () => sortingCheckboxes.rejected_booking
], (newValues) => {
  if (newValues.some(value => value === true)) {
    sortingCheckboxes.all = false;
  } else {
    // Ha egyik sincs kiválasztva, visszaállunk az "Összes" nézethez
    sortingCheckboxes.all = true;
  }
})

// Rendezett bookingok (lehet jobb lesz elengedni)
const bookings = computed(() => {
  return bookingInstances.value
    .sort((b1, b2) => b2.getCreated_at() - b1.getCreated_at())
    .filter((booking) => {
      // remove old booking
      if (booking.getEnd_date() < new Date()) return false

      if (sortingCheckboxes.all) return true;

      // Szűrés a bejelölt kategóriák szerint
      if (sortingCheckboxes.pendig_email && !booking.getVerified_at()) {
        return true;
      }

      if (sortingCheckboxes.pendig_booking && booking.getVerified_at() && booking.getAccepted() === null) {
        return true;
      }

      if (sortingCheckboxes.accepted_booking && booking.getAccepted() === true) {
        return true;
      }

      if (sortingCheckboxes.rejected_booking && booking.getAccepted() === false) {
        return true;
      }

      // Ha semmi nem egyezik, ne jelenítse meg
      return false;
    });
})

const oldBookings = computed(() => {
  return bookingInstances.value.filter((booking) => booking.getEnd_date() < new Date())
    .sort((b1, b2) => b2.getCreated_at() - b1.getCreated_at())
})

</script>

<template>
  <BookingModal v-if="bookingModalView.show" :booking="bookingModalView.booking" @exit="bookingModalView.exit()"
    @deny="deny(bookingModalView.booking.getId(), true)" @accept="accept(bookingModalView.booking.getId(), true)"
    @refresh="bookingModalView.refresh()" />
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Admin</h1>
    <h2 class="text-xl font-semibold mb-6">Foglalások</h2>
    <div class="space-x-4">
      <Link href="/" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
      Vissza a főoldalra
      </Link>
    </div>
  </div>
  <div class="mt-6 space-y-4">
    <h2 class="mx-3.5">Foglalások rendezése</h2>
    <div class="flex flex-row">
      <div class="flex items-center mx-2">
        <input id="all" type="checkbox" v-model="sortingCheckboxes.all"
          class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mx-1">
        <label for="all" class="text-sm font-medium text-gray-700">Összes</label>
      </div>
      <div class="flex items-center mx-2">
        <input id="pending-email" type="checkbox" v-model="sortingCheckboxes.pendig_email"
          class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mx-1">
        <label for="pending-email" class="text-sm font-medium text-gray-700">Függőben lévő email</label>
      </div>
      <div class="flex items-center mx-2">
        <input id="pending-booking" type="checkbox" v-model="sortingCheckboxes.pendig_booking"
          class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mx-1">
        <label for="pending-booking" class="text-sm font-medium text-gray-700">Függőben lévő foglalás</label>
      </div>
      <div class="flex items-center mx-2">
        <input id="accepted-booking" type="checkbox" v-model="sortingCheckboxes.accepted_booking"
          class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mx-1">
        <label for="accepted-booking" class="text-sm font-medium text-gray-700">Elfogadott foglalás</label>
      </div>
      <div class="flex items-center mx-2">
        <input id="rejected-booking" type="checkbox" v-model="sortingCheckboxes.rejected_booking"
          class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mx-1">
        <label for="rejected-booking" class="text-sm font-medium text-gray-700">Elutasított foglalás</label>
      </div>
    </div>
  </div>
  <div class="overflow-x-auto mt-6">
    <table v-if="bookings.length != 0" class="min-w-full bg-white border border-gray-200 rounded-lg">
      <thead>
        <tr class="bg-gray-100">
          <th>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
            </svg>

          </th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Létrehozva</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foglalási név</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email cím</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefonszám</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Megjegyzés</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Típus</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kezdeti dátum</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vége dátum</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Megerősített email
          </th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Műveletek</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <tr v-for="booking in bookings" class="hover:bg-gray-50">
          <td @click="bookingModalView.open(booking)" class="cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="m16.49 12 3.75-3.751m0 0-3.75-3.75m3.75 3.75H3.74V19.5" />
            </svg>
          </td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ formatDate(booking.getCreated_at()) }}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ booking.getName() }}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ booking.getEmail() }}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ booking.getPhone() }}</td>
          <td class="px-4 py-3 text-sm text-gray-700 max-w-xs truncate">{{ booking.getDescription() }}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
            <span class="px-2 py-1 text-xs rounded-full"
              :class="booking.isDayCare() ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'">
              {{ booking.getBookingTypeString() }}
            </span>
          </td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ formatDate(booking.getStart_date()) }}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ formatDate(booking.getEnd_date()) }}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ booking.getVerificationText() }}</td>
          <td class="px-4 py-3 whitespace-nowrap text-sm space-x-2">
            <div v-if="booking.getAccepted() == null">
              <div v-if="!booking.getVerified_at()">
                <p class="text-gray-500" title="Nincs megerősített email">Nem lehet műveletet elvégezni.</p>
              </div>
              <div v-else>
                <button v-if="!getBookingStatus(booking.getId())" @click="accept(booking.getId())"
                  class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition mx-2">Elfogadás</button>
                <button v-if="!getBookingStatus(booking.getId())" @click="deny(booking.getId())"
                  class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">Elutasítás</button>
              </div>
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
  <div class="flex justify-center m-5">
    <VDatePicker mode="date" v-model.range="range" :attributes='attrs' :disabled-dates="disabledDates" />
  </div>

  <div v-if="oldBookings.length > 0" class="mt-6">
    <details class="bg-gray-100 p-4 rounded-lg">
      <summary class="cursor-pointer text-lg font-semibold text-gray-700">Múltbeli foglalások</summary>
      <table class="min-w-full bg-white border border-gray-200 rounded-lg mt-4">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Létrehozva</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foglalási név
            </th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email cím</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefonszám</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Megjegyzés</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Típus</th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kezdeti dátum
            </th>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vége dátum</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr v-for="booking in oldBookings" :key="booking.getId()" class="hover:bg-gray-50">
            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ formatDate(booking.getCreated_at()) }}</td>
            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ booking.getName() }}</td>
            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ booking.getEmail() }}</td>
            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ booking.getPhone() }}</td>
            <td class="px-4 py-3 text-sm text-gray-700 max-w-xs truncate">{{ booking.getDescription() }}</td>
            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
              <span class="px-2 py-1 text-xs rounded-full"
                :class="booking.isDayCare() ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'">
                {{ booking.getBookingTypeString() }}
              </span>
            </td>
            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ formatDate(booking.getStart_date()) }}</td>
            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ formatDate(booking.getEnd_date()) }}</td>
          </tr>
        </tbody>
      </table>
    </details>
  </div>
</template>

<style scoped></style>