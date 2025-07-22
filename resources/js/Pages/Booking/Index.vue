<script setup>
import { useForm } from '@inertiajs/vue3';
import StepCard from './Components/StepCard.vue';
import { ref, computed, reactive } from 'vue';
import { route } from 'ziggy-js';
import { toMySqlDateTime } from '../../utils';
import { createToast } from 'mosha-vue-toastify';
import 'mosha-vue-toastify/dist/style.css'
import { getDayFromDate, getBookingType } from '../../utils';

const props = defineProps({
    blockedDates: Array
})

const range = ref({
    start: null,
    end: null,
});

const attrs = ref([
    {
        key: 'full',
        highlight: 'red',
        dates: props.blockedDates
    },
]);

const disabledDates = ref([
    // Default blocked dates
    ...props.blockedDates
]);

const foglalasTipusa = computed(() => getBookingType(range.value.start, range.value.end))

const bookingForm = useForm({
    name: "",
    email: "",
    phone: "",
    description: "",
    start_date: null,
    end_date: null,
    reset() {
        this.name = ""
        this.email = ""
        this.phone = ""
        this.description = ""
        this.start_date = null
        this.end_date = null
    }
})

const submitForm = () => {
    bookingForm.start_date = toMySqlDateTime(range.value.start)
    bookingForm.end_date = toMySqlDateTime(range.value.end)

    bookingForm.post(route("foglalas.store"), {
        onSuccess: () => {
            createToast('A foglalásodat sikeresen rögzítettük, hamarosan keresni fogunk emailben vagy telefonon. 😊', {
                type: 'success',
                transition: 'slide',
                position: 'top-right',
                timeout: 10000,
            })


            range.value.start = null
            range.value.end = null
            bookingForm.reset()
        },
        onError: (error) => {
            createToast('Hoppá, valamiért nem sikerült a foglalás. Ne aggódj, segítünk! Keress minket emailben vagy telefonon. 😊', {
                type: 'danger',
                transition: 'slide',
                position: 'top-right',
                timeout: 10000,
            })
        }
    })
}

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
                <VDatePicker mode="dateTime" v-model.range="range" :attributes='attrs' :disabled-dates="disabledDates"
                    :min-date="new Date(new Date().setDate(new Date().getDate() + 1))" :max-date="new Date(new Date().setMonth(new Date().getMonth() + 2))" />
                <div v-if="range.start">
                    <form @submit.prevent="submitForm" class="p-4 bg-white rounded-lg shadow-md max-w-md w-full">
                        <h2 class="text-2xl manrope-bold text-textBlue mb-4">Foglalási adatok</h2>
                        <div class="mb-4 manrope-bold text-textBlue">
                            <h1>Típus: <span>{{ foglalasTipusa }}</span></h1>
                        </div>
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-textBlue mb-1">Név</label>
                            <input type="text" id="name" v-model="bookingForm.name" required
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-textBlue mb-1">Email</label>
                            <input type="email" id="email" v-model="bookingForm.email" required
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-textBlue mb-1">Telefonszám</label>
                            <input type="tel" id="phone" v-model="bookingForm.phone" required
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-textBlue mb-1">Megjegyzés</label>
                            <textarea id="message" v-model="bookingForm.description" rows="3" required
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>

                        <button type="submit"
                            class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-300">
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
                    <StepCard step="1." title="Hogyan mondhatom le a foglalást?"
                        description="A lemondáshoz vedd fel velünk a kapcsolatot emailben vagy telefonon. Kérjük, lehetőleg legalább 24 órával az érkezés előtt jelezd a módosítást vagy törlést." />
                    <StepCard step="2." title="Milyen fizetési lehetőségek vannak?"
                        description="A fizetés történhet előre utalással vagy a helyszínen készpénzben. Az oldalon történő fizetés jelenleg nem elérhető." />
                    <StepCard step="3." title="Mit érdemes hozni a kutyámnak?"
                        description="Ajánlott hozni a kutya saját fekhelyét, játékát és az otthon megszokott eledelét. Ha van gyógyszere vagy egyéb fontos tudnivaló, kérjük, jelezd előre." />
                    <StepCard step="4." title="Mennyi időt vesz igénybe a foglalás?"
                        description="A foglalási folyamat mindössze néhány percet vesz igénybe, és gyors visszaigazolást küldünk a megadott elérhetőségeidre." />
                </div>
            </section>
            <section class="flex flex-col w-full bg-light-blue @h-1/2">
                <p class="p-4 text-textBlue">Foglalás > <span class="font-bold">Segítség</span></p>
                <div class="grid grid-cols-1 tablet:grid-cols-2 gap-4 p-5 w-full h-full">
                    <StepCard step="1." title="Időpont kiválasztása"
                        description="Válaszd ki az érkezés és távozás napját a naptárban. A piros napok már foglaltak." />
                    <StepCard step="2." title="Napközi vagy panzió?"
                        description="Döntsd el, hogy csak napközbeni ellátást szeretnél, vagy éjszakai szállást is. Dupla kattintás egy dátumra napközi, Szimplával pedig a panzió kezdeti napja adható meg. Az időpont kiválasztásánál az AM a délelőttöt jelöli míg a PM a délutánt" />
                    <StepCard step="4." title="Foglalás elküldése"
                        description="Kattints a 'Foglalás küldése' gombra a véglegesítéshez. Ezután visszaigazoló emailt küldünk és felvesszük veled a kapcsolatot a további teendőkről." />
                    <StepCard step="3." title="Személyes adatok megadása"
                        description="Add meg neved, email címed, telefonszámod és bármilyen egyéb kérést a foglalási űrlapon." />
                </div>
            </section>
        </div>
    </section>
</template>
<style scoped></style>