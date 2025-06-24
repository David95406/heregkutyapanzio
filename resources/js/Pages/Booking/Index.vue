<script setup>
import Navigation from '../../Components/Navigation.vue';
import StepCard from './Components/StepCard.vue';
import Footer from '../../Components/Footer.vue';
</script>
<template>
    <header>
        <Navigation />
    </header>
    <main>
        <div class="flex flex-col tablet:flex-row w-full manrope-normal">
            <section class="flex flex-col w-full bg-light-blue @h-1/2">
                <p class="p-4 text-textBlue">Foglalás > <span class="font-bold">Kezdeti lépések</span></p>
                <div class="flex flex-col flex-grow">
                    <h1 class="p-3 manrope-bold text-textBlue text-5xl tracking-widest">Foglalj időpontot egyszerűen
                    </h1>
                    <h3 class="px-3.5 text-textBlue">Válaszd ki a számodra megfelelő napot, majd add meg adataidat, és
                        küldd
                        el nekünk foglalásodat pár kattintással!</h3>
                </div>
            </section>
            <section class="w-full @h-1/2">
                <img src="https://placehold.co/600x400" class="w-full h-full object-cover">
            </section>
        </div>
        <div class="flex flex-col tablet:flex-row w-full manrope-normal">
            <section class="flex flex-col w-full bg-light-blue @h-1/2">
                <p class="p-4 text-textBlue">Foglalás > <span class="font-bold uppercase">Gyik</span></p>
                <div class="grid grid-cols-1 tablet:grid-cols-2 gap-4 p-5 w-full h-full">
                    <StepCard step="1." title="Hogyan mondhatom le" />
                    <StepCard step="2." title="Milyen fizetési lehetősgek vannak" />
                    <StepCard step="4." title="Mennyi időt vesz igénybe" />
                </div>
            </section>
            <section class="flex flex-col w-full bg-light-blue @h-1/2">
                <p class="p-4 text-textBlue">Foglalás > <span class="font-bold">Segítség</span></p>
                <div class="grid grid-cols-1 tablet:grid-cols-2 gap-4 p-5 w-full h-full">
                    <StepCard step="1." title="Dátum választása" />
                    <StepCard step="2." title="Adatok megadása" />
                    <StepCard step="4." title="Teszt" />
                    <StepCard step="3." title="Teszt" />
                </div>
            </section>
        </div>
    </main>
    <footer>
        <Footer /> 
    </footer>
</template>
<style scoped></style>