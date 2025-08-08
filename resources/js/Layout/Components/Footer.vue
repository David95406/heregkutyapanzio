<script setup>

</script>

<template>
    <section class="bg-gradient-to-b from-light-blue to-white text-textBlue manrope-normal">
        <div class="max-w-7xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Logo and Description -->
                <div class="flex flex-col items-center md:items-start">
                    <img src="../../../images/logo.svg" alt="Hereg Kutyapanzió" class="h-16 mb-4">
                    <p class="">Professzionális kutyapanzió szolgáltatás, ahol kedvence otthon érezheti magát.</p>
                </div>
                            
                <!-- Contact Info -->
                <div class="text-center md:text-left">
                    <h3 class="font-bold text-lg mb-4 manrope-bold">Kapcsolat</h3>
                    <p class="mb-2">+36 30 225 0113</p>
                    <p class="mb-4">info@heregkutyapanzio.hu</p>
                    
                    <!-- Social Media Icons -->
                    <div class="flex space-x-4 justify-center md:justify-start">
                        <a href="https://www.facebook.com/profile.php?id=61577685254433" class="hover:text-primary transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm">&copy; {{ new Date().getFullYear() }} Héreg Kutyapanzió. Minden jog fenntartva.</p>
                <div class="mt-4 md:mt-0 text-sm">
                    <a href="/gdpr" target="_blank" class="hover:text-primary transition-colors">Adatkezelési tájékoztató & ÁSZF</a>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped></style>