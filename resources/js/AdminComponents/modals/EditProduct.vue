<template>
  <div v-if="edit_info.show" class="modal-overlay" @click.self="close">
        <feedbackVue :message="message" :type="type" :title="title" :show="show" @close="close" v-show="show_feedback"/>
    <div class="modal-box">
      <span class="close-btn" @click="close">&times;</span>
      <h2>Edit Product</h2>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label>Product Name:</label>
          <input type="text" v-model="editableProduct.name" required />
        </div>

        <div class="form-group">
          <label>Quantity:</label>
          <input type="number" v-model.number="editableProduct.quantity" min="0" required />
        </div>

        <div class="form-group">
          <label>Price:</label>
          <input type="number" v-model.number="editableProduct.price" min="0" step="0.01" required />
        </div>

        <div class="form-group">
          <label>Description:</label>
          <textarea v-model="editableProduct.description"></textarea>
        </div>

        <button type="submit" class="submit-btn">Edit Product</button>
      </form>
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
  props: ['edit_info'],
  data() {
    return {
      editableProduct: {
        name: "",

      },
    show_feedback: false,
    type: "",
    message: "",
    title: "",
    show: false,
    };
  },
  watch: {
    product: {
      handler(newProduct) {
        this.editableProduct = { ...newProduct };
      },
      immediate: true,
    },
  },
  methods: {
    close() {
      this.$emit('close');
    },
    async submitForm() {
        try{
            const data = new FormData();
            data.append('data', JSON.stringify(this.editableProduct));
            data.append('id', this.editableProduct.id);

            const res = await axios.post('/admin/edit-product', data);

            if(res.data.message === "success"){
                this.title = "EDIT PRODUCT";
                this.message = "You have successfully edited product";
                this.type = "success";
                this.show = true;
                this.show_feedback = true;
            }
            else{
                this.title = "EDIT PRODUCT";
                this.message = "Edit product failed";
                this.type = "error";
                this.show = true;
                this.show_feedback = true;
            }
        }
        catch(error){
            this.title = "EDIT PRODUCT";
            this.message = "Something went wrong! Please reload the page";
            this.type = "error";
            this.show = true;
            this.show_feedback = true;
        }
    },
  },
  mounted(){
    console.log(this.edit_info);
    this.editableProduct = this.edit_info.data;
    this.edit_info.show = true;
  }
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
  padding: 25px 30px;
  border-radius: 8px;
  max-width: 500px;
  width: 90%;
  position: relative;
  animation: slideIn 0.3s;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
}

.close-btn {
  position: absolute;
  top: 12px;
  right: 16px;
  font-size: 22px;
  cursor: pointer;
  color: #666;
}

h2 {
  margin-top: 0;
  margin-bottom: 20px;
  text-align: center;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  font-weight: bold;
  margin-bottom: 6px;
}

input[type="text"],
input[type="number"],
textarea {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 15px;
}

textarea {
  resize: vertical;
}

.submit-btn {
  display: block;
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  font-size: 16px;
  border-radius: 5px;
  cursor: pointer;
}

.submit-btn:hover {
  background-color: #0056b3;
}

@keyframes fadeIn {
  from { opacity: 0; } 
  to { opacity: 1; }
}

@keyframes slideIn {
  from { transform: translateY(-20px); opacity: 0; }
  to { transform: translateY(0); opacity: 1; }
}
</style>
