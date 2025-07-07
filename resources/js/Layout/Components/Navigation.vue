<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
const currentPageComponent = computed(() => page.component)

const navigation = [
    { name: 'Kezdőlap', href: "/", component: "Index/Index" },
    { name: 'Rólunk', href: '/rolunk', component: "About/Index" },
    { name: 'Foglalás', href: '/foglalas', component: "Booking/Index" },
].map((page) => ({
    ...page,
    current: page.component === currentPageComponent.value
}))

</script>
<template>
    <Disclosure as="nav" class="bg-gradient-to-b from-white to-light-blue manrope-normal" v-slot="{ open }">
        <div class="px-4 mx-auto max-w-7xl tablet:px-6 desktop:px-8">
            <div class="relative flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0">
                    <img class="h-10 w-auto" src="https://placehold.co/100x100" alt="Company Logo">
                </div>
                
                <!-- Desktop navigation -->
                <div class="hidden tablet:flex items-center justify-center flex-1">
                    <div class="flex space-x-4 tablet:space-x-6 desktop:space-x-8">
                        <Link v-for="item in navigation" :key="item.name" :href="item.href"
                            class="relative manrope-bold tracking-widest text-lg tablet:text-xl desktop:text-2xl pb-1 group transition-colors duration-300"
                            :class="[item.current ? 'text-black' : 'text-gray-400 hover:text-black']"
                            :aria-current="item.current ? 'page' : undefined">
                            {{ item.name }}
                            <div class="absolute bottom-0 right-1 w-1/2 h-1 transition-colors duration-300"
                                :class="[item.current ? 'bg-orange-500' : 'bg-transparent group-hover:bg-orange-500']"></div>
                        </Link>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <div class="tablet:hidden">
                    <DisclosureButton
                        class="relative inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:bg-gray-100 hover:text-black focus:outline-none focus:ring-2">
                        <span class="sr-only">Open main menu</span>
                        <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                        <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                    </DisclosureButton>
                </div>
            </div>
        </div>

        <!-- Mobile menu panel -->
        <DisclosurePanel class="tablet:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href"
                    :class="[item.current ? 'text-black' : 'text-gray-600 hover:bg-gray-100 hover:text-black', 
                    'block px-3 py-2 rounded-md text-base font-medium relative group']"
                    :aria-current="item.current ? 'page' : undefined">
                    {{ item.name }}
                    <div class="absolute bottom-0 ms-9 w-1/12 h-1 transition-colors duration-300"
                                :class="[item.current ? 'bg-orange-500' : 'bg-transparent group-hover:bg-orange-500']"></div>
                </DisclosureButton>
                
            </div>
        </DisclosurePanel>
    </Disclosure>
</template>
<style scoped></style>