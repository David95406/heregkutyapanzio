<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { watch } from 'vue';

const logout = () => {
    router.post(route("admin.logout"))
}
</script>

<template>
    <header>
        <nav class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <img class="h-10 w-auto" src="../../images/logo.svg" alt="Company Logo">
                <Link href="/admin" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded transition">
                Kezdőlap
                </Link>

                <Link href="/admin/posts" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded transition">
                Bejegyzések
                </Link>

                <Link href="/admin/settings" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded transition">
                Beállítások
                </Link>

                <Link href="/admin/blocked-dates">
                Dátum kezelés
                </Link>

            </div>
            <div>
                <button @click="logout"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Kijelentkezés</button>
            </div>
        </nav>
    </header>
    <main>
        <slot></slot>
    </main>
    <footer>

    </footer>
</template>

<style scoped></style>