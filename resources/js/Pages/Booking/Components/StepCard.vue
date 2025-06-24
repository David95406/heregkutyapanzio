<template>
  <div class="bg-white p-4 rounded-xl shadow text-textBlue space-y-2">
    <p class="font-bold">{{ step }} <span class="underline">{{ title }}</span></p>
    <p class="text-sm text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ornare urna in volut...</p>
  </div>
</template>

<script setup>
defineProps({
  step: String,
  title: String
});
</script>
