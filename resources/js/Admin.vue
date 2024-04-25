<template>
  <h2>hola</h2>
  <v-btn color="primary" @click="logout">Cerrar sesion</v-btn>
</template>

<script setup>
import axios from "axios"
import { useRouter } from "vue-router"
const router = useRouter();

const logout = () => {
    axios.post('user/logout').then(() =>{
        window.location.href = "/login"
    })
}
</script>

<style>

</style>