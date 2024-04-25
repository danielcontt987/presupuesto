import { createRouter, createWebHistory } from 'vue-router';
const Home = () => import('../view/Home.vue');
const Login = () => import('../view/Login.vue');
const Inicio = () => import('../view/Inicio.vue');
const routes = [
    { path: '/inicio', name: 'Inicio', component: Inicio },
    { path: '/login', name: 'Login', component: Login },

];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});
export default router;