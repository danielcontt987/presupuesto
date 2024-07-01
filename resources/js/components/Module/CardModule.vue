<template>
    <v-card
        elevation="0"
        style="margin-bottom: 0px !important"
        class="rounded-lg"
        v-if="moduleStore.isLoading"
    >
        <v-card-text>
            <v-skeleton-loader type="article"></v-skeleton-loader>
            <v-skeleton-loader type="article"></v-skeleton-loader>
            <v-skeleton-loader type="article"></v-skeleton-loader>
        </v-card-text>
    </v-card>
    <v-card
        elevation="0"
        style="margin-bottom: 0px !important"
        class="rounded-lg"
        v-else
    >
        <v-card-title>
            <v-row class="mx-0">
                <v-col cols="12" md="8" lg="10">
                    <v-chip
                        color="background"
                        class="text-primary rounded-lg pa-5 font-weight-bold"
                        label
                        width="100%"
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
            <v-data-table :headers="headers" :items="moduleStore.modules">
                <template v-slot:item.date="{ item }">
                    {{ $formatDatetime(item.created_at) }}
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        icon="mdi-pencil"
                        class="rounded-lg mr-2"
                        flat
                        size="small"
                        color="primary"
                        @click="goToDetail(item.id)"
                    ></v-btn>
                    <v-btn
                        icon="mdi-delete"
                        class="rounded-lg"
                        flat
                        size="small"
                        color="error"
                        @click="goToDetail(item.id)"
                    ></v-btn>
                </template>
            </v-data-table>
        </v-card-text>
        <VMModule />
    </v-card>
</template>

<script setup>
import { ref, onMounted } from "vue";
import VMModule from "../Modal/VMModule.vue";
import { useModuleStore } from "../../pinia/module.js";

const moduleStore = useModuleStore();
const headers = [
    {
        title: "Nombre del módulo",
        key: "name",
        align: "center",
        class: "",
    },
    {
        title: "Fecha de registro",
        key: "date",
        align: "center",
        class: "",
    },
    {
        title: "Acciones",
        key: "actions",
        align: "center",
        class: "",
    },
];

const openModal = () => {
    moduleStore.showModal(true);
};

onMounted(() => {
    moduleStore.listModule();
});
</script>
