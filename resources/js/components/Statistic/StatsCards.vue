<template>
    <v-row>
        <v-col cols="12" md="6" lg="4">
            <info-card icon="mdi-currency-usd" title="Total" text="546000" color="success" isCurrency />
        </v-col>
        <v-col cols="12" md="6" lg="4">
            <info-card icon="mdi-arrow-up-bold" title="Proveedor al que más le debo" text="Juan Gabriel"
                color="warning" />
        </v-col>
        <v-col cols="12" md="6" lg="4">
            <info-card icon="mdi-arrow-down-bold" title="Proveedor al que menos le debo" text="Javier Solís"
                color="info" />
        </v-col>
    </v-row>
</template>

<script setup>
// No props ni lógica, solo presentación
import InfoCard from "@/components/Statistic/InfoCard.vue";
</script>
