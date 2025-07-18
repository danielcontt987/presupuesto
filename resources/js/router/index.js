import { createRouter, createWebHistory } from 'vue-router';

import Login from '../view/Login.vue';
import Admin from '../view/Admin.vue';
import Inicio from '../view/Inicio.vue';
import Ajustes from '../view/Setting.vue';
import Area from '../view/Area.vue';
import AreaDetails from '../view/AreaDetail/AreaDetails.vue';
import CreateModule from '../view/Module/CreateModule.vue';
import PointOfSale from '../view/PointOfSale/PointOfSale.vue';
import Client from '../view/Client/Client.vue';
import CreateClient from '../view/Client/CreateClient.vue';
import Product from '../view/Product/Product.vue';
import CreateProduct from '../view/Product/CreateProduct.vue';
import Restaurant from '../view/Restaurant/Restaurant.vue';

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
    {
        path: '/configuracion',
        name: 'Ajustes',
        component: Ajustes,
    },
    {
        path: '/areas',
        name: 'Area',
        component: Area,
    },
    {
        path: '/detalle-del-area',
        name: 'Detalle del area',
        component: AreaDetails,
    },
    {
        path: '/crear-modulos',
        name: 'Registrar modulos',
        component: CreateModule,
    },
    {
        path: '/punto-de-venta',
        name: 'Punto de venta',
        component: PointOfSale,
    },
    {
        path: '/restaurante',
        name: 'Restaurante',
        component: Restaurant,
    },
    {
        path: '/clientes',
        name: 'Clientes',
        component: Client,
    },
    {
        path: '/crear-cliente',
        name: 'Crear cliente',
        component: CreateClient,
    },
    {
        path: '/productos',
        name: 'Productos',
        component: Product,
    },
    {
        path: '/crear-producto',
        name: 'Crear producto',
        component: CreateProduct,
    },
    {
        path: '/:pathMatch(.*)*',
        name: '404',
        component: () => import('../view/NotFound/404.vue'),
    },
    {
        path: '/mi-perfil',
        name: 'Mi perfil',
        component: () => import('../view/Profile/Profile.vue'),
    },
    {
        path: '/proyectos',
        name: 'Proyectos',
        component: () => import('../view/Project/Project.vue'),
    },
    {
        path: '/seleccionar',
        name: 'Seleccionar',
        component: () => import('../view/Restaurant/SelectProduct.vue'),
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;