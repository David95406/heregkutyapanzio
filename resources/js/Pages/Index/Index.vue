<script setup>
import { computed } from 'vue';
import Main from './Components/Main.vue';
import Post from '../../classes/Post';

const props = defineProps({
  posts: Array
})

const posts = computed(() => props.posts.map((post) => new Post(post)))
</script>

<template>
  <section class="@container">
    <Main :posts="posts" />
  </section>
</template>

<style scoped></style>
