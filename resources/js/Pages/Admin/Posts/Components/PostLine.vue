<script setup>
import { reactive } from 'vue';
import Post from '../../../../classes/Post';
import ManagePostCard from './ManagePostCard.vue';

const props = defineProps({
    post: Post
})

const emit = defineEmits(['update', 'delete'])

const editState = reactive({
    show: false
})

const toggleModal = () => {
    editState.show = !editState.show

    if (editState.show) {
        document.body.style.overflow = 'hidden'
    } else {
        document.body.style.overflow = ''
    }
}

const handleSave = (updatedData) => {
    const updatedPost = new Post({
        id: props.post.getId(),
        date: props.post.getDate(),
        imageUrl: updatedData.imageUrl,
        title: updatedData.title,
        text: updatedData.text
    })

    emit('update', updatedPost)

    toggleModal()
}

const handleDelete = () => { emit('delete', props.post) }

const handleCancel = () => {
    toggleModal()
}
</script>

<template>
    <tr class="hover:bg-gray-50 transition-colors">
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 max-w-xs truncate">
            {{ post.getTitle() }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ post.getFormattedDate() }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            <div class="flex gap-2">
                <button @click="toggleModal" 
                  class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Szerkesztés
                </button>
                <button @click="handleDelete"
                  class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Törlés
                </button>
            </div>
        </td>
    </tr>

    <ManagePostCard v-if="editState.show" :post="post" @save="handleSave" @cancel="handleCancel" />
</template>