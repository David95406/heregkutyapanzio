<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const adminForm = useForm({
  username: '',
  password: '',
  remember: false
})

const submit = () => {
  adminForm.post(route('admin.login.store'));
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8">
      <h1 class="text-2xl font-bold mb-6 text-center">Admin Belépés</h1>
      
      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block text-gray-700 mb-2" for="username">Felhasználónév</label>
          <input 
            id="username" 
            type="text" 
            v-model="adminForm.username"
            class="w-full px-3 py-2 border rounded-md"
            required
          >
          <div v-if="adminForm.errors.username" class="text-red-500 text-sm mt-1">
            {{ adminForm.errors.username }}
          </div>
        </div>
        
        <div class="mb-6">
          <label class="block text-gray-700 mb-2" for="password">Jelszó</label>
          <input 
            id="password" 
            type="password" 
            v-model="adminForm.password"
            class="w-full px-3 py-2 border rounded-md"
            required
          >
        </div>
        
        <div class="mb-6 flex items-center">
          <input 
            id="remember"
            type="checkbox"
            v-model="adminForm.remember"
            class="mr-2"
          >
          <label class="text-gray-700" for="remember">Emlékezz rám</label>
        </div>
        
        <button 
          type="submit"
          :disabled="adminForm.processing"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-md"
        >
          Belépés
        </button>
      </form>
    </div>
  </div>
</template>