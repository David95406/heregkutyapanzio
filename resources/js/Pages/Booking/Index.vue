<script setup>
import StepCard from './Components/StepCard.vue';
import { ref, computed, reactive } from 'vue';
const range = ref({
  start: null,
  end: null,
});
const attrs = ref([
  {
    key: 'full',
    highlight: 'green',
    dates: new Date(),
  },
]);
const disabledDates = ref([
    // Disable dates from past to today
    { 
        start: [null],
        end: new Date(new Date().setDate(new Date().getDate()))
    },
    // Disable dates from 2 months in the future onwards
    {
        start: new Date(new Date().setMonth(new Date().getMonth() + 2)),
        end: [null]
    }
]);

const convertDate = (date) => {
    return new Date(date).getDate()
}
const foglalasTipusa = computed(()=>{
    return convertDate(range.value.start) == convertDate(range.value.end) ? "Napközi" : "Panzió"
})
</script>
<template>
    <section>
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
            <section class="w-full @h-1/2 bg-light-blue flex justify-evenly manrope-normal">
                <VDatePicker mode="dateTime" v-model.range="range" :attributes='attrs' :timezone="timezone" :disabled-dates="disabledDates"/>
                <div v-if="range.start">
                    <form class="p-4 bg-white rounded-lg shadow-md max-w-md w-full">
                        <h2 class="text-2xl manrope-bold text-textBlue mb-4">Foglalási adatok</h2>
                        <div class="mb-4 manrope-bold text-textBlue">
                            <h1>Típus: <span>{{ foglalasTipusa }}</span></h1>
                        </div>
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-textBlue mb-1">Név</label>
                            <input type="text" id="name" v-model="name" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-textBlue mb-1">Email</label>
                            <input type="email" id="email" v-model="email" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-textBlue mb-1">Telefonszám</label>
                            <input type="tel" id="phone" v-model="phone" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-textBlue mb-1">Megjegyzés</label>
                            <textarea id="message" v-model="message" rows="3" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-300" disabled>
                            Foglalás küldése
                        </button>
                    </form>
                </div>
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
    </section>
</template>
<style scoped></style>