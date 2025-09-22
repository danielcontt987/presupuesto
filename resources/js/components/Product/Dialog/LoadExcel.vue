<template>
    <v-dialog v-model="productStore.openModalExcel" max-width="600">
        <card-base-modal outlined>
            <template v-slot:text>
                <v-card-text class="mt-3 py-2">
                    <v-row class="mx-0">
                        <v-col cols="12" style="padding-left: 0">
                            <v-chip color="background" class="text-primary rounded-lg pa-6 font-weight-bold" label>
                                Cargar productos desde Excel
                            </v-chip>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-file-input v-model="file" variant="outlined" :prepend-icon="null"
                                label="Selecciona un archivo Excel" accept=".xlsx, .xls" outlined dense
                                color="primary" />
                        </v-col>
                    </v-row>
                </v-card-text>
            </template>
            <template v-slot:actions>
                <v-card-actions class="mt-3 py-2">
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-btn class="rounded-lg bg-primary" large depressed block :loading="isLoading"
                                @click="createProductsFromExcel()">
                                Cargar productos
                            </v-btn>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-btn class="rounded-lg bg-fail" large depressed block :loading="isLoading"
                                @click="closeModal()">
                                Cerrar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-actions>
            </template>
            <Alert />

        </card-base-modal>
    </v-dialog>
</template>

<script setup>
import { ref } from 'vue';
import { useProductStore } from '@/pinia/product';
import { useAlertNormalStore } from "@/pinia/alert.js";

const productStore = useProductStore();
const alertStore = useAlertNormalStore();
import CardBaseModal from '@/components/global/CardBaseModal.vue';

const isLoading = ref(false);
const file = ref(null);

const createProductsFromExcel = () => {
    if (!file.value) {
        return;
    }
    let formData = new FormData();
    formData.append('file', file.value);
    isLoading.value = true;
    productStore.importProductsFromExcel(formData)
        .then(() => {
            isLoading.value = false;
            file.value = null;
            productStore.closeDialogExcel(false);
            productStore.listProducts();
            alertStore.show = true;
            (alertStore.color = "success"),
                (alertStore.msg = "Productos importados correctamente"),
                (alertStore.type = 0);
        })
        .catch(() => {
            isLoading.value = false;
            alertStore.show = true;
            (alertStore.color = "error"),
                (alertStore.msg = "Error al importar los productos"),
                (alertStore.type = 1);
        }).finally(() => {
            isLoading.value = false;
        });
}



const closeModal = () => {
    productStore.closeDialogExcel(false);
}


</script>