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
        beforeEnter: (to, from, next) => {
            const publicPages = ['/login', '/register'];
            const authRequired = !publicPages.includes(to.path);
            const loggedIn = localStorage.getItem('user');

            if (authRequired && !loggedIn) {
                return next('/login');
            }

            next();
        }
        // meta: {
        //     hideNavBar: true
        // }
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('../views/Register.vue'),
    },
    {
        path: '/logout',
        name: 'logout',
        component: () => import('../views/Logout.vue'),
    },
    {
        // user 
        path: '/me',
        name: 'User',
        component: () => import('../views/user/Me.vue'),
    }
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(import.meta.env.VITE_HOST_URL_BASE),
    routes
})

export default router
