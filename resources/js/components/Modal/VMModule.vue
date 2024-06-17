<template>
    <v-dialog v-model="moduleStore.show" width="500" persistent>
        <v-card
            class="my-0 pb-2 rounded-lg"
            style="overflow: hidden: !important;"
        >
            <v-card-title>
                <v-row class="mx-0">
                    <v-col cols="12" style="padding-left: 0">
                        <v-chip
                            color="background"
                            class="text-primary rounded-lg pa-5 font-weight-bold"
                            label
                        >
                            Agregar módulo
                        </v-chip>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-card-text>
                <v-form ref="form">
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                label="Nombre del módulo"
                                variant="outlined"
                                color="primary"
                            />
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-row>
                    <v-col cols="12" md="6">
                        <v-btn
                            large
                            block
                            class="rounded-lg"
                            depressed
                            color="error"
                            @click="closeModal"
                        >
                            Cerrar
                        </v-btn>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-btn
                            large
                            block
                            class="rounded-lg bg-primary"
                            depressed
                        >
                            Guardar datos
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref } from "vue";

import { useModuleStore } from "../../pinia/module.js";

const moduleStore = useModuleStore();

const closeModal = () => {
    moduleStore.closeModal(false);
};
</script>
