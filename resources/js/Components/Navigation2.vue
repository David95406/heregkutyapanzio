<script setup>
import { router, usePage } from '@inertiajs/vue3'
import { computed } from "vue";
import { route } from 'ziggy-js'
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'
import { Link } from '@inertiajs/vue3'

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
    <Disclosure as="nav" class="bg-linear-to-b from-white to-light-blue" v-slot="{ open }">
        <div class="px-2 sm:px-6 lg:px-8">
            <div class="max-w-full relative flex h-16 items-center">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <DisclosureButton
                        class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:outline-hidden focus:ring-inset">
                        <span class="absolute -inset-0.5" />
                        <span class="sr-only">Open main menu</span>
                        <Bars3Icon v-if="!open" class="block size-6" aria-hidden="true" />
                        <XMarkIcon v-else class="block size-6" aria-hidden="true" />
                    </DisclosureButton>
                </div>
                <div class="flex shrink-0 items-center">
                    <p>Logo helye</p>
                </div>
                <div class="hidden sm:flex flex-1 items-center justify-center">
                    <div class="flex space-x-90">
                        <Link v-for="item in navigation" :key="item.name" :href="item.href"
                            class="font-bold text-3xl pb-1 relative group"
                            :class="[item.current ? 'text-black' : 'text-gray-400 hover:text-black']"
                            style="letter-spacing: 0.4rem;" :aria-current="item.current ? 'page' : undefined">
                            {{ item.name }}
                            <div class="absolute bottom-0 right-1 w-1/2 h-1 transition-colors duration-300"
                                :class="[item.current ? 'bg-orange-500' : 'bg-transparent group-hover:bg-orange-500']">
                            </div>
                        </Link>
                    </div>
                </div>

            </div>
        </div>

        <DisclosurePanel class="sm:hidden">
            <div class="space-y-1 px-2 pt-2 pb-3">
                <DisclosureButton v-for="item in navigation" :key="item.name" as="Link"
                    :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block rounded-md px-3 py-2 text-base font-medium']"
                    :aria-current="item.current ? 'page' : undefined">
                    {{ item.name }}
                </DisclosureButton>
            </div>
        </DisclosurePanel>
    </Disclosure>
</template>
<style scoped></style>