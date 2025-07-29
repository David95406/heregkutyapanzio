<script setup>
import { reactive } from 'vue'


const props = defineProps({
    inputType: String,
    inputContent: String || Object,
    target: {
        type: String,
        default: ''
    }
})

const emit = defineEmits(['send'])

const form = reactive({
    content: props.inputType === "datetime-local" 
        ? new Date(props.inputContent).toISOString().slice(0, 16) 
        : props.inputContent
})

const saveForm = () => {
    emit('send', props.target, form.content)
}
</script>

<template>
  <form @submit.prevent="saveForm">
    <input v-if="props.inputType != 'textarea'" :type="props?.inputType || 'text'" v-model="form.content">
    <textarea v-else v-model="form.content"></textarea>
    <button type="submit" class="save-button">Mentés</button>
  </form>
</template>

<style scoped>

</style>