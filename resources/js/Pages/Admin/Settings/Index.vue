<script setup>
import { router, useForm } from '@inertiajs/vue3';
import AdminLayout from '../../../Layout/AdminLayout.vue';
import { reactive, computed, ref } from 'vue';
import { route } from 'ziggy-js';
import { makeToast } from '../../../toast';

defineOptions({
  layout: AdminLayout
})

const props = defineProps({
  settings: Array
})

// Character limit constant
const CHAR_LIMIT = 1400;

// Password visibility toggle
const showPassword = ref(false);
const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};

const getSettingValue = (key) => {
  const setting = props.settings.find(s => s.key === key);
  return setting ? setting.value : '';
}

const changePasswordForm = useForm({
  password: "",
  password_confirmation: "",
})

const updateAbout1Form = useForm({
  about1: getSettingValue('about1'),
})

const updateAbout2Form = useForm({
  about2: getSettingValue('about2'),
})

// Character count computed properties
const about1CharCount = computed(() => updateAbout1Form.about1 ? updateAbout1Form.about1.length : 0);
const about2CharCount = computed(() => updateAbout2Form.about2 ? updateAbout2Form.about2.length : 0);

const viewState = reactive({
  isPasswordFormValid: computed(() => {
    return changePasswordForm.password && changePasswordForm.password_confirmation;
  }),
  isAbout1FormValid: computed(() => {
    return !!updateAbout1Form.about1 && about1CharCount.value <= CHAR_LIMIT;
  }),
  isAbout2FormValid: computed(() => {
    return !!updateAbout2Form.about2 && about2CharCount.value <= CHAR_LIMIT;
  })
})

const changePassword = () => {
  changePasswordForm.put(route("settings.change-password"), {
    onSuccess: () => {
      makeToast("Sikeresen megváltoztattad a jelszavad!")
      changePasswordForm.reset();
    },
    onError: () => {
      makeToast('Hiba történt a jelszó módosítása során. Kérjük, ellenőrizd az adatokat és próbáld újra!', 'danger');
    }
  })
}

const updateAbout1 = () => {
  updateAbout1Form.put(route("settings.update-about1"), {
    onSuccess: () => {
      makeToast('Sikeresen frissítetted a Rólunk oldal 1. részét!')
      router.reload({ only: ['settings'] });
    },
    onError: () => {
      makeToast('Hiba történt a Rólunk oldal 1. részének frissítése során. Kérjük, próbáld újra!', 'danger')
    }
  })
}

const updateAbout2 = () => {
  updateAbout2Form.put(route("settings.update-about2"), {
    onSuccess: () => {
      makeToast('Sikeresen frissítetted a Rólunk oldal 2. részét!')
      router.reload({ only: ['settings'] });
    },
    onError: () => {
      makeToast('Hiba történt a Rólunk oldal 2. részének frissítése során. Kérjük, próbáld újra!', 'danger')
    }
  })
}
</script>

<template>
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Beállítások</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Rólunk Oldal 1. Rész -->
      <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Rólunk Oldal 1. Rész</h2>
        <form @submit.prevent="updateAbout1">
          <div class="mb-4">
            <label for="about1" class="block text-sm font-medium text-gray-700 mb-1">Tartalom</label>
            <textarea id="about1" v-model="updateAbout1Form.about1" rows="5" maxlength="1400"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
              placeholder="Adja meg a Rólunk oldal első részének tartalmát"></textarea>
            
            <div class="flex justify-between mt-1">
              <p class="text-sm text-gray-500">A Rólunk oldal bevezető szakasza.</p>
              <p class="text-sm" :class="{
                'text-gray-500': about1CharCount <= CHAR_LIMIT * 0.8,
                'text-yellow-600': about1CharCount > CHAR_LIMIT * 0.8 && about1CharCount <= CHAR_LIMIT,
                'text-red-600': about1CharCount > CHAR_LIMIT
              }">{{ about1CharCount }}/{{ CHAR_LIMIT }}</p>
            </div>
            
            <div v-if="updateAbout1Form.errors.about1" class="text-red-500 text-sm mt-1">
              {{ updateAbout1Form.errors.about1 }}
            </div>
          </div>

          <div class="flex justify-end">
            <button type="submit"
              class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:bg-blue-300 disabled:cursor-not-allowed"
              :disabled="!viewState.isAbout1FormValid">
              Tartalom Mentése
            </button>
          </div>
        </form>
      </div>

      <!-- Rólunk Oldal 2. Rész -->
      <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Rólunk Oldal 2. Rész</h2>
        <form @submit.prevent="updateAbout2">
          <div class="mb-4">
        <label for="about2" class="block text-sm font-medium text-gray-700 mb-1">Tartalom</label>
        <textarea id="about2" v-model="updateAbout2Form.about2" rows="5" maxlength="1400"
          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 whitespace-pre-wrap"
          placeholder="Adja meg a Rólunk oldal második részének tartalmát"></textarea>
        
        <div class="flex justify-between mt-1">
          <p class="text-sm text-gray-500">A Rólunk oldal további információi. Új sort az Enter billentyűvel hozhatsz létre.</p>
          <p class="text-sm" :class="{
            'text-gray-500': about2CharCount <= CHAR_LIMIT * 0.8,
            'text-yellow-600': about2CharCount > CHAR_LIMIT * 0.8 && about2CharCount <= CHAR_LIMIT,
            'text-red-600': about2CharCount > CHAR_LIMIT
          }">{{ about2CharCount }}/{{ CHAR_LIMIT }}</p>
        </div>
        
        <div v-if="updateAbout2Form.errors.about2" class="text-red-500 text-sm mt-1">
          {{ updateAbout2Form.errors.about2 }}
        </div>
          </div>

          <div class="flex justify-end">
        <button type="submit"
          class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:bg-blue-300 disabled:cursor-not-allowed"
          :disabled="!viewState.isAbout2FormValid">
          Tartalom Mentése
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
            <div class="relative">
              <input :type="showPassword ? 'text' : 'password'" v-model="changePasswordForm.password"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Adja meg az új jelszót">
              <button type="button" @click="togglePasswordVisibility" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
              </button>
            </div>
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