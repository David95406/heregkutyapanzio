<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import AdminLayout from '../../../Layout/AdminLayout.vue';
import { watch } from 'vue';

defineOptions({
    layout: AdminLayout
})

const props = defineProps({
    services: Array
})

const serivceForm = useForm({
    services: JSON.parse(JSON.stringify(props.services))
});

watch(() => props.services, (newServices) => { // ez lehet nem fontos
    serivceForm.services = JSON.parse(JSON.stringify(newServices));
}, {
    deep: true
});

const submit = () => {
    serivceForm.services.forEach((service, i) => {
        if (JSON.stringify(service) !== JSON.stringify(props.services[i])) {
            router.put(route('services.update', {
                service: service,
                price: service.price
            }), {
                onSucces: () => {
                    // 
                }
            })
        }
    })
}

const cancel = () => {
    serivceForm.reset();
}
</script>

<template>
    <h1 class="text-2xl font-bold mb-4">Szolgáltatások</h1>

    <form @submit.prevent="submit">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="flex bg-gray-200 text-gray-600 uppercase text-sm font-bold p-4">
                <div class="w-1/2">Szolgáltatás neve</div>
                <div class="w-1/2">Ár (Ft)</div>
            </div>
            <div class="divide-y divide-gray-200">
                <div v-for="(service, index) in serivceForm.services" :key="service.id"
                    class="flex items-center p-4 hover:bg-gray-50">
                    <div class="w-1/2">
                        {{ service.name }}
                    </div>
                    <div class="w-1/2">
                        <input type="number" v-model="serivceForm.services[index].price"
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        <div v-if="serivceForm.errors[`services.${index}.price`]" class="text-red-500 text-sm mt-1">
                            {{ serivceForm.errors[`services.${index}.price`] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-4 space-x-2">
            <button type="button" @click="cancel" :disabled="!serivceForm.isDirty"
                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed">
                Mégse
            </button>
            <button type="submit" :disabled="!serivceForm.isDirty || serivceForm.processing"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                <span v-if="serivceForm.processing">Mentés...</span>
                <span v-else>Változtatások mentése</span>
            </button>
        </div>
    </form>
</template>

<style scoped></style>