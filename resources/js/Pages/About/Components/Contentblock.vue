<script setup>
import SplitText from "../../../Components/SplitText.vue";

const props = defineProps({
  title: String,
  subtitle: String,
  breadcrumb: String,
  image: String,
  reverse: Boolean,
  items: Array,
  isFile: {
    type: Boolean,
    required: false,
    default: false
  }
});

function getImageUrl(name) {
  return new URL(`../../../../images/${name}`, import.meta.url).href;
}
</script>

<template>
  <div class="flex flex-col tablet:w-full manrope-normal" :class="[
    reverse ? 'tablet:flex-row-reverse' : 'tablet:flex-row'
  ]">
    <!-- Szöveg -->
    <section class="flex flex-col w-full bg-light-blue @h-1/2">
      <div class="p-5">
        <p class="text-textBlue">Rólunk > <span class="font-bold">{{ breadcrumb }}</span></p>
        <div class="flex flex-col flex-grow">
          <SplitText :text="title" class-name="mt-4 manrope-bold text-textBlue text-4xl tracking-widest" :delay="0"
            :duration="0.8" ease="power3.out" split-type="chars" :from="{ opacity: 0, y: 40 }"
            :to="{ opacity: 1, y: 0 }" :threshold="0.1" root-margin="-100px" text-align="start" />
          <h3 class="mt-2 text-textBlue">{{ subtitle }}</h3>
          <div v-if="items?.length" class="mt-4 space-y-2">
            <div v-for="item in items" :key="item.text" class="flex flex-row items-center gap-2 py-2">
              <p v-html="item.svg"></p>
              <h3 class="text-textBlue text-xl">
                <a v-if="item.type === 'phone'" :href="`tel:${item.text}`" class="hover:underline">
                  {{ item.text }}
                </a>
                <a v-else-if="item.type === 'email'" :href="`mailto:${item.text}`" class="hover:underline">
                  {{ item.text }}
                </a>
                <a v-else-if="item.type === 'location'"
                  :href="`https://maps.google.com/?q=${encodeURIComponent(item.text)}`" target="_blank"
                  class="hover:underline">
                  {{ item.text }}
                </a>
                <span v-else>{{ item.text }}</span>
              </h3>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Kép -->
    <section class="w-full @h-1/2 bg-light-blue">
      <img v-if="!isFile" :src="image" class="w-full h-100 object-cover p-5 rounded-4xl" />
      <img v-else :src="getImageUrl(image)" class="w-full h-100 object-cover p-5 mt-5 rounded-4xl" />
    </section>
  </div>
</template>

<style scoped>
h3 {
  white-space: pre-wrap;
}
</style>
