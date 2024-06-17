<template>
    <v-card
        elevation="0"
        style="margin-bottom: 0px !important"
        class="rounded-lg"
    >
        <v-card-title>
            <v-row class="mx-0">
                <v-col cols="12" md="8" lg="10">
                    <v-chip
                        color="background"
                        class="text-primary rounded-lg pa-5 font-weight-bold"
                        label
                    >
                        Crear módulo
                    </v-chip>
                </v-col>
                <v-col cols="12" md="4" lg="2" class="text-right">
                    <v-btn
                        color="background"
                        flat
                        class="rounded-lg text-primary"
                        @click="openModal"
                    >
                        <b>AGREGAR</b>
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-title>
        <v-card-text>
            <v-data-table :headers="headers"></v-data-table>
        </v-card-text>
        <VMModule/>
    </v-card>
</template>
<script setup>
import { ref, onMounted } from 'vue';
import VMModule from '../Modal/VMModule.vue';
import { useModuleStore } from "../../pinia/module.js";

const moduleStore = useModuleStore();

const headers = [
    {
        title: "Nombre del módulo",
        key: "",
        align: "center",
        class: "",
    },
    {
        title: "Fecha de registro",
        key: "",
        align: "center",
        class: "",
    },
    {
        title: "Acciones",
        key: "",
        align: "center",
        class: "",
    },
];

const yourDateValue = ref('2024-06-16T14:00:00Z');

const modalOpen = ref(false);

const openModal = () => {
    moduleStore.showModal(true);
}

</script>
