<script setup>
import { computed, popScopeId } from 'vue';
import AdminLayout from '../../../Layout/AdminLayout.vue';
import Post from '../../../classes/Post';
import PostLine from './Components/PostLine.vue';

defineOptions({
  layout: AdminLayout
})

const props = defineProps({
    posts: Array
})

const posts = computed(() => props.posts.map((post) => new Post(post)))
</script>

<template>
  <h1>Hello</h1><br>
  <div v-for="post in posts">
    <PostLine :post="post" />
  </div>
</template>

<style scoped>

</style>