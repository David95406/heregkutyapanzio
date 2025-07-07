<script setup>
import FacebookCard from './FacebookCard.vue';


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
                <h3 class="px-3.5 text-textBlue">Friss hírek és érdekességek a Facebook oldalunkról - minden fontos
                    poszt egy helyen!</h3>
            </div>
        </section>
    </div>
    <div
        class="grid grid-cols-1 tablet:grid-cols-3 gap-4 p-5 w-full h-full bg-gradient-to-b from-light-blue to-white justify-items-center">
        <div v-for="kartya in 6" :key="kartya">
            <FacebookCard class="hover:animate-zoom" />
        </div>
    </div>

</template>
<style scoped></style>