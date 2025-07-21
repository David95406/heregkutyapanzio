<template>
  <div class="flex flex-col tablet:w-full manrope-normal" :class="[
    reverse ? 'tablet:flex-row-reverse' : 'tablet:flex-row'
  ]">
    <!-- Szöveg -->
    <section class="flex flex-col w-full bg-light-blue @h-1/2">
      <div class="p-5">
        <p class="text-textBlue">Rólunk > <span class="font-bold">{{ breadcrumb }}</span></p>
        <div class="flex flex-col flex-grow">
          <BlurText :text=title :delay="200" class-name="mt-4 manrope-bold text-textBlue text-5xl tracking-widest"
            animate-by="words" direction="bottom" :threshold="0.1" root-margin="0px" :step-duration="0.35" />
          <BlurText :text=subtitle :delay="200" class-name="mt-2 text-textBlue"
            animate-by="words" direction="bottom" :threshold="0.1" root-margin="0px" :step-duration="0.35" />
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
    <section class="w-full @h-1/2">
      <img :src="image" class="w-full h-full object-cover" />
    </section>
  </div>
</template>

<script setup>
import BlurText from "../../../Components/BlurText.vue";
import TextType from "../../../Components/TextType.vue";
defineProps({
  title: String,
  subtitle: String,
  breadcrumb: String,
  image: String,
  reverse: Boolean,
  items: Array
});
</script>
