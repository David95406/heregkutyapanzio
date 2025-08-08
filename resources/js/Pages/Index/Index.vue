<script setup>
import { computed } from 'vue';
import Main from './Components/Main.vue';
import Post from '../../classes/Post';

const props = defineProps({
  posts: Array
})

const posts = computed(() => props.posts.map((post) => new Post(post)).sort((p1, p2) => p2.getDate() - p1.getDate()))

// Main component??
</script>

<template>
  <section class="@container">
    <Main :posts="posts" />
  </section>
</template>

<style scoped></style>
