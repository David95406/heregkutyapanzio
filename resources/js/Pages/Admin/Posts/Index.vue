<script setup>
import { computed } from 'vue';
import AdminLayout from '../../../Layout/AdminLayout.vue';
import Post from '../../../classes/Post';
import PostLine from './Components/PostLine.vue';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

defineOptions({
    layout: AdminLayout
})

const props = defineProps({
    posts: Array
})

const posts = computed(() => props.posts.map((post) => new Post(post)))

const updatePost = (post) => {
    router.put(route('posts.update', { post: post.getId() }), post.toObject())
}
</script>

<template>
    <h1>Posts Management</h1>
    <table class="posts-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <PostLine v-for="post in posts" :key="post.getId()" :post="post" @update="updatePost" />
        </tbody>
    </table>
</template>

<style scoped>
.posts-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.posts-table th {
    background-color: #f2f2f2;
    padding: 10px;
    text-align: left;
    border-bottom: 2px solid #ddd;
}

.posts-table tbody tr:hover {
    background-color: #f5f5f5;
}
</style>