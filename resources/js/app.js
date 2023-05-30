import "./bootstrap";
import { createApp } from "vue";

import app from "./components/app.vue";
import router from "./router";
import Pagination from './components/Pagination.vue';

createApp(app).use(router).component('pagination', Pagination).mount("#app");
