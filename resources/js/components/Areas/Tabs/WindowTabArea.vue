<template>
    <v-window-item class="my-3">
        <v-data-table :search="search" :items="pagedSales" :headers="headers">
            <template v-slot:top>
                <v-row class="mx-1">
                    <v-col cols="12">
                        <v-text-field v-model="search" variant="outlined" label="Buscar" single-line
                            hide-details></v-text-field>
                    </v-col>
                </v-row>
            </template>
            <template v-slot:item.countUser="{ item }">
                {{ item.users }}
            </template>
            <template v-slot:item.actions="{ item }">
                <v-btn icon="mdi-eye" class="rounded-lg" flat size="small" color="primary"
                    @click="goToDetail(item.id)"></v-btn>
            </template>
        </v-data-table>
        <div class="text-center pt-2">
            <v-pagination elevation="3" v-model="page" :length="pageCount" size="small" color="primary" />
        </div>
    </v-window-item>
</template>

<script setup>
import { useAreaStore } from "@/pinia/area.js";
import { computed, ref } from "vue";
import { useRouter } from "vue-router";
const router = useRouter();
const areasStore = useAreaStore();
const headers = [
    { title: "Nombre", key: "name", align: "center", class: "name-header" },
    { title: "Folio", key: "folio", align: "center", class: "name-header" },
    {
        title: "Usuarios registrados en el área",
        key: "countUser",
        align: "center",
        class: "name-header",
    },
    {
        title: "Acciones",
        key: "actions",
        align: "center",
        class: "name-header",
    },
];

const itemsPerPage = ref(10);
const page = ref(1);
const search = ref(null);

const pagedSales = computed(() => {
    const startIndex = (page.value - 1) * itemsPerPage.value;
    const endIndex = startIndex + itemsPerPage.value;
    return areasStore.areas.slice(startIndex, endIndex);
});

const pageCount = computed(() => {
    return Math.ceil(areasStore.areas.length / itemsPerPage.value);
});

const goToDetail = (id) => {
    let params = {
        "area_id": id
    }
    areasStore.consulInfo(params);
    areasStore.setAreaId(id);
    router.push('/detalle-del-area');
};
</script>

<style>
.v-data-table-footer {
    display: none;
}
</style>
