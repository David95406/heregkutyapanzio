<script setup>
import AdminLayout from '../../../Layout/AdminLayout.vue';

defineOptions({
    layout: AdminLayout
})

const props = defineProps({
    blockedDates: Array
})

console.log(props.blockedDates)
</script>

<template>
  <h1>Blocked Dates</h1>
</template>

<style scoped>

</style>