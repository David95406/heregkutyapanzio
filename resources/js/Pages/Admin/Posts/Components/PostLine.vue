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
    <tr>
        <td>{{ post.getTitle() }}</td>
        <td>{{ post.getFormattedDate() }}</td>
        <td>
            <div class="action-buttons">
                <button @click="toggleModal" class="edit-btn">
                    Edit
                </button>
                <button class="delete-btn" @click="handleDelete">
                    Delete
                </button>
            </div>
        </td>
    </tr>

    <ManagePostCard v-if="editState.show" :post="post" @save="handleSave" @cancel="handleCancel" />
</template>

<style scoped>
tr td {
    padding: 12px 15px;
    border-bottom: 1px solid #ddd;
}

.action-buttons {
    display: flex;
    gap: 10px;
}

.edit-btn,
.delete-btn {
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 14px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
}

.edit-btn {
    background-color: #4CAF50;
    color: white;
    border: none;
}

.delete-btn {
    background-color: #f44336;
    color: white;
    border: none;
}
</style>