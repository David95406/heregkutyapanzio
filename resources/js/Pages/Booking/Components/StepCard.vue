<script setup>
import AnimatedContent from '../../../Components/AnimatedContent.vue';
defineProps({
  step: String,
  title: String,
  description: String
});
</script>


<template>
  <AnimatedContent :distance="100" direction="vertical" :reverse="false" :duration="0.8" ease="power3.out"
    :initial-opacity="0" :animate-opacity="true" :scale="1" :threshold="0.1" :delay="0">
    <div class="bg-white p-4 rounded-xl shadow text-textBlue space-y-2 h-full">
      <p class="font-bold">{{ step }} <span class="underline">{{ title }}</span></p>
      <p class="text-sm text-gray-600">{{ description }}</p>
    </div>
  </AnimatedContent>
</template>