<script setup>
import { computed, ref } from 'vue';
import AdminLayout from '../../../Layout/AdminLayout.vue';
import Post from '../../../classes/Post';
import PostLine from './Components/PostLine.vue';
import ManagePostCard from './Components/ManagePostCard.vue';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { makeToast } from '../../../toast';

defineOptions({
    layout: AdminLayout
})

const props = defineProps({
    posts: Array
})

const posts = computed(() => props.posts.map((post) => new Post(post)).sort((p1, p2) => p2.getDate() - p1.getDate()))

const showCreatePostModal = ref(false)

const createPost = (postData) => {
    router.post(route('posts.store'), {
        imageUrl: postData.imageUrl,
        title: postData.title,
        text: postData.text
    }, {
        onSuccess: () => {
            makeToast('Sikeresen létrehozta a bejegyzést!', 'success');
        },
        onError: () => {
            makeToast('Hiba történt a bejegyzés létrehozása során: ', 'danger');
        }
    })

    toggleCreateModal()
}

const updatePost = (post) => {
    if (post instanceof Post) {
        router.put(route('posts.update', { post: post.getId() }), post.toObject(), {
            onSuccess: () => {
                makeToast('Sikeresen frissítette a bejegyzést!', 'success');
            },
            onError: () => {
                makeToast('Hiba történt a bejegyzés frissítése során: ', 'danger');
            }
        })
    }
}

const deletePost = (post) => {
    if (post instanceof Post && confirm("Biztos benne hogy törli ezt a posztot?")) {
        router.delete(route('posts.destroy', { post: post.getId() }), {
            onSuccess: () => {
                makeToast('Sikeresen törölte a bejegyzést!', 'success');
            },
            onError: () => {
                makeToast('Hiba történt a bejegyzés törlése során: ', 'danger');
            }
        });
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

const inactivePosts = computed(() => {
    const sortedPosts = [...posts.value].sort((a, b) => b.getDate() > a.getDate() ? 1 : -1);
    return sortedPosts.slice(9);
});
console.log(inactivePosts.value.at(9))
const handleCancelCreate = () => {
    toggleCreateModal()
}
</script>

<template>
    <div class="px-4 py-8 w-full max-w-[95%] mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Bejegyzések kezelése</h1>
            <button @click="toggleCreateModal"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                Új bejegyzés létrehozása
            </button>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/2">
                            Cím</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">
                            Dátum</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">
                            Műveletek</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <PostLine v-for="post in posts" :key="post.getId()" :post="post" @update="updatePost"
                        @delete="deletePost" />
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-12 px-4 py-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Inaktív bejegyzések</h2>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/2">
                            Cím
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">
                            Dátum
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">
                            Műveletek
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <PostLine 
                        v-for="post in inactivePosts" 
                        :key="post.getId()" 
                        :post="post" 
                        @update="updatePost"
                        @delete="deletePost" 
                    />
                    <tr v-if="inactivePosts.length === 0">
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                            Nincsenek inaktív bejegyzések
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Post Modal -->
    <ManagePostCard v-if="showCreatePostModal"
        :post="new Post({ id: -1, date: new Date(), imageUrl: '', title: '', text: '' })" @save="createPost"
        @cancel="handleCancelCreate" :isNewPost="true" />
</template>