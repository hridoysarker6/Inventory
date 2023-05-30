<template>
  <div class="container pb-5">
    <h1>Product Listing</h1>
    <div class="row">
      <div class="col-md-4" v-for="product in products" :key="product.id">
        <div class="card">
          <img :src="product.image?? '/static/images/placeholder.webp'" class="card-img-top" alt="Product Image" />
          <div class="card-body">
            <h5 class="card-title">{{ product.name }}- (<small>{{ product.code }}</small>)</h5>
            <p class="card-text">Price: {{ product.price }}</p>
            <p class="card-text">Quantity: {{ product.quantity }} {{ product.unit }}</p>
          </div>
        </div>
      </div>
    </div>
 
    <div v-if="products.length>0"> 
       <pagination :pagination="pagination" @page-changed="fetchProducts"></pagination>
    </div>
  </div>
</template>
  
  <script>
import axios from "axios";
 
export default {
    components: {
 
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
    async fetchProducts(page=1) {
      try {
        var response = await axios.get(`/api/active-products?page=${page}`);
        this.pagination = response.data.meta;
        this.products = response.data.data;
      } catch (error) {
        console.error("Error fetching products:", error);
      }
    },
  },
};
</script>
  
  <style>
 
</style>
  