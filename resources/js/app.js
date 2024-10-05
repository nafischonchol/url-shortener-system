import { createApp } from 'vue';
import App from "@/app.vue";
import { createPinia } from "pinia";
import router from "@/router/router.js";

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.mount("#app");
