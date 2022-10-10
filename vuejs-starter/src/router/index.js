import * as VueRouter from 'vue-router'

const routes = [
    {
        path: '/',
        name: 'home',
        alias: '/home',
        component: () => import('../views/Home.vue'),
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('../views/Login.vue'),
        // meta: {
        //     hideNavBar: true
        // }
    },
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(import.meta.env.VITE_HOST_URL_BASE),
    routes
})

export default router
