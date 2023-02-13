import * as VueRouter from 'vue-router'
import VueJwtDecode from 'vue-jwt-decode'

const publicPages = ['/login', '/register', '/'];
const user = JSON.parse(localStorage.getItem('user')) ?? null;
const isAdmin = user ? VueJwtDecode.decode(user.token).roles.includes('ROLE_ADMIN') : null;
const isOwner = user ? VueJwtDecode.decode(user.token).roles.includes('ROLE_DEALER') : null;

const needsAuth = (to, from, next) => {
    const authRequired = !publicPages.includes(to.path);
    if (authRequired && !user) {
        return next('/login');
    }
    return next();
}

const needsAdmin = (to, from, next) => {
    if (isAdmin) return next();
    return next('/home');
}

const needsOwner = (to, from, next) => {
    if (isOwner) return next();
    return next('/home');
}

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
        beforeEnter: needsAuth
    },
    {
        // user 
        path: '/me',
        name: 'User',
        component: () => import('../views/user/LayoutUser.vue'),
        beforeEnter: needsAuth,
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
                        path: 'orders/:slug',
                        name: 'UserOrders',
                        component: () => import('../views/user/Orders/Achat.vue'),
                    },
                    {
                        path: 'sales',
                        name: 'UserSales',
                        component: () => import('../views/user/Orders/VenteForm.vue'),
                    },
                    {
                        path: 'sales/:slug',
                        name: 'UserSalesEdit',
                        component: () => import('../views/user/Orders/Sales.vue'),
                    }
                ]
            },
            {
                path: 'orders/:orderId/success/:sessionId',
                name: 'UserOrdersSuccess',
                component: () => import('../views/user/Orders/AchatSuccess.vue'),
            },
            {
                path: 'profile',
                name: 'UserProfile',
                component: () => import('../views/user/User.vue'),
            },
            {
                path: 'concession',
                name: 'Concession',
                component: () => import('../views/user/Concession.vue'),
                beforeEnter: needsOwner
            },
        ]
    },
    {
        // admin
        path: '/admin',
        name: 'Admin',
        component: () => import('../views/admin/LayoutAdmin.vue'),
        beforeEnter: needsAdmin,
        children: [
            {
                path: 'users',
                name: 'users',
                component: () => import('../views/admin/UsersAdmin.vue'),
            },
            {
                path: 'cars',
                name: 'cars',
                component: () => import('../views/admin/CarAdmin.vue'),
            },
            {
                path: 'orders',
                name: 'orders',
                component: () => import('../views/admin/OrderAdmin.vue'),
            }
        ]
    },
    {
        path: '/services',
        name: 'Services',
        beforeEnter: (to, from, next) => needsAuth(to, from, next),
        component: () => import('../views/Services.vue'),
    },
    {
        path: '/garage',
        name: 'Garage',
        component: () => import('../views/Garage.vue'),
    },
    {
        path: '/garage/:identityId',
        name: 'GarageByCarIdentity',
        component: () => import('../views/Garage.vue'),
    },
    {
        path: '/forgot_password',
        name: 'ForgotPassword',
        component: () => import('../views/ForgotPassword.vue'),
    },
    {
        path: '/account_recovery/:token',
        name: 'AccountRecovery',
        component: () => import('../views/AccountRecovery.vue'),
    },
    {
        path: '/model',
        name: 'Model',
        component: () => import('../views/CarModel.vue'),
    },
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory(import.meta.env.VITE_HOST_URL_BASE),
    routes
})

export default router
