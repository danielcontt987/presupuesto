<template>
  <v-app>
    <app-bar />
    <v-main class="bg-backgroundColor">
      <!-- <v-btn class="primary" @click="logout()">Logout</v-btn> -->
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script setup>
import AppBar from "./components/menu/AppBar.vue";
</script>

<style>

</style>