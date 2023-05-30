<template>
  <Layout>
    <div class="product-list">
      <div class="d-flex">
        <div class="card-header">
          <h2>Product List</h2>
        </div>
        <div class="card-options">
          <ul class="d-flex navbar nav">
            <li class="nav-item">
              <router-link to="/product/add" class="nav-item nav-link"
                >Add Product</router-link
              >
            </li>
            <li class="nav-item">
              <router-link to="/purchase" class="nav-item nav-link"
                >Purchase Product</router-link
              >
            </li>
            <div class="col-2"></div>
          </ul>
        </div>
      </div>
      <table>
        <thead>
          <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products" :key="product.id">
            <td>
              <img
                :src="product.image ?? '/static/images/placeholder.webp'"
                alt="Product Image"
                class="product-image"
              />
            </td>
            <td>{{ product.name }}</td>
            <td>{{ product.price }}</td>
            <td>{{ product.quantity }}</td>
            <td>{{ product.status }}</td>
            <td>
              <button @click="deleteProduct(product.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-if="products.length > 0" class="  ">
        <pagination
          :pagination="pagination"
          @page-changed="fetchProducts"
        ></pagination>
      </div>
    </div>
  </Layout>
</template>

<script>
import axios from "axios";
import Layout from "./Layout.vue";

export default {
  components: {
    Layout,
  },
  data() {
    return {
      products: [],
    };
  },
  mounted() {
    this.fetchProducts();
  },
  methods: {
    async fetchProducts(page = 1) {
      try {
        const token = localStorage.getItem("token");

        const response = await axios.get("/api/products", {
          params: {
            per_page: 10,
            page: page,
          },
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        this.pagination = response.data.meta;
        this.products = response.data.data;
      } catch (error) {
        console.log(error);
      }
    },

    deleteProduct(productId) {
      if (confirm("Are you sure?")) {
        const token = localStorage.getItem("token");

        axios
          .delete("/api/products/" + productId, {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          })
          .then((response) => {
            alert("Product delete successfully");
            this.fetchProducts();
          });
      }
    },
  },
};
</script>

<style scoped>
.product-list {
  margin-top: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th,
td {
  padding: 10px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f5f5f5;
}

.product-image {
  width: 50px;
  height: 50px;
  object-fit: cover;
}
</style>
