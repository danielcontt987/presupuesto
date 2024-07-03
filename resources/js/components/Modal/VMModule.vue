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
                                v-model="name"
                                variant="outlined"
                                color="primary"
                            />
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
            <v-card-actions class="mx-3">
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
                            @click="store()"
                        >
                            Guardar datos
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <Alert />
</template>

<script setup>
import { ref } from "vue";

import { useModuleStore } from "../../pinia/module.js";
import { useAlertNormalStore } from "../../pinia/alert.js";


const moduleStore = useModuleStore();
const alertNormal = useAlertNormalStore();
const name = ref(null);

const store = () =>{
    let params = {
        name: name.value
    }
    moduleStore.storeModule(params).then(() =>{
        closeModal()
        alertNormal.show = true;
        (alertNormal.color = "success"),
        (alertNormal.msg = "Se ha creado un nuevo modulo correctamente"),
        (alertNormal.type = 0),
        (alertNormal.icon = "mdi-check-circle-outline");
        moduleStore.listModule();
    }).catch((error) => {
        alertNormal.show = true;
        (alertNormal.color = "error"),
        (alertNormal.msg = "Ha ocurrido un error, intentelo más tarde"),
        (alertNormal.type = 0),
        (alertNormal.icon = "mdi-close-circle-outline");
    })
};

const closeModal = () => {
    moduleStore.closeModal(false);
    name.value = null;
};
</script>
