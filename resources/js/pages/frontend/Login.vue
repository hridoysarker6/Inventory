<template>
  <div class="page">
    <div class="page-single">
      <div class="container">
        <div class="row">
          <div class="col-6 col-login mx-auto">
            <div class="card">
              <div class="card-body p-6">
                <div class="card-title">Login to Your Account</div>
                <form @submit.prevent="login">
                  <div class="form-group">
                    <label class="form-label">Email address</label>
                    <input
                      type="email"
                      class="form-control"
                      v-model="email"
                      placeholder="Enter email"
                    />
                  </div>
                  <div class="form-group">
                    <label class="form-label">Password</label>
                    <input
                      type="password"
                      class="form-control"
                      v-model="password"
                      placeholder="Password"
                    />
                  </div>
                  <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-block">
                      Sign in
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post("/api/login", {
          email: this.email,
          password: this.password,
        });
        
       const token =  response.data.data.access.token;
        localStorage.setItem('token', token);
        localStorage.setItem('user', response.data.data.user);
       
        this.$router.push("/product");
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>

<style>
/* Add any custom styling here */
</style>
