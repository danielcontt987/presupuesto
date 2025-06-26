<template>
  <v-app>
    <NavegationDrawer></NavegationDrawer>
    <app-bar />
    <v-main class="bg-backgroundColor">
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script setup>
import AppBar from "./components/menu/AppBar.vue";
import NavegationDrawer from "./components/Navagation/NavegationDrawer.vue";
</script>

<style>

</style>