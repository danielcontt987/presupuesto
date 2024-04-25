<template>
  <v-app>
    <app-bar />
      <NavegationDrawer 
      :drawer="drawer"
      @update:drawer="updateDrawer"  
      />
    <v-main class="bg-backgroundColor">
      <!-- <v-btn class="primary" @click="logout()">Logout</v-btn> -->
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script setup>
import axios from "axios"
import { provide, ref } from "vue";
import { useRouter } from "vue-router"
import AppBar from "./components/menu/AppBar.vue";
import NavegationDrawer from "./components/menu/NavegationDrawer.vue";

const router = useRouter();

const updateDrawer = (value) => {
  drawer.value = value;
};

const toggleDrawer = () => {
  updateDrawer(!drawer.value);
};

const drawer = ref(true);

provide("drawer", drawer);


const logout = () => {
    axios.post('user/logout').then(() =>{
        window.location.href = "/login"
    })
}
</script>

<style>

</style>