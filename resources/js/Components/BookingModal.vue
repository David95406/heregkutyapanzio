<script setup>
import Booking from '../classes/Booking';
import { formatDate } from '../utils';
import { ref, onMounted, onBeforeUnmount, reactive } from 'vue';
import MiniForm from './MiniForm.vue';
import { route } from 'ziggy-js';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  booking: {
    type: Booking,
    required: true
  }
})

const emit = defineEmits(['save', 'exit'])

const isOpen = ref(true);

// Close modal when Escape key is pressed
const handleKeyDown = (e) => {
  if (e.key === 'Escape') closeModal();
}

const closeModal = () => {
  isOpen.value = false;
  setTimeout(() => emit('exit'), 300); // Wait for animation to finish
}

onMounted(() => {
  document.addEventListener('keydown', handleKeyDown);
});

onBeforeUnmount(() => {
  document.removeEventListener('keydown', handleKeyDown);
});

const editState = reactive({
  start_date: false,
  end_date: false,
  description: false,
  toggle(target) { // buggos :(
    this.description = this.start_date = this.description = false
    this[target] = true
  }
})

const updateBooking = (target, content) => {
  router.put(route('admin.booking.update', { // rename attrs
    booking: props.booking.getId(),
    field: target,
    value: content
  }))
}
</script>

<template>
  <!-- Modal Backdrop with blur effect -->
  <div
    class="fixed inset-0 bg-black bg-opacity-30 backdrop-blur-sm z-40 flex items-center justify-center overflow-y-auto"
    :class="{ 'opacity-100': isOpen, 'opacity-0': !isOpen }" @click="closeModal" style="transition: opacity 0.3s ease;">

    <!-- Modal Content - 4:3 ratio and larger size -->
    <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl mx-4 my-8 overflow-hidden transform aspect-[4/3]"
      :class="{ 'translate-y-0 opacity-100': isOpen, 'translate-y-4 opacity-0': !isOpen }"
      style="transition: all 0.3s ease;" @click.stop>

      <!-- Modal Header -->
      <div class="bg-gray-100 px-6 py-4 flex justify-between items-center border-b">
        <h2 class="text-xl font-semibold text-gray-800">Foglalás részletei</h2>
        <button @click="closeModal" class="text-gray-500 hover:text-gray-700 focus:outline-none">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <!-- Modal Body - scrollable to maintain 4:3 ratio -->
      <div class="px-6 py-4 overflow-y-auto" style="height: calc(100% - 130px);">
        <!-- Basic Info Section -->
        <div class="mb-5">
          <h3 class="text-lg font-semibold text-gray-700 mb-3 pb-2 border-b">Általános információ</h3>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <p class="text-sm text-gray-500">Foglalás létrehozva</p>
              <p class="font-medium text-base">{{ formatDate(props.booking.getCreated_at()) }}</p>
            </div>

            <div>
              <p class="text-sm text-gray-500">Foglalás típusa</p>
              <p class="font-medium text-base">{{ props.booking.getBookingTypeString() }}</p>
            </div>

            <div>
              <p class="text-sm text-gray-500">Foglalás állapota</p>
              <div class="flex items-center">
                <span class="inline-block h-3 w-3 rounded-full mr-2" :class="{
                  'bg-green-500': props.booking.getAccepted() === true,
                  'bg-red-500': props.booking.getAccepted() === false,
                  'bg-yellow-500': props.booking.getAccepted() === null
                }"></span>
                <p class="font-medium text-base">
                  {{ props.booking.getAcceptedString() }}
                </p>
              </div>
            </div>

            <div>
              <p class="text-sm text-gray-500">Email megerősítése</p>
              <div class="flex items-center">
                <span class="inline-block h-3 w-3 rounded-full mr-2" :class="{
                  'bg-green-500': props.booking.getVerified_at(),
                  'bg-red-500': !props.booking.getVerified_at()
                }"></span>
                <p class="font-medium text-base">{{ props.booking.getVerificationText() }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Contact Info Section -->
        <div class="mb-5">
          <h3 class="text-lg font-semibold text-gray-700 mb-3 pb-2 border-b">Kapcsolattartási adatok</h3>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <p class="text-sm text-gray-500">Név</p>
              <p class="font-medium text-base">{{ props.booking.getName() }}</p>
            </div>

            <div>
              <p class="text-sm text-gray-500">Telefonszám</p>
              <p class="font-medium text-base">{{ props.booking.getPhone() }}</p>
            </div>

            <div class="md:col-span-2">
              <p class="text-sm text-gray-500">Email cím</p>
              <p class="font-medium text-base">{{ props.booking.getEmail() }}</p>
            </div>
          </div>
        </div>

        <!-- Date Range Section -->
        <div class="mb-5">
          <h3 class="text-lg font-semibold text-gray-700 mb-3 pb-2 border-b">Időszak</h3>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <p class="text-sm text-gray-500">Kezdő dátum</p>
              <div>
                <p v-if="!editState.start_date" class="font-medium text-base">{{
                  formatDate(props.booking.getStart_date()) }}</p>
                <MiniForm v-else :target="'start_date'" :input-type="'datetime-local'"
                  :input-content="booking.getStart_date()" @send="updateBooking" />
              </div>
              <svg @click="editState.toggle('start_date')" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
              </svg>
            </div>

            <div>
              <p class="text-sm text-gray-500">Befejező dátum</p>
              <div>
                <p v-if="!editState.end_date" class="font-medium text-base">{{ formatDate(props.booking.getEnd_date())
                  }}</p>
                <MiniForm v-else :target="'end_date'" :input-type="'datetime-local'"
                  :input-content="booking.getEnd_date()" @send="updateBooking" />
              </div>
              <svg @click="editState.toggle('end_date')" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Description Section -->
        <div class="mb-5">
          <h3 class="text-lg font-semibold text-gray-700 mb-3 pb-2 border-b">Megjegyzés</h3>
          <div>
            <p v-if="!editState.description" class="whitespace-pre-line">
              {{ props.booking.getDescription() || 'Nincs megjegyzés' }}
            </p>
            <MiniForm v-else :target="'description'" :input-type="'textarea'" :input-content="booking.getDescription()"
              @send="updateBooking" />
          </div>
          <svg @click="editState.toggle('description')" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
          </svg>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="bg-gray-100 px-6 py-4 flex justify-end space-x-4 border-t mt-auto">
        <button @click="closeModal"
          class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 focus:outline-none">
          Bezárás
        </button>

        <template v-if="props.booking.getAccepted() === null && props.booking.getVerified_at()">
          <button @click="emit('save', { id: props.booking.getId(), action: 'deny' })"
            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none">
            Elutasítás
          </button>
          <button @click="emit('save', { id: props.booking.getId(), action: 'accept' })"
            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none">
            Elfogadás
          </button>
        </template>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Ensure the backdrop-filter works in browsers that support it */
@supports (backdrop-filter: blur(4px)) {
  .backdrop-blur-sm {
    backdrop-filter: blur(4px);
  }
}
</style>