window.axios = require("axios")

import * as Vue from "vue/dist/vue.common.js"
import VueRouter from "vue-router"
import SimpleAnalytics from "simple-analytics-vue"
import App from "./app.vue"
import Loading from "./components/layout/loading.vue"
import Index from "./components/index.vue"
import Guide from "./components/guide/guide.vue"
import Recycle from "./components/recycle/recycle.vue"
import RecycleOverview from "./components/recycle/overview.vue"

Vue.use(VueRouter)
Vue.use(SimpleAnalytics, {skip: process.env.MIX_ENABLE_SIMPLE_ANALYTICS !== "true"})
Vue.component("loading", Loading)

const router = new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            name: "index",
            path: "/",
            component: Index
        },
        {
            name: "guide",
            path: "/guide",
            component: Guide
        },
        {
            name: "recycle",
            path: "/recycle/:id",
            component: Recycle
        },
        {
            name: "recycle_overview",
            path: "/recycle/overview/:id",
            component: RecycleOverview
        }
    ]
})

const app = new Vue({
    router,
    render: (h) => h(App)
}).$mount('#app')
