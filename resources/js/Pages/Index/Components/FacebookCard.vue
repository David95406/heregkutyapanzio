<script setup>
import Post from '../../../classes/Post';

const props = defineProps({
    post: Post
})

</script>

<template v-if="post">
    <div
        class="hover:scale-105 transition-transform drop-shadow-xl max-w-sm rounded-4xl overflow-hidden shadow-lg bg-cardBg manrope-normal">
        <div class="flex justify-center">
            <img :src="post.getImageurl()" class="w-fit rounded-4xl p-5" alt="Kép">
        </div>
        <div class="px-6 py-4">
            <p class="text-xs text-gray-400">{{ post.getFormattedDate() }}</p>
            <div class="manrope-bold text-xl text-cardTitle mb-2">{{ post.getTitle() }}</div>
            <p class="text-gray-700 text-base">
                {{ post.getText() }}
            </p>
        </div>
    </div>
</template>

<style scoped></style>