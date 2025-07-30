<script setup>
import { defineEmits, computed } from 'vue';
import Post from '../../../../classes/Post';
import FacebookCard from '../../../Index/Components/FacebookCard.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  post: Post
})

const emit = defineEmits(['save', 'cancel'])

const formData = useForm({
  id: props.post.getId(),
  imageUrl: props.post.getImageurl(),
  title: props.post.getTitle(),
  text: props.post.getText()
})

const updatedPost = computed(() => new Post({
  id: props.post.getId(),
  date: props.post.getDate(),
  imageUrl: formData.imageUrl,
  title: formData.title,
  text: formData.text
}))

const saveChanges = () => {
  if (!props.post.isEqual(updatedPost.value)) {
    emit('save', {
      imageUrl: formData.imageUrl,
      title: formData.title,
      text: formData.text
    })
  }
}

const closeModal = () => {
  emit('cancel')
}
</script>

<template>
  <div class="modal-overlay" @click.self="closeModal">
    <div class="modal-container">
      <div class="modal-header">
        <h2>Bejegyzés szerkesztése</h2>
        <button @click="closeModal" class="close-btn">&times;</button>
      </div>

      <div class="modal-content">
        <div class="manage-post-card">
          <div class="preview-section">
            <h3>Bejegyzés előnézete</h3>
            <FacebookCard :post="updatedPost" />
          </div>

          <div class="edit-section">
            <h3>Részletek szerkesztése</h3>
            <form @submit.prevent="saveChanges">
              <div class="form-group">
                <label for="imageUrl">Kép URL</label>
                <input type="text" id="imageUrl" v-model="formData.imageUrl" class="form-control" />
              </div>

              <div class="form-group">
                <label for="title">Cím</label>
                <input type="text" id="title" v-model="formData.title" class="form-control" />
              </div>

              <div class="form-group">
                <label for="text">Tartalom</label>
                <textarea id="text" v-model="formData.text" class="form-control" rows="5"></textarea>
              </div>

              <div class="button-group">
                <button type="submit" class="save-btn">Változások mentése</button>
                <button type="button" class="cancel-btn" @click="closeModal">Mégse</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(5px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 100;
}

.modal-container {
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  width: 90%;
  max-width: 1200px;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 20px;
  border-bottom: 1px solid #eee;
}

.close-btn {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: #666;
}

.modal-content {
  padding: 20px;
}

.manage-post-card {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.preview-section,
.edit-section {
  padding: 15px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form-control {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 16px;
}

.button-group {
  display: flex;
  gap: 10px;
  margin-top: 20px;
}

.save-btn,
.cancel-btn {
  padding: 10px 15px;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
}

.save-btn {
  background-color: #4CAF50;
  color: white;
  border: none;
}

.cancel-btn {
  background-color: #f44336;
  color: white;
  border: none;
}

@media (max-width: 768px) {
  .manage-post-card {
    grid-template-columns: 1fr;
  }
}
</style>