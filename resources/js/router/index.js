import {createRouter, createWebHistory} from 'vue-router';

import Login from '../view/Login.vue';
import Admin from '../view/Admin.vue';
import Inicio from '../view/Inicio.vue';
import Ajustes from '../view/Setting.vue';
import Area from '../view/Area.vue';
import AreaDetails from '../view/Areas/AreaDetails.vue';
import CreateModule from '../view/Module/CreateModule.vue';
import Cotizacion from '../view/Quotation/Quotation.vue';



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
        path: '/cotizaciones',
        name: 'Cotizaciones',
        component: Cotizacion,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;