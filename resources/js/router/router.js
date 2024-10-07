import { createWebHistory, createRouter } from "vue-router";
import routes from "@/router/routes.js";
import { userStore } from "@/stores/user.js";

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const auth = userStore();

    let user = auth.getUserData();
    const requiresAuth = !to.meta.guestOnly;
    const isAuthenticated = user?.token;

    if (requiresAuth && !isAuthenticated) {
        next({ path: "/login" });
    } else if (to.path === "/login" && isAuthenticated) {
        next({ path: "/" });
    } else {
        next();
    }
});

router.afterEach((to) => {
    if (to.meta && to.meta.title) {
        document.title = to.meta.title + " | URL Shortener System";
    }
    else
        document.title = "URL Shortener System";
});

export default router;
