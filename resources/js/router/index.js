import { createRouter, createWebHistory} from "vue-router";

import Home from "../AdminComponents/Home.vue";
import AddProduct from "../AdminComponents/AddProduct.vue";
import Logs from "../AdminComponents/Logs.vue";
import AccountSetting from "../AdminComponents/AccountSetting.vue";

const routes = [
    {
        path: "/home",
        component: Home,
        name: Home
    },
    {
        path: '/account-setting',
        component: AccountSetting,
        name: AccountSetting,
    },
    {
        path: "/add-product",
        component: AddProduct,
        name: AddProduct
    },
    {
        path: "/logs",
        component: Logs,
        name: Logs
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;