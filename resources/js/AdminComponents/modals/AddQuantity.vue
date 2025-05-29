<template>
  <div v-if="add_info.show" class="modal-overlay" @click.self="close">
    <feedbackVue :message="message" :type="type" :title="title" :show="show" @close="close" v-show="show_feedback"/>
    <div class="modal-box">
      <div class="modal-header">
        <h2>ADD QUANTITY</h2>
        <span class="close-btn" @click="close">&times;</span>
      </div>

      <div class="product-info">
        <p><strong>Product:</strong> {{ add_info.data.name }}</p>
        <p><strong>Description:</strong> {{ add_info.data.description }}</p>
        <p><strong>Current Stock:</strong> {{ add_info.data.quantity }}</p>
      </div>

      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="quantity">Add Quantity:</label>
          <input
            type="number"
            id="quantity"
            v-model.number="quantity"
            min="1"
            required
          />
        </div>
        <button type="submit" class="submit-btn">Submit</button>
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
  props: ['add_info'],
  data() {
    return {
            show_feedback: false,
    type: "",
    message: "",
    title: "",
    show: false,
      quantity: 1,
    };
  },
  watch: {
    quantity(newVal, oldVal){
        if(!Number.isInteger(newVal) && newVal){
            this.quantity = oldVal;
        }
    }
  },
  methods: {
    close() {
      this.quantity = 1;
      this.$emit("close");
    },
    async submitForm() {
        try{
            const data = new FormData();
        data.append('new_quantity', this.quantity);
        data.append('id', this.add_info.data.id);

        const res = await axios.post('/admin/add-quantity', data);

        if(res.data.message === "success"){
                this.title = "ADD STOCK";
                this.message = "You have successfully added stock of " + this.add_info.data.name;
                this.type = "success";
                this.show = true;
                this.show_feedback = true;
        }
        else{
            this.title = "ADD STOCK";
            this.message = "add stock product failed";
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
  background-color: #ff69b4;
  color: white;
  padding: 16px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid #ddd;
}

.modal-header h2 {
  margin: 0;
  font-size: 18px;
}

.header-icon {
  margin-right: 10px;
  font-size: 20px;
}

/* Close button */
.close-btn {
  font-size: 24px;
  cursor: pointer;
  color: white;
}

/* Product Info Box */
.product-info {
  background-color: #f5f5f5;
  margin: 20px;
  padding: 15px;
  border-radius: 6px;
  font-size: 15px;
  line-height: 1.5;
  color: #333;
  box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05);
}

.form-group {
  margin: 20px;
  margin-top: 10px;
}

label {
  display: block;
  font-weight: bold;
  margin-bottom: 6px;
}

input[type="number"] {
  width: 100%;
  padding: 10px;
  font-size: 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.submit-btn {
  width: calc(100% - 40px);
  margin: 0 20px 20px 20px;
  padding: 10px;
  background-color: #ff69b4;
  color: white;
  border: none;
  font-size: 16px;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.2s ease;
}

.submit-btn:hover {
  background-color: #218838;
}

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
