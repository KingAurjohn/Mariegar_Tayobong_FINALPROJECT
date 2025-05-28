<template>
  <div class="container">
    <!-- Search and Filter Section -->
     <EditProductVue :edit_info="info" @close="close" v-if="show_edit"/>
     <AddProductVue :add_info="info" @close="close" v-if="show_add"/>
     <deleteProduct :delete_info="info" @close="close" v-if="show_delete"/>
    <form @submit.prevent="goSearch">
        <h2>Search Product</h2>
        <div class="filters" style="border-bottom: 2px solid gray; padding-bottom: 20px;">
            <input
                type="text"
                v-model="searchQuery"
                placeholder="Search by product name"
                class="search-input"
            />
            <select v-model.number="minPrice" style="width: 100px;">
                <option :value="null">All Prices</option>
                <option :value=10000>10,000+</option>
                <option :value=20000>20,000+</option>
                <option :value=30000>30,000+</option>
                <option :value=40000>40,000+</option>
                <option :value=50000>50,000+</option>
                <option :value=100000>100,000+</option>
            </select>
            <input
                type="number"
                v-model.number="maxPrice"
                placeholder="Max Price"
                class="price-input"
                style="width: 100px;"
            />
            <button type="submit" style="padding: 8px 16px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px;">Show All</button>
        </div>
    </form>

    <!-- Table -->
    <table class="product-table">
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Created At</th>
          <th>Edited At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="product in filteredProducts"
          :key="product.id"
        >
          <td>{{ product.name }}</td>
          <td>{{ product.description }}</td>
          <td>₱{{ product.price }}</td>
          <td>{{ product.quantity }}</td>
          <td>{{ returnFormatDatetime(product.created_at) }}</td>
          <td>{{ returnFormatDatetime(product.updated_at) }}</td>
          <td style="width: 200px;">
            <button class="addq-button" @click="addQuantity(product)">+ Qty</button>
            <button class="edit-button" @click="editProduct(product)">Edit</button>
            <button class="delete-button" @click="deleteProduct(product)">Delete</button>
          </td>
        </tr>
        <tr v-if="filteredProducts.length === 0">
          <td colspan="6" class="no-data" style="color: red;">No matching products.</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import AddProductVue from './modals/AddQuantity.vue';
import EditProductVue from "./modals/EditProduct.vue";
import deleteProduct from "./modals/DeleteProduct.vue";
export default {
    components: {
        AddProductVue,
        EditProductVue,
        deleteProduct
    },
  data() {
    return {
      searchQuery: '',
      show_edit: false,
      show_add: false,
      show_delete: false,
      info: {
        data: null,
        show: false,
      },
      minPrice: null,
      maxPrice: null,
      products: [],
    };
  },
  computed: {
    filteredProducts() {
      return this.products.filter(product => {
        const matchesName = product.name.toLowerCase().includes(this.searchQuery.toLowerCase());
        const matchesMin = this.minPrice == null || product.price >= this.minPrice;
        const matchesMax = this.maxPrice == null || product.price <= this.maxPrice;
        return matchesName && matchesMin && matchesMax;
      });
    }
  },
  methods: {
    returnFormatDatetime(date){
              const d = new Date(date);

              const options = {
                timeZone: 'Asia/Manila',
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
              };

              const formatted = new Intl.DateTimeFormat('en-PH', options).format(d);

          return formatted;
      },
    async close(){
        this.show_add = false;
        this.show_delete = false;
        this.show_edit = false;

        await this.returnProducts();
    },


    //this is for showing edit modal
    editProduct(product) {
      this.info.data = product;
      this.info.show = false;
      this.show_edit = true;
    },

    //showing delete modal
    deleteProduct(product) {
      this.info.data = product;
      this.info.show = true;
      this.show_delete = true;
    },

    //showing add quantity modal
    addQuantity(product) {
      this.info.data = product;
      this.info.show = true;
      this.show_add = true;
    },

    async goSearch(){
        this.minPrice = null;
        this.maxPrice = null;
        this.searchQuery = "";
        await this.returnProducts();
        
    },

    async returnProducts(){
        const res = await axios.get('/admin/get-products');

        this.products = res.data.message;
    }
  },

  async mounted(){
    await this.returnProducts();
  }
};
</script>

<style scoped>
.container {
  max-width: 1500px;
  margin: 40px auto;
  padding: 20px;
  background-color: #ffffff;
  border-radius: 12px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.filters {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
  flex-wrap: wrap;
}

.search-input,
.price-input {
  padding: 8px 12px;
  font-size: 14px;
  border-radius: 6px;
  border: 1px solid #ccc;
  width: 200px;
}

.product-table {
  width: 100%;
  border-collapse: collapse;
}

.product-table th,
.product-table td {
  padding: 12px 16px;
  text-align: left;
  border-bottom: 1px solid #ccc;
}

.product-table th {
  background-color: #f5f5f5;
  font-weight: bold;
}

.product-table td {
  color: #444;
}

.product-table tbody tr:hover{
    background-color: #D3D3D3;
}

.edit-button,
.delete-button,
.addq-button {
  padding: 6px 10px;
  margin-right: 5px;
  border: none;
  border-radius: 4px;
  font-size: 13px;
  cursor: pointer;
}

.edit-button {
  background-color: #ffc107;
  color: white;
}

.edit-button:hover {
  background-color: #e0a800;
}

.delete-button {
  background-color: #dc3545;
  color: white;
}

.delete-button:hover {
  background-color: #bd2130;
}

.addq-button {
  background-color: #28a745;
  color: white;
}

.addq-button:hover {
  background-color: #1e7e34;
}

.no-data {
  text-align: center;
  padding: 20px;
  color: #777;
}
</style>
