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
        path: '/order',
        name: 'order',
        component: () => import('../views/order/Order.vue'),
    },
    {
        path: '/success',
        name: 'success',
        component: () => import('../views/order/Success.vue'),
    },
    {
        path: '/cancel',
        name: 'cancel',
        component: () => import('../views/order/Cancel.vue'),
    },
    {
        // user 
        path: '/me',
        name: 'User',
        component: () => import('../views/user/LayoutUser.vue'),
        children: [
            {
                path: 'favorites',
                name: 'UserFavorites',
                component: () => import('../views/user/Favorites.vue'),
            },
            {
                path: 'list',
                name: 'UserList',
                component: () => import('../views/user/Orders/LayoutOrders.vue'),
                children: [
                    {
                        path: 'orders',
                        name: 'UserOrders',
                        component: () => import('../views/user/Orders/Achat.vue'),
                    },
                    {
                        path: 'sales',
                        name: 'UserSales',
                        component: () => import('../views/user/Orders/VenteForm.vue'),
                    },
                    {
                        path: 'sales/:id',
                        name: 'UserSalesEdit',
                        component: () => import('../views/user/Orders/Sales.vue'),
                    }
                ]
            },
            {
                path: 'profile',
                name: 'UserProfile',
                component: () => import('../views/user/User.vue'),
            }
        ]
    },
    {
        path: '/services',
        name: 'Services',
        component: () => import('../views/Services.vue'),
    },
    {
        path: '/garage',
        name: 'Garage',
        component: () => import('../views/Garage.vue'),
    }
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(import.meta.env.VITE_HOST_URL_BASE),
    routes
})

export default router
