<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import EmptyLayout from '../../../Layout/EmptyLayout.vue';

defineOptions({
    layout: EmptyLayout
})

defineProps({
  booking: Object
});

const formattedDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  return date.toLocaleDateString('hu-HU', { year: 'numeric', month: 'long', day: 'numeric' });
};
</script>

<template>
  <Head title="Foglalás Megerősítve" />

  <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6">
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <!-- Fejléc -->
      <div class="bg-green-500 py-6 px-8 text-center">
        <div class="flex justify-center mb-4">
          <div class="rounded-full bg-white p-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
        </div>
        <h1 class="text-2xl font-bold text-white">Foglalását sikeresen megerősítette!</h1>
      </div>
      
      <!-- Tartalom -->
      <div class="px-8 py-6">
        <p class="text-center text-gray-700 text-lg mb-6">
          Köszönjük, hogy a Hereg Kutyapanziót választotta. Foglalását rögzítettük rendszerünkben.
        </p>
        
        <!-- Foglalási adatok -->
        <div class="border rounded-lg overflow-hidden mb-6">
          <div class="bg-gray-50 px-4 py-2 border-b">
            <h2 class="font-semibold text-lg">Foglalási adatok</h2>
          </div>
          
          <div class="divide-y">
            <div class="flex py-3 px-4">
              <span class="font-medium w-1/3">Foglalás azonosítója:</span>
              <span class="text-gray-700">{{ booking.id }}</span>
            </div>
            
            <div class="flex py-3 px-4">
              <span class="font-medium w-1/3">Időszak:</span>
              <span class="text-gray-700">
                {{ formattedDate(booking.start_date) }} - {{ formattedDate(booking.end_date) }}
              </span>
            </div>
            
            <div class="flex py-3 px-4">
              <span class="font-medium w-1/3">Név:</span>
              <span class="text-gray-700">{{ booking.name }}</span>
            </div>
            
            <div class="flex py-3 px-4">
              <span class="font-medium w-1/3">Email:</span>
              <span class="text-gray-700">{{ booking.email }}</span>
            </div>
            
            <div class="flex py-3 px-4">
              <span class="font-medium w-1/3">Telefonszám:</span>
              <span class="text-gray-700">{{ booking.phone }}</span>
            </div>
            
            <div v-if="booking.description" class="flex py-3 px-4">
              <span class="font-medium w-1/3">Megjegyzés:</span>
              <span class="text-gray-700">{{ booking.description }}</span>
            </div>
          </div>
        </div>
        
        <!-- Következő lépések -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
          <h3 class="font-semibold mb-2">Mi a következő lépés?</h3>
          <p class="text-gray-700 mb-2">
            Kollégáink hamarosan telefonon vagy emailben felveszik Önnel a kapcsolatot a részletek egyeztetése céljából.
          </p>
          <p class="text-gray-700">
            Ha bármilyen kérdése van, vagy módosítani szeretné a foglalást, kérjük, vegye fel velünk a kapcsolatot.
          </p>
        </div>
        
        <div class="flex justify-center">
          <Link :href="route('index')" class="inline-flex items-center px-5 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Vissza a főoldalra
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>