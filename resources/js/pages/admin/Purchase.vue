<template>
  <div>
    <Layout>
      <div class="container p-3">
        <div class="d-flex justify-content-between">
          <h2 class="page-title pb-3">Purchase Page</h2>
          <router-link to="/product" class="nav-item nav-link">
            >>Back to Product Page</router-link
          >
        </div>

        <form @submit.prevent="storePurchase" class="">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <div class="form-group">
                  <label for="date"
                    >Date <small class="text-red">*</small></label
                  >
                  <input
                    type="date"
                    id="date"
                    v-model="purchase.date"
                    class="form-control"
                   required
                  />
                  <span v-if="errors.date" class="text-danger">{{ errors.date[0] }}</span>
                </div>
              </div>
             


              <div class="col">
                <div class="form-group">
                  <label for="invoice_no"
                    >Invoice No. <small class="text-red">*</small></label
                  >
                  <input
                    type="text"
                    id="invoice_no"
                    v-model="purchase.invoice_no"
                    class="form-control"
                    required
                  />
                  <span v-if="errors.invoice_no" class="text-danger">{{ errors.invoice_no[0] }}</span>
                </div>
              </div>

              <div class="col">
                <div class="form-group">
                  <label for="supplier_id">Supplier</label>
                  <select
                    id="supplier_id"
                    v-model="purchase.supplier_id"
                    class="form-control"
                     
                  >
                    <option value="">Select Supplier</option>

                    <option
                      v-for="supplier in suppliers"
                      :value="supplier.id"
                      :key="supplier.id"
                    >
                      {{ supplier.name }}
                    </option>
                  </select>

                  <span v-if="errors.supplier_id" class="text-danger">{{ errors.supplier_id[0] }}</span>
                </div>
              </div>
            </div>

            <div class="card mt-4 mb-3">
              <div>
                <input
                  type="text"
                  v-model="searchKey"
                  @input="productSearch"
                  placeholder="Search products..."
                  class="form-control"
                />
                <ul v-if="products.length > 0" class="search-results">
                  <li
                    v-for="product in products"
                    :key="product.id"
                    @click="addProductToPurchase(product)"
                  >
                    {{ product.name }}
                  </li>
                </ul>
              </div>
            </div>
            <div class="card my-2">
              <div class="card-body">
                <div class="row">
                  <div class="col">Product Name</div>
                  <div class="col">stock</div>
                  <div class="col">Quantity</div>
                  <div class="col">Price</div>
                  <div class="col">Total Price</div>
                </div>

                <div
                  v-for="(item, index) in purchase.purchase_items"
                  :key="index"
                  class="row px-2 my-2"
                >
                  <div class="col d-flex gap-2">
                    <span class="py-2">{{ ++index }}. </span>
                    <input
                      type="text"
                      class="form-control"
                      v-model="item.productName"
                      disabled
                    />
                    <span v-if="errors.product_id" class="text-danger">{{ errors.product_id[0] }}</span>
                  </div>
                  <div class="col">
                    <input
                      type="text"
                      class="form-control"
                      v-model="item.productStock"
                      disabled
                    />

                  </div>
                  <div class="col">
                    <input
                      type="number"
                      v-model="item.quantity"
                      class="form-control"
                       required
                      placeholder="quantity"
                      @input="calculateTotals"
                    />
                  
                  </div>
                  <div class="col">
                    <input
                      type="number"
                      v-model="item.price"
                      class="form-control"
                      required
                      placeholder="price"
                      @input="calculateTotals"
                    />
                  </div>
                  <div class="col">
                    <input
                      type="number"
                      v-model="item.total"
                      class="form-control"
                      required
                      placeholder="total"
                      readonly
                    />
                  </div>
                  <div class="col-1">
                    <button
                      v-if="purchase.purchase_items.length > 1"
                      type="button"
                      class="btn btn-danger"
                      @click="removeItem(index)"
                    >
                      Remove
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-8">
                <div class="form-group">
                  <label for="note">Note</label>
                  <textarea
                    id="note"
                    v-model="purchase.note"
                    class="form-control"
                  ></textarea>
                </div>
              </div>
              <div class="col-4">
                <div class="form-group">
                  <label for="total_amount">Total</label>
                  <input
                    type="number"
                    id="total_amount"
                    v-model="purchase.total_amount"
                    class="form-control"
                    required
                  />
                  <span v-if="errors.total_amount" class="text-danger">{{ errors.total_amount[0] }}</span>
                </div>
              </div>
            </div>

            <div class="p-3 offset-10 col-2">
              <button type="submit" class="btn btn-primary">Confirm</button>
            </div>
          </div>
        </form>
      </div>
    </Layout>
  </div>
</template>

<script>
import axios from "axios";
import Layout from "./Layout.vue";

const token = localStorage.getItem("token");
export default {
  components: {
    Layout,
  },
  data() {
    return {
      purchase: {
        date: null,
        invoice_no: null,
        supplier_id: null,
        purchase_items: [
          {
            product_id: null,
            quantity: null,
            price: null,
            total: null,
            productName: null,
            productUnit: null,
            productStock: null,
          },
        ],
        total_amount: null,
        note: "",
      },
      suppliers: [],
      products: [],
      searchKey: "",
      errors: {},
    };
  },

  mounted() {
    this.getSupplier();
  },
  watch: {
    "purchase.purchase_items": {
      deep: true,
      handler: "calculateTotals",
    },
  },
  methods: {
    getSupplier() {
      try {
        const token = localStorage.getItem("token");

        axios
          .get("/api/suppliers", {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          })
          .then((response) => {
            console.log(response.data);
            this.suppliers = response.data.data;
          });
      } catch (error) {
        console.log(error);
      }
    },
    storePurchase() {
      try {
        axios
          .post(
            "/api/purchases",
            this.purchase,

            {
              headers: {
                Authorization: `Bearer ${token}`,
              },
            }
          )
          .then((response) => {
            console.log('re')
            alert(response.data.message);
          }) .catch((error) => {
            console.log(error.response.data.errors)
            if (error.response && error.response.status === 422) {
            this.errors = error.response.data.errors;
          } else {
            console.log(error);
          }
          });
      } catch (error) {
        console.log('sdf')
        
      }
    },
    productSearch() {
      try {
        if (this.searchKey.length > 0) {
          axios
            .get("/api/products?per_page=10&search_key=" + this.searchKey, {
              headers: {
                Authorization: `Bearer ${token}`,
              },
            })
            .then((response) => {
              this.products = response.data.data;
            });
        } else {
          this.products = [];
        }
      } catch (error) {}
    },
    addProductToPurchase(product) {
      const newPurchaseItem = {
        productName: product.name,
        productUnit: product.unit,
        productStock: product.quantity,
        product_id: product.id,
        quantity: null,
        price: product.price,
        total: 0,
      };

      var previousItem = this.purchase.purchase_items.filter(function (item) {
        return item.product_id !== null;
      });
      console.log(previousItem);

      this.purchase.purchase_items = [...previousItem, newPurchaseItem];
      this.searchKey = "";
      this.products = [];
    },

    removeItem(index) {
      this.purchase.purchase_items = this.purchase.purchase_items.splice(
        index,
        1
      );
    },
    calculateItemTotal(item) {
      return item.quantity * item.price;
    },
    calculateTotals() {
      this.purchase.purchase_items.forEach((item) => {
        item.total = this.calculateItemTotal(item);
      });

      this.purchase.total_amount = this.purchase.purchase_items.reduce(
        (total, item) => total + item.total,
        0
      );
    },
  },
};
</script>

<style>
.search-results {
  list-style: none;
  padding: 0;
  margin: 5px 0;
}

.search-results li {
  cursor: pointer;
  padding: 5px;
  background-color: #f8f8f8;
}

.search-results li:hover {
  background-color: #ebebeb;
}
</style> 