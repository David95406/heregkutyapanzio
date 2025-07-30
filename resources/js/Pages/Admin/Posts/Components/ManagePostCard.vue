<script setup>
import Post from '../../../../classes/Post';
import FacebookCard from '../../../Index/Components/FacebookCard.vue';

const props = defineProps({
    post: Post
})
</script>

<template>
  <FacebookCard :post="post" />
</template>

<style scoped>

</style>