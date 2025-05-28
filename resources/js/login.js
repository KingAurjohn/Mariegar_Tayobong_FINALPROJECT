import "./bootstrap";
import { createApp } from "vue";

import router from './router';
import Login from "./Login.vue";

createApp(Login).use(router).mount("#app");

