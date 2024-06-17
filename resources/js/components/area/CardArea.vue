<template>
    <v-card class="rounded-lg" flat>
        <v-card-title>
            <v-row>
                <v-col cols="12" md="9">
                    <v-chip
                        color="background"
                        class="text-primary rounded-lg pa-5 font-weight-bold text-uppercase"
                        label
                    >
                        Áreas de la empresa registrada
                    </v-chip>
                </v-col>
            </v-row>
            <v-tabs
                v-model="selectedtab"
                class="mt-5"
                centered
                background-color="background"
                grow
            >
                <v-tab value="one" class="rounded-lg mr-3 bg-background text-weight-bold text-primary"><b>Áreas</b></v-tab>
                <v-tab value="two" class="rounded-lg bg-background text-primary"><b>Usuarios</b></v-tab>
            </v-tabs>
        </v-card-title>

        <v-card-text>
            <v-window v-model="selectedtab">
                <window-tab-area value="one" />
                <v-window-item value="two"> Tab Two content </v-window-item>
            </v-window>
        </v-card-text>
    </v-card>
</template>

<script setup>
import { ref } from "vue";
import { useAreaStore } from "../../pinia/area.js";
import WindowTabArea from "./tabs/WindowTabArea.vue";

const areaStore = useAreaStore();
const search = ref(null);
const selectedtab = ref(null);
</script>
