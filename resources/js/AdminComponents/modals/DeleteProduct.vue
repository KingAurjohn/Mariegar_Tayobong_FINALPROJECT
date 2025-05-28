<template>
  <div v-if="delete_info.show" class="modal-overlay" @click.self="close">
        <feedbackVue :message="message" :type="type" :title="title" :show="show" @close="close" v-show="show_feedback"/>
    <div class="modal-box">
      <div class="modal-header danger">
        <span class="header-icon">⚠️</span>
        <h2>CONFIRM DELETE</h2>
        <span class="close-btn" @click="close">&times;</span>
      </div>

      <div class="product-info">
        <p><strong>Product:</strong> {{ delete_info.data.name }}</p>
        <p><strong>Description:</strong> {{ delete_info.data.description }}</p>
        <p class="warning-text">Are you sure you want to delete this product? This action cannot be undone.</p>
      </div>

      <div class="action-buttons">
        <button @click="close" class="cancel-btn">Cancel</button>
        <button @click="confirmDelete" class="delete-btn">Delete</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import feedbackVue from '../../modal_feedback/feedback.vue';
export default {
        components: {
        feedbackVue
    },
    data(){
        return{
            show_feedback: false,
            type: "",
            message: "",
            title: "",
            show: false,
        }
    },
  props: ['delete_info'],
  methods: {
    close() {
      this.$emit('close');
    },
    async confirmDelete() {
      try{
            const data = new FormData();

            data.append('id', this.delete_info.data.id);

            const res = await axios.post('/admin/delete-product', data);

            if(res.data.message === "success"){
                    this.title = "DELETE PRODUCT";
                    this.message = "You have successfully deleted product";
                    this.type = "success";
                    this.show = true;
                    this.show_feedback = true;
            }
            else{
                this.title = "DELETE PRODUCT";
                this.message = "Delete product failed";
                this.type = "error";
                this.show = true;
                this.show_feedback = true;
            }
        }
        catch(error){
            this.title = "DELETE PRODUCT";
            this.message = "SERVER ERROR: Something went wrong! Please reload the page.";
            this.type = "error";
            this.show = true;
            this.show_feedback = true;
        }
    },
  },
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999;
  animation: fadeIn 0.3s;
}

.modal-box {
  background: #fff;
  border-radius: 10px;
  max-width: 420px;
  width: 90%;
  position: relative;
  animation: slideIn 0.3s;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
  overflow: hidden;
}

/* Header */
.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 20px;
  color: white;
}

.modal-header.danger {
  background-color: #dc3545;
}

.modal-header h2 {
  margin: 0;
  font-size: 18px;
}

.header-icon {
  font-size: 20px;
  margin-right: 10px;
}

.close-btn {
  font-size: 24px;
  cursor: pointer;
  color: white;
}

/* Product Info */
.product-info {
  background-color: #f5f5f5;
  margin: 20px;
  padding: 15px;
  border-radius: 6px;
  font-size: 15px;
  color: #333;
  box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05);
}

.warning-text {
  color: #b00020;
  font-weight: bold;
  margin-top: 15px;
}

/* Buttons */
.action-buttons {
  display: flex;
  justify-content: space-between;
  padding: 0 20px 20px 20px;
  gap: 10px;
}

.cancel-btn,
.delete-btn {
  flex: 1;
  padding: 10px;
  font-size: 16px;
  border-radius: 5px;
  border: none;
  cursor: pointer;
  transition: background 0.2s ease;
}

.cancel-btn {
  background-color: #6c757d;
  color: white;
}

.cancel-btn:hover {
  background-color: #5a6268;
}

.delete-btn {
  background-color: #dc3545;
  color: white;
}

.delete-btn:hover {
  background-color: #c82333;
}

/* Animations */
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideIn {
  from {
    transform: translateY(-20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}
</style>
