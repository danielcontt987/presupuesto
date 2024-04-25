import {createRouter, createWebHistory} from 'vue-router';

import Login from '../view/Login.vue'
import Admin from '../view/Admin.vue'
import Inicio from '../view/Inicio.vue'

const routes = [
    {
        path: '/',
        redirect: '/login' // or any other default route
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
    },
    {
        path: '/admin',
        name: 'Admin',
        component: Admin,
    },
    {
        path: '/inicio',
        name: 'Inicio',
        component: Inicio,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;