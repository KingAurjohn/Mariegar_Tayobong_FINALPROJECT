<template>
  <div class="add-product-container">
    <feedbackVue :message="message" :type="type" :title="title" :show="show" @close="close" v-show="show_feedback"/>
    <h2>Add New Product</h2>
    <form @submit.prevent="submitProduct">
      <div class="form-group">
        <label for="name">Product Name</label>
        <input type="text" id="name" v-model="product.name" required />
      </div>

      <label style="color: gray;">Quantity should be whole number</label>
      <div class="form-group" style="margin-top: 5px;">
        <label for="quantity">Quantity</label>
        <input type="number" id="quantity" v-model.number="product.quantity" required />
      </div>

      <div class="form-group">
        <label for="price">Price</label>
        <input type="number" id="price" v-model.number="product.price" step="0.01" required />
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" v-model="product.description"></textarea>
      </div>

      <button type="submit">Add Product</button>

      <p v-if="submitted" class="success-message">✅ Product added successfully!</p>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import feedbackVue from '../modal_feedback/feedback.vue';

export default {
    components: {
        feedbackVue
    },
  name: 'AddProduct',
  data() {
    return {
        show_feedback: false,
        type: "",
        message: "",
        title: "",
        show: false,
      product: {
        name: '',
        quantity: 0,
        price: 0.0,
        description: '',
      },
      submitted: false
    };
  },

  watch: {
    "product.quantity"(newVal, oldVal){
        if(!Number.isInteger(newVal) && newVal){
            this.product.quantity = oldVal;
        }
    }
  },

  methods: {
    close(){
        this.show_feedback = false;
    },

    async submitProduct() {
        try{
            const data = new FormData();
            data.append('data', JSON.stringify(this.product));

            const res = await axios.post('/admin/add-product', data);

            if(res.data.message === "success"){
                this.title = "ADDING PRODUCT";
                this.message = "You have successfully added product/s";
                this.type = "success";
                this.show = true;
                this.show_feedback = true;
            }
            else{
                this.title = "ADDING PRODUCT";
                this.message = "Adding product failed";
                this.type = "error";
                this.show = true;
                this.show_feedback = true;
            }

            this.product = {
                name: '',
                quantity: 0,
                price: 0.0,
                description: '',
            };
        }
        catch(error){
            this.title = "ADDING PRODUCT";
            this.message = "Something went wrong! Please reload the page";
            this.type = "error";
            this.show = true;
            this.show_feedback = true;
        }
    }
  }
};
</script>

<style scoped>
.add-product-container {        
  width: 60%;
  margin: 40px auto;
  padding: 30px;
  padding-right: 55px;      
  border-radius: 16px;
  background: linear-gradient(to bottom right, #ffffff, #f0f4f7);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
  transition: box-shadow 0.3s ease;
}

.add-product-container:hover {
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
}

.add-product-container h2 {
  text-align: center;
  margin-bottom: 24px;
  font-size: 24px;
  color: #2c3e50;
}

.form-group {
  margin-bottom: 16px;
  transition: all 0.3s ease;
}

.form-group label {
  display: block;
  margin-bottom: 6px;
  font-weight: 600;
  color: #333;
}

.form-group input,
.form-group textarea {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 15px;
  transition: border-color 0.3s, box-shadow 0.3s;
}

.form-group input:focus,
.form-group textarea:focus {
  border-color: #ff69b4;
  box-shadow: 0 0 5px rgba(46, 204, 113, 0.5);
  outline: none;
}

.form-group textarea {
  resize: vertical;
  min-height: 80px;
}

button[type="submit"] {
  width: 100%;
  padding: 12px;
  background-color: #ff69b4;
  color: white;
  font-weight: bold;
  font-size: 16px;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  transition: background-color 0.3s, transform 0.2s;
}

button[type="submit"]:hover {
  background-color: #27ae60;
  transform: scale(1.02);
}

button[type="submit"]:active {
  transform: scale(0.98);
}

.success-message {
  margin-top: 16px;
  color: #27ae60;
  font-weight: 500;
  text-align: center;
  animation: fadeIn 0.4s ease-in;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-5px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
