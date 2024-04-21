import { createRouter, createWebHistory } from 'vue-router';
const Login = () => import('../view/Login.vue');
const routes = [
    { path: '/', name: 'Login', component: Login },
];
const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});
export default router;