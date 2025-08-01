<script setup>
import AdminLayout from '../../../Layout/AdminLayout.vue';
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

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
    // Format date as YYYY-MM-DD to avoid timezone shifts
    const year = currentDate.getFullYear();
    const month = String(currentDate.getMonth() + 1).padStart(2, '0');
    const day = String(currentDate.getDate()).padStart(2, '0');
    dates.push(`${year}-${month}-${day}`);

    // Move to the next day
    currentDate.setDate(currentDate.getDate() + 1);
  }

  console.log(dates)
  // Send array of dates to backend
  router.post(route('blocked-dates.store'), {
    dates: dates
  }, {
    onSuccess: () => {
      alert("siker");
      dragValue.value = null
    },
  });
}

const resetDates = () => {
  //Sok sikert
  router.delete(route('blocked-dates.destroy', { blocked_date: "xd" }), {
    onSuccess: () => {
      alert("sikeresen resetelve")
    }
  });
}
const resetDate = (date) => {
  router.delete(route('blocked-dates.destroy', { blocked_date: date }), {
    onSuccess: () => {
      alert("sikeresen resetelve")
    }
  });
}
defineOptions({
  layout: AdminLayout
})

const props = defineProps({
  blockedDates: Array
})

const blockedDates = computed(() => {
  return props.blockedDates.map((date) => new Date(date))
})
const disabledDates = ref([
  // Default blocked dates
  ...props.blockedDates
]);

console.log(props.blockedDates)
</script>

<template>
  <section class="flex flex-col p-5 m-5">
    <div class="flex flex-row justify-evenly">
      <div class="flex">
        <VDatePicker v-model.range="range" :select-attribute="selectDragAttribute" :drag-attribute="selectDragAttribute"
          @drag="dragValue = $event" :disabled-dates="blockedDates">
        </VDatePicker>
      </div>
      <div>
        <h1>Összes blokkolt dátum</h1>
        <ul class="list-disc">
          <li v-for="(date, index) in blockedDates" :key="index" class="flex items-center justify-between mb-2">
            <span>{{ date.toLocaleDateString() }}</span>
            <button @click="resetDate(date)" class="ml-2 px-2 py-0.5 bg-red-500 text-white rounded hover:bg-red-600" title="Delete date">
              Dátum feloldása
            </button>
          </li>
        </ul>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="resetDates">Összes dátum feloldása</button>
      </div>
    </div>
    <h1 v-if="dragValue">{{ dragValue.start }}</h1>
    <h1 v-if="dragValue">{{ dragValue.end }}</h1>
    <button class="rounded bg-blue-50" v-if="dragValue" @click="blockDate(dragValue.start, dragValue.end)">Dátum
      tiltása</button>
  </section>
</template>

<style scoped></style>