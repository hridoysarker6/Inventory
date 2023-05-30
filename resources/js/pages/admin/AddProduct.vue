<template>
  <Layout>
    <div class="px-5 pb-5">
      <div class="d-flex justify-content-between">
        <h2 class="page-title">Add Product</h2>
        <router-link to="/product" class="nav-item nav-link">
          >>Back to Product Page</router-link
        >
      </div>

      <form @submit.prevent="addProduct" class="card">
        <div class="card-body">
          <div class="form-group">
            <label for="name">Name</label>
            <input
              type="text"
              id="name"
              v-model="newProduct.name"
              class="form-control"
              required
            />
          </div>
          <div class="form-group">
            <label for="price">Price</label>
            <input
              type="number"
              id="price"
              v-model="newProduct.price"
              class="form-control"
              required
            />
          </div>

          <div class="form-group">
            <label for="unit">Unit</label>
            <input
              type="text"
              id="unit"
              v-model="newProduct.unit"
              class="form-control"
              required
            />
          </div>

          <div class="form-group">
            <label for="description">Description</label>
            <textarea
              name="description"
              id="description"
              class="form-control"
              v-model="newProduct.description"
            ></textarea>
          </div>

          <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" id="image" @change="onImageChange" required />
          </div>

          <div class="form-group">
            <label for="status">Is Active</label>
            <input
              type="checkbox"
              id="status"
              v-model="newProduct.status"
              class="form-control-checkbox"
            />
          </div>
          <button type="submit" class="btn btn-primary">Add Product</button>
        </div>
      </form>
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
      newProduct: {
        name: "",
        price: null,
        unit: null,
        status: true,
        image: "",
        description: "",
      },
    };
  },
  methods: {
    addProduct() {
      const token = localStorage.getItem("token");

      const formData = new FormData();
      formData.append("name", this.newProduct.name);
      formData.append("price", this.newProduct.price);
      formData.append("unit", this.newProduct.unit);
      formData.append("status", this.newProduct.status === true ? 1 : 0);
      formData.append("image", this.newProduct.image);
      formData.append("description", this.newProduct.description);

      axios
        .post("/api/products", formData, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((response) => {
          alert("Product added successfully");
          this.$router.push("/product");
        })
        .catch((error) => {
          console.error("Error adding product:", error);
        });
    },
    onImageChange(event) {
      const file = event.target.files[0];
      this.newProduct.image = file;
    },
  },
};
</script>

<style scoped>
.page-title {
  margin-top: 20px;
}

.container {
  max-width: 500px;
  margin: 0 auto;
}

.card {
  margin-top: 20px;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
}

.btn-primary {
  padding: 10px 20px;
}
</style>
