import { createRouter, createWebHistory }  from "vue-router";
import Home from '../views/Home.vue'
import store from '../store'

const routes = [
    { 
        path: '/',
        name :'Home',
        component : Home,
        meta: {
            requiresAuth: true
        }
    },
    { 
        path: '/view/:id',
        name :'ViewResort',
        component : () => import('../views/ViewResort.vue'),
        meta: {
            requiresAuth: true
        }
    },
    { 
        path: '/booking/:id',
        name :'ResortBooking',
        component : () => import('../views/ResortBooking.vue'),
        meta: {
            requiresAuth: true
        }
    },

    // User Routes
    {
        path: '/users',
        name :'User',
        component : () => import('../views/User.vue'),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/user/create',
        name :'CreateUser',
        component : () => import('../views/CreateUser.vue'),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/user/update/:id',
        name: 'UpdateUser',
        component : () => import('../views/UpdateUser.vue'),
        meta: {
            requiresAuth: true
        }
    },
    // Resort
    {
        path: '/resorts',
        name: 'Resort',
        component : () => import('../views/Resort.vue'),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/resort/create',
        name: 'CreateResort',
        component : () => import('../views/CreateResort.vue'),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/resort/update/:id',
        name: 'UpdateResort',
        component : () => import('../views/UpdateResort.vue'),
        meta: {
            requiresAuth: true
        }
    },

    {
        path: '/bookings',
        name: 'Bookings',
        component : () => import('../views/Bookings.vue'),
        meta: {
            requiresAuth: true
        }
    },


    {
        path : '/login',
        name :'Login',
        component : () => import('../views/Login.vue'),
        meta: {
            requiresAuth: false
        }

    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to,from) => {
    if (to.meta.requiresAuth && store.state.token === null) {
        return { name: 'Login' }
    }
    if(to.meta.requiresAuth === false && store.state.token !== null){
        return { name: 'User' }
    }
});



export default router;