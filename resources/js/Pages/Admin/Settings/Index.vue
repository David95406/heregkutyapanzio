<script setup>
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '../../../Layout/AdminLayout.vue';
import { reactive, computed } from 'vue';
import { route } from 'ziggy-js';
import { makeToast } from '../../../toast';

defineOptions({
  layout: AdminLayout
})

const changePasswordForm = useForm({
  password: "",
  password_confirmation: "",
  reset() {
    this.password = "",
      this.password_confirmation = ""
  }
})

const updateGraphApiKeyForm = useForm({
  graphApiKey: "",
  reset() {
    this.graphApiKey = ""
  }
})

const resetForms = () => {
  changePasswordForm.reset()
  updateGraphApiKeyForm.reset()
}

const viewState = reactive({
  isPasswordFormValid: computed(() => {
    return changePasswordForm.password && changePasswordForm.password_confirmation;
  }),
  isApiKeyFormValid: computed(() => {
    return !!updateGraphApiKeyForm.graphApiKey;
  })
})

const changePassword = () => {
  changePasswordForm.put(route("settings.change-password"), {
    onSuccess: () => {
      makeToast("Sikeresen megváltoztattad a jelszavad!")
      resetForms()
    },
    onError: () => {
      makeToast('Hiba történt a jelszó módosítása során. Kérjük, ellenőrizd az adatokat és próbáld újra!', 'danger');
    }
  })
}

const updateGraphApiKey = () => {
  updateGraphApiKeyForm.put(route("settings.update-graph-api"), {
    onSuccess: () => {
      makeToast('Sikeresen frissítetted a Graph API kulcsot!')
    },
    onError: () => {
      makeToast('Hiba történt a Graph API kulcs frissítése során. Kérjük, ellenőrizd az adatokat és próbáld újra!', 'danger')
    }
  })

  resetForms()
}
</script>

<template>
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Beállítások</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Graph API Kulcs Szekció -->
      <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Graph API Kulcs</h2>
        <form @submit.prevent="updateGraphApiKey">
          <div class="mb-4">
            <label for="graphApiKey" class="block text-sm font-medium text-gray-700 mb-1">API Kulcs</label>
            <input id="graphApiKey" type="text" v-model="updateGraphApiKeyForm.graphApiKey"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
              placeholder="Adja meg a Graph API kulcsot">
            <p class="text-sm text-gray-500 mt-1">Külső Graph API szolgáltatásokhoz való csatlakozáshoz használatos.</p>
            <div v-if="updateGraphApiKeyForm.errors.graphApiKey" class="text-red-500 text-sm mt-1">
              {{ updateGraphApiKeyForm.errors.graphApiKey }}
            </div>
          </div>

          <div class="flex justify-end">
            <button type="submit"
              class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:bg-blue-300 disabled:cursor-not-allowed"
              :disabled="!viewState.isApiKeyFormValid">
              API Kulcs Mentése
            </button>
          </div>
        </form>
      </div>

      <!-- Jelszó Módosítás Szekció -->
      <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Jelszó Módosítása</h2>
        <form @submit.prevent="changePassword">
          <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Új Jelszó</label>
            <input id="password" type="password" v-model="changePasswordForm.password"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
              placeholder="Adja meg az új jelszót">
            <div v-if="changePasswordForm.errors.password" class="text-red-500 text-sm mt-1">
              {{ changePasswordForm.errors.password }}
            </div>
          </div>

          <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Új Jelszó
              Megerősítése</label>
            <input id="password_confirmation" type="password" v-model="changePasswordForm.password_confirmation"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
              placeholder="Erősítse meg az új jelszót">
          </div>

          <div class="flex justify-end">
            <button type="submit"
              class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:bg-blue-300 disabled:cursor-not-allowed"
              :disabled="!viewState.isPasswordFormValid">
              Jelszó Módosítása
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped></style>