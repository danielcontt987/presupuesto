<template>
    <v-row>
      <v-col cols="12" md="10">
        <v-btn
          class="rounded-lg" color="error" flat size="large"
          @click="emitRoute">
          <v-icon left>mdi-arrow-left-circle-outline</v-icon>
          Regresar
        </v-btn>
      </v-col>
      <v-col cols="12" md="2" sm="12" class="text-end">
        <slot></slot>
      </v-col>
    </v-row>
  </template>
  
  <script setup>
  import { defineEmits } from 'vue';
  
  const emit = defineEmits(['backAction']);
  
  const emitRoute = () => {
    emit('backAction');
  };
  </script>
  
  <style scoped lang="sass">
  </style>
  