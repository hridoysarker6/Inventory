<template>
  <div class="container">
    <div class="navbar">
      <ul class="d-flex navbar nav">
        <li class="nav-item">
          <router-link to="/" class="nav-item nav-link">Home</router-link>
        </li>

        <li class="nav-item">
          <router-link
            v-if="!isAuthenticated"
            to="/login"
            class="nav-item nav-link"
            >Login</router-link
          >
        </li>
        <li class="nav-item">
          <router-link
            v-if="isAuthenticated"
            to="/product"
            class="nav-item nav-link"
            >Dashboard</router-link
          >
        </li>

        <li v-if="isAuthenticated">
          <a @click="logout" class="nav-item nav-link cursor-pointer">Logout</a>
        </li>
      </ul>
    </div>
  </div>

  <router-view />
</template>

<script>
export default {
  data() {
    return {
      isAuthenticated:  null,
    };
  },

  methods: {
    async logout() {
      const token = localStorage.getItem("token");
      try {
        const response = await axios.post("/api/logout", null, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        this.handleLogout();
      } catch (error) {
        this.handleLogout();
      }
    },
    handleLogout() {
      localStorage.removeItem("token");
      this.isAuthenticated = false;
      this.$router.push("/login");
    },
    checkAuth() {
      this.isAuthenticated = !!localStorage.getItem("token");
    },
  },

  mounted() {
    this.checkAuth();
  },
};
</script>
