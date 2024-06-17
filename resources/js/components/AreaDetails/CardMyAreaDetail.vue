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
                <v-col cols="12" md="3" style="padding-left: 0">
                    <v-btn
                        color="background"
                        class="rounded-lg text-primary text-uppercase"
                        flat
                        @click="editForm"
                    >
                        {{ edit ? "Cancelar" : "Editar" }}
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-title>
        <v-card-text v-if="edit">
            <v-col cols="12">
                <v-text-field
                    v-model="name"
                    label="Nombre del área"
                    variant="outlined"
                />
                <v-text-field
                    v-model="folio"
                    label="Folio"
                    variant="outlined"
                />
            </v-col>
        </v-card-text>
        <v-card-text v-else="edit">
            <v-col cols="12">
                <h4 class="font-weight-light mb-0">Nombre del area</h4>
                <h3 class="font-weight-bold mb-0">
                    {{ "Construcciones" }}
                </h3>
            </v-col>
            <v-col cols="12">
                <h4 class="font-weight-light mb-0">
                    Cantidad de usuarios en el área
                </h4>
                <h3 class="font-weight-bold mb-0">
                    {{ "1 usuario" }}
                </h3>
            </v-col>
            <v-col cols="12">
                <h4 class="font-weight-light mb-0">Folio del área</h4>
                <h3 class="font-weight-bold mb-0">
                    {{ "HY090" }}
                </h3>
            </v-col>
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
                        Eliminar área
                    </v-btn>
                </v-col>
                <v-col cols="12" md="6" order="1" order-md="2">
                    <v-btn
                        class="rounded-lg bg-primary"
                        large
                        depressed
                        block
                    >
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
