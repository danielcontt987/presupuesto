<template>
  <v-app>
    <app-bar-normal />
    <navegation-drawer />
    <v-main class="bg-backgroundColor">
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script setup>
import AppBarNormal from "./components/menu/AppBarNormal.vue";
import NavegationDrawer from "./components/menu/NavegationDrawer.vue";
</script>

<style>

</style>