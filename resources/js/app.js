import { createApp } from 'vue';
import App from "@/app.vue";
import { createPinia } from "pinia";
import router from "@/router/router.js";
import Toast from "vue-toastification";
import mixin from "@/mixins/mixin.js";

import "vue-toastification/dist/index.css";

const app = createApp(App);
const pinia = createPinia();

app.mixin(mixin);
app.use(pinia);
app.use(router);
app.use(Toast);
app.mount("#app");
