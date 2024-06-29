<template>
    <v-card flat class="rounded-lg">
        <v-card-title>
            <v-row class="mx-0">
                <v-col cols="12" md="9" style="padding-left: 0">
                    <v-chip
                        color="background"
                        class="text-primary rounded-lg pa-5 font-weight-bold text-uppercase"
                        label
                    >
                        Detalles del area
                    </v-chip>
                </v-col>
                <v-col cols="12" md="3" class="text-right">
                    <v-btn
                        color="background"
                        class="rounded-lg text-primary text-uppercase"
                        flat
                        @click="editForm"
                    >
                        <b>{{ edit ? "Cancelar" : "Editar" }}</b>
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-title>
        <v-card-text class="pt-5">
            <v-row>
                <v-col class="pb-0" cols="12" xl="6">
                    <v-card class="my-0 bg-secondary rounded-lg" flat>
                        <v-card-text class="py-0">
                            <v-row
                                class="d-flex align-center justify-space-between"
                            >
                                <v-col
                                    class="d-flex align-center"
                                    :class="edit ? '' : 'mb-3 mt-3'"
                                >
                                    <h5 class="my-0">Área</h5>
                                </v-col>
                                <v-col class="d-flex justify-end" v-if="edit">
                                    <v-switch
                                        color="white"
                                        class="mb-0"
                                        inset
                                        :false-value="0"
                                        :true-value="1"
                                        hide-details
                                    ></v-switch>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-card-text>
        <v-card-actions v-if="edit">
            <v-row>
                <v-col cols="12" md="6" order="2" order-md="1">
                    <v-btn
                        class="rounded-lg"
                        large
                        text
                        depressed
                        block
                        color="error"
                    >
                        Cancelar
                    </v-btn>
                </v-col>
                <v-col cols="12" md="6" order="1" order-md="2">
                    <v-btn class="rounded-lg bg-primary" large depressed block>
                        Guadar cambios
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-actions>
    </v-card>
</template>
<script setup>
import { ref } from "vue";

const edit = ref(false);

const editForm = () => {
    edit.value = !edit.value;
};
</script>
