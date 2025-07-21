<script setup>
import FacebookCard from './FacebookCard.vue';
import SplitText from "../../../Components/SplitText.vue";
import AnimatedContent from '../../../Components/AnimatedContent.vue';


</script>
<template>
    <div class="flex flex-col tablet:flex-row w-full manrope-normal">
        <section class="w-full @h-1/2">
            <img src="https://placehold.co/600x400" class="w-full h-full object-cover">
        </section>
        <section class="flex flex-col w-full bg-light-blue @h-1/2">
            <p class="p-4 text-textBlue">Kezdőlap > <span class="font-bold">Blog</span></p>
            <div class="flex flex-col justify-end p-4 flex-grow">
                <h1 class="p-3 manrope-bold text-textBlue text-5xl tracking-widest uppercase">Blog</h1>
                <SplitText text="Friss hírek és érdekességek a Facebook oldalunkról - minden fontos
                    poszt egy helyen!" class-name="px-3.5 text-textBlue" :delay="100" :duration="0.2" ease="power3.out"
                    split-type="chars" :from="{ opacity: 0, y: 40 }" :to="{ opacity: 1, y: 0 }" :threshold="0.1"
                    root-margin="-100px" text-align="start" />
            </div>
        </section>
    </div>
    <div
        class="grid grid-cols-1 tablet:grid-cols-3 gap-4 p-5 w-full h-full bg-gradient-to-b from-light-blue to-white justify-items-center">
        <div v-for="kartya in 6" :key="kartya">
            <AnimatedContent :distance="100" direction="vertical" :reverse="false" :duration="0.8" ease="power3.out"
            :initial-opacity="0" :animate-opacity="true" :scale="1" :threshold="0.1" :delay="0">
            <FacebookCard class="hover:animate-zoom" />
            </AnimatedContent>
        </div>
    </div>

</template>
<style scoped></style>