<script setup>
import AdminLayout from '../../../Layout/AdminLayout.vue';
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { makeToast } from '../../../toast';

const range = ref({
  start: null,
  end: null,
});

const dragValue = ref(null);
const selectDragAttribute = computed(() => ({
  popover: {
    visibility: 'hover',
    isInteractive: false,
  },
}));

// Format date as YYYY-MM-DD 
function formatDateForServer(date) {
  const d = new Date(date);
  const year = d.getFullYear();
  const month = String(d.getMonth() + 1).padStart(2, '0');
  const day = String(d.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
}

const blockDate = (start, end) => {
  const dates = [];

  // Create new Date objects and ensure we use local date components
  let currentDate = new Date(start);
  let endDate = new Date(end);

  // Set time to noon to avoid timezone issues
  currentDate.setHours(12, 0, 0, 0);
  endDate.setHours(12, 0, 0, 0);

  // Loop through dates and add them to array
  while (currentDate <= endDate) {
    dates.push(formatDateForServer(currentDate));
    // Move to the next day
    currentDate.setDate(currentDate.getDate() + 1);
  }

  // Send array of dates to backend
  router.post(route('blocked-dates.store'), {
    dates: dates
  }, {
    onSuccess: () => {
      makeToast('Dátumok sikeresen blokkolva', 'success');
      dragValue.value = null;
    },
    onError: (errors) => {
      makeToast('Hiba történt a dátumok blokkolásakor', 'danger');
      console.error(errors);
    }
  });
}

const resetDates = () => {
  if (!confirm('Biztosan feloldja az összes dátumot?')) return;
  
  router.delete(route('blocked-dates.destroy', { blocked_date: "all" }), {
    onSuccess: () => {
      makeToast('Összes dátum sikeresen feloldva', 'success');
    },
    onError: () => {
      makeToast('Hiba történt az összes dátum feloldásakor', 'danger');
    }
  });
}

const removeDate = (blockedDate) => {
  router.delete(route('blocked-dates.destroy', { blocked_date: blockedDate.id }), {
    onSuccess: () => {
      makeToast('Dátum sikeresen feloldva', 'success');
    },
    onError: () => {
      makeToast('Hiba történt a dátum feloldásakor', 'danger');
    }
  });
}

defineOptions({
  layout: AdminLayout
})

const props = defineProps({
  blockedDates: Array
})

const formattedBlockedDates = computed(() => {
  return props.blockedDates.map(blockedDate => {
    // Parse the date string into a Date object
    const date = new Date(blockedDate.date);
    return {
      id: blockedDate.id,
      date: date,
      formattedDate: date.toLocaleDateString()
    };
  });
});

// For the VDatePicker component
const disabledDates = computed(() => {
  return formattedBlockedDates.value.map(item => item.date);
});
</script>

<template>
  <section class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold">Blokkolt dátumok kezelése</h1>
      <p class="text-gray-600">Itt kezelheti a foglalások elől blokkolt dátumokat</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Date Picker Section -->
      <div class="bg-white p-5 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Dátum választó</h2>
        <div class="flex justify-center">
          <VDatePicker 
            v-model.range="range" 
            :select-attribute="selectDragAttribute" 
            :drag-attribute="selectDragAttribute"
            @drag="dragValue = $event" 
            :disabled-dates="disabledDates">
          </VDatePicker>
        </div>

        <div v-if="dragValue" class="mt-6 border-t pt-4">
          <h3 class="font-semibold mb-2">Kiválasztott időszak</h3>
          <div class="flex items-center justify-between">
            <span class="text-gray-700">
              {{ new Date(dragValue.start).toLocaleDateString() }} - {{ new Date(dragValue.end).toLocaleDateString() }}
            </span>
            <button 
              @click="blockDate(dragValue.start, dragValue.end)"
              class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition-colors"
            >
              Dátumok blokkolása
            </button>
          </div>
        </div>
      </div>

      <!-- Blocked Dates List Section -->
      <div class="bg-white p-5 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-xl font-semibold">Blokkolt dátumok listája</h2>
          <button 
            @click="resetDates"
            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition-colors"
          >
            Összes dátum feloldása
          </button>
        </div>

        <div v-if="formattedBlockedDates.length === 0" class="text-center py-10 text-gray-500">
          Nincsenek blokkolt dátumok
        </div>

        <div v-else class="overflow-y-auto max-h-96">
          <table class="min-w-full">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dátum</th>
                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Művelet</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-for="(date, index) in formattedBlockedDates" :key="index" class="hover:bg-gray-50">
                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ date.id }}</td>
                <td class="px-4 py-2 whitespace-nowrap text-sm">{{ date.formattedDate }}</td>
                <td class="px-4 py-2 whitespace-nowrap text-right">
                  <button 
                    @click="removeDate(date)" 
                    class="text-red-500 hover:text-red-700 transition-colors"
                  >
                    Feloldás
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</template>