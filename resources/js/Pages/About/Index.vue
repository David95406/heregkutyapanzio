<script setup>
import { computed } from 'vue';
import ContentBlock from './Components/Contentblock.vue';

const props = defineProps({
    about1: {
        type: String,
        required: false
    },
    about2: {
        type: String,
        required: false
    }
})

const defaultAboutTexts = {
    about1: "Koss Krisztina Zsuzsanna vagyok, világéletemben voltak állataim. 30 éves kutya nevelői és kiképzői tapasztalattal vállalom kutyák illetve kisállatok (macskák, rágcsálók, madarak akár haszonállatok) gondozását saját valamint az állatok otthonában egyaránt.",
    about2: "Második bekezdés tartalma"
}

const aboutText1 = computed(() => props.about1 || defaultAboutTexts.about1);
const aboutText2 = computed(() => props.about2 || defaultAboutTexts.about2);

const icons = {
    phone: `
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2E7AAE" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
        </svg>
    `,
    mail: `
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2E7AAE" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
        </svg>
    `,
    location: `
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2E7AAE" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
        </svg>
    `
}

const aboutItems = [
    { svg: icons.phone, text: '+36302250113', type: 'phone', },
    { svg: icons.mail, text: 'adrianjozsa81@gmail.com', type: 'email', },
    { svg: icons.location, text: 'Héreg, Béke u. 34, 2832', type: 'location', }
]

</script>
<template>
    <section>
        <ContentBlock breadcrumb="Kapcsolat" title="Lépj velünk kapcsolatba"
            subtitle="Keress minket bizalommal elérhetőségeink egyikén, vagy írj nekünk üzenetet!"
            image="aboutFirst.webp" :items="aboutItems"
            :reverse="false" :is-file="true" />
        <ContentBlock breadcrumb="Történetünk" title="Rólunk" :subtitle="aboutText1" image="aboutSecond.webp"
            :reverse="true" :is-file="true"/>
        <ContentBlock breadcrumb="Árak" title="Áraink" :subtitle="aboutText2" image="aboutThird.webp" :reverse="false"
            :is-file="true" />
    </section>
</template>


<style scoped></style>