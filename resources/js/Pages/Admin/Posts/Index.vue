<script setup>
import { computed, ref } from 'vue';
import AdminLayout from '../../../Layout/AdminLayout.vue';
import Post from '../../../classes/Post';
import PostLine from './Components/PostLine.vue';
import ManagePostCard from './Components/ManagePostCard.vue';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

defineOptions({
    layout: AdminLayout
})

const props = defineProps({
    posts: Array
})

const posts = computed(() => props.posts.map((post) => new Post(post)).sort((p1, p2) => p2.getDate() - p1.getDate()))

const showCreatePostModal = ref({
    show: false
})

const createPost = (postData) => {
    router.post(route('posts.store'), {
        imageUrl: postData.imageUrl,
        title: postData.title,
        text: postData.text
    })
    toggleCreateModal()
}

const updatePost = (post) => {
    router.put(route('posts.update', { post: post.getId() }), post.toObject())
}

const deletePost = (post) => {
    if (post instanceof Post && confirm("Biztos benne hogy torli ezt a posztot?")) {
        router.delete(route('posts.destroy', { post: post.getId() }))
    }
}

const toggleCreateModal = () => {
    showCreatePostModal.value = !showCreatePostModal.value

    if (showCreatePostModal.value) {
        document.body.style.overflow = 'hidden'
    } else {
        document.body.style.overflow = ''
    }
}

const handleCancelCreate = () => {
    toggleCreateModal()
}
</script>

<template>
    <div class="posts-header">
        <h1>Bejegyzések kezelése</h1>
        <button @click="toggleCreateModal" class="create-btn">
            Új bejegyzés létrehozása
        </button>
    </div>

    <table class="posts-table">
        <thead>
            <tr>
                <th>Cím</th>
                <th>Dátum</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <PostLine v-for="post in posts" :key="post.getId()" :post="post" @update="updatePost"
                @delete="deletePost" />
        </tbody>
    </table>

    <!-- Create Post Modal -->
    <ManagePostCard v-if="showCreatePostModal"
        :post="new Post({ id: 0, date: new Date(), imageUrl: '', title: '', text: '' })" @save="createPost"
        @cancel="handleCancelCreate" :isNewPost="true" />
</template>

<style scoped>
.posts-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.create-btn {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

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