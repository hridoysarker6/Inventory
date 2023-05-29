<template>
  <div class="container">
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
    <paginate
      :page-count="totalPages"
      :click-handler="changePage"
      :prev-text="'Prev'"
      :next-text="'Next'"
      :container-class="'pagination'"
      :page-class="'page-item'"
      :prev-class="'page-item'"
      :next-class="'page-item'"
      :active-class="'active'"
      :disabled-class="'disabled'"
    ></paginate>
  </div>
</template>
  
  <script>
import axios from "axios";
// import Paginate from 'vuejs-paginate'
export default {
//     components: {
//     // Paginate, 
//   },
  data() {
    return {
      products: [],
      currentPage: 1,
      productsPerPage: 9
    };
  },
  computed: {
    displayedProducts() {
      const start = (this.currentPage - 1) * this.productsPerPage;
      const end = start + this.productsPerPage;
      return this.products.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.products.length / this.productsPerPage);
    },
  },
  mounted() {
    this.fetchProducts();
  },
  methods: {
    async fetchProducts() {
      try {
        var response = await axios.get("/api/active-products");
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
  