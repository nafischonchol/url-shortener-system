import mainLayout from "@/layouts/main.vue";

import dashboard from "@/pages/dashboard/index.vue";

import login from "@/pages/authenticate/login.vue";
import register from "@/pages/authenticate/register.vue";

let routes = [
    {
        path: "/",
        name: "dashboard",
        components: {
            default: dashboard,
            layouts: mainLayout,
        },
        meta: { title: "Dashboard" },
    },
    {
        path: "/login",
        name: "login",
        components: {
            default: login,
            layouts: mainLayout,
        },
        meta: { title: "Login", guestOnly: true },
    },
    {
        path: "/register",
        name: "register",
        components: {
            default: register,
            layouts: mainLayout,
        },
        meta: { title: "Register", guestOnly: true },
    },
];
export default routes;
