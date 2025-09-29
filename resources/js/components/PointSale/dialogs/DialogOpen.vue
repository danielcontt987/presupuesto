<template>
    <v-dialog v-model="pointsaleStore.openDialogSell" fullscreen persistent transition="dialog-bottom-transition">
        <v-card full>
            <v-card-title class="primary justify-center">
                <v-col cols="8" md="10">
                    <h4 class="white--text">Total a pagar</h4>
                </v-col>
                <v-col cols="4" md="2">
                    <v-btn block color="white" outlined large class="rounded-lg" :disabled="loading"
                        @click="closeDialog">
                        Cerrar
                    </v-btn>
                </v-col>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12">
                        <v-text-field v-model="pointsaleStore.cash" label="Monto a cobrar" type="number" />
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref } from 'vue';

import { usePointsaleStore } from '@/pinia/pointsale';
const pointsaleStore = usePointsaleStore();
const loading = ref(false);

const closeDialog = () => {
    pointsaleStore.openDialogSell = false;
    pointsaleStore.cash = 0;
}


</script>
