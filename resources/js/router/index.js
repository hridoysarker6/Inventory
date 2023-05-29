import { createRouter, createWebHistory } from "vue-router";

import index from "../pages/frontend/index.vue";
import Login from "../pages/frontend/Login.vue";
import notFound from "../components/NotFound.vue"; 
import ProductList from "../pages/admin/ProductList.vue";
import AddProduct from "../pages/admin/AddProduct.vue"
import Purchase from "../pages/admin/Purchase.vue"
const routes = [
    {
        path: "/",
        component: index, 
    },
    {
        path: "/login",
        component: Login,
        name: "login",
        meta: {
            guestOnly: true,
        },
    },
  
    {
        path: "/product",
        component: ProductList,
        meta: { requiresAuth: true },
    },
    {
        path: "/purchase",
        component: Purchase,
        meta: { requiresAuth: true },
    },
        {
        path: "/product/add",
        component: AddProduct,
        meta: { requiresAuth: true },
    },
    {
        path: "/:pathMatch(.*)*",
        component: notFound,
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem("token");

    if (
        to.matched.some((record) => record.meta.requiresAuth) &&
        !isAuthenticated
    ) {
        next("/login");
    } else if (to.path === "/login" && isAuthenticated) {
        next("/product");
    } else {
        next();
    }
});

export default router;
