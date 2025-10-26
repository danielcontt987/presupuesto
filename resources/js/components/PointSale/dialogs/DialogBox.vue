<template>
    <v-dialog v-model="saleboxStore.openDialogBox" :width="dialogWidthBox()">
        <v-card class="overflow-hidden">
            <v-card-title class="bg-primary">
                <v-row class="mx-3 mt-0 mb-0">
                    <v-col cols="12">
                        <h4 class="text-center p-0">
                            Crear caja
                        </h4>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12">
                        <v-text-field v-model="salebox" variant="outlined" label="Nombre de la caja" />
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions class="justify-center">
                <v-row class="mx-0">
                    <v-col cols="12" lg="6">
                        <v-btn block depressed class="rounded-lg text-fail" @click="closeDialogBox()">
                            Cerrar
                        </v-btn>
                    </v-col>
                    <v-col cols="12" lg="6">
                        <v-btn block depressed class="bg-primary rounded-lg white--text" @click="createSalebox()">
                            Agregar
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref } from 'vue';
import { useSaleboxStore } from '@/pinia/salebox';
import { useAlertNormalStore } from '@/pinia/alert';

const saleboxStore = useSaleboxStore();
const alertStore = useAlertNormalStore();

const salebox = ref('');

const dialogWidthBox = () => {
    return '500px';
}

const closeDialogBox = () => {
    cashCutStore.dialogBox(false);
}

const createSalebox = () => {
    let params = {
        name: salebox.value,
    }

    if (salebox.value === '') {
        alertStore.show = true;
        alertStore.color = "warning";
        alertStore.msg = "Ingrese el nombre de la caja";
        alertStore.type = 1;
        return;
    }
    saleboxStore.storeBox(params).then((response) => {
        saleboxStore.dialogBox(false);
        saleboxStore.listSaleboxes();
        alertStore.show = true;
        alertStore.color = "success";
        alertStore.msg = "Se han creado una nueva caja";
        alertStore.type = 0;
    }).catch((error) => {
        alertStore.show = true;
        alertStore.color = "success";
        alertStore.msg = "Ha ocurrido un error, por favor intente de nuevo";
        alertStore.type = 1;
    })
}

</script>
