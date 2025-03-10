<template>
    <v-dialog v-model="productStore.openModal" width="450" persistent>
        <v-card class="my-0 pb-2 rounded-lg">
            <v-card-title>
                <v-row class="mx-0">
                    <v-col cols="12" style="padding-left: 11px">
                        <v-chip color="background" class="text-primary rounded-lg pa-5 font-weight-bold" style="width: 100%;" label>
                            Agregar categoría
                        </v-chip>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12">
                        <v-text-field label="Categoría" v-model="category" variant="outlined" color="primary" />
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions class="mx-3">
                <v-row>
                    <v-col cols="12" md="6">
                        <v-btn size="large" class="rounded-lg" large text depressed block color="error" @click="closeModal()">
                            Cerrar
                        </v-btn>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-btn large size="large" block class="rounded-lg bg-primary" depressed @click="createCategory()">
                            Guardar
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <Alert />
</template>
<script setup>
import { ref } from 'vue';
import { useProductStore } from '../../../pinia/product';
import { useAlertNormalStore } from '../../../pinia/alert';

const alertStore = useAlertNormalStore();
const productStore = useProductStore();

const category = ref("");

const closeModal = () => {
    productStore.closeopenDialog(false);
    category.value = "";
}

const createCategory = () => {
    let params = {
        name: category.value
    }
    productStore.storeCategory(params).then((response) => {
        productStore.listCategory();
        alertStore.show = true;
        (alertStore.color = "success"),
        (alertStore.msg = "Se han creado una nueva categoría"),
        (alertStore.type = 0),
        closeModal();
    }).catch((error) => {
        console.log(error);
        
    })
}

</script>