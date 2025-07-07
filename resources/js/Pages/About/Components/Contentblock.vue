<template>
  <div
    class="flex flex-col tablet:w-full manrope-normal"
    :class="[
      reverse ? 'tablet:flex-row-reverse' : 'tablet:flex-row'
    ]"
  >
    <!-- Szöveg -->
    <section class="flex flex-col w-full bg-light-blue @h-1/2">
      <div class="p-5">
        <p class="text-textBlue">Rólunk > <span class="font-bold">{{ breadcrumb }}</span></p>
        <div class="flex flex-col flex-grow">
          <h1 class="mt-4 manrope-bold text-textBlue text-5xl tracking-widest">{{ title }}</h1>
          <h3 class="mt-2 text-textBlue">{{ subtitle }}</h3>
          <div v-if="items?.length" class="mt-4 space-y-2">
            <div
              v-for="item in items"
              :key="item.text"
              class="flex flex-row items-center gap-2 py-2"
            >
              <p v-html="item.svg"></p>
              <h3 class="text-textBlue text-xl">{{ item.text }}</h3>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Kép -->
    <section class="w-full @h-1/2">
      <img :src="image" class="w-full h-full object-cover" />
    </section>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  subtitle: String,
  breadcrumb: String,
  image: String,
  reverse: Boolean,
  items: Array
});
</script>
