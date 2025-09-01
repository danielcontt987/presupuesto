<template>
    <div>
        <v-dialog v-model="openDialogSaleBox" :width="dialogWidth()" class="mt-0" persistent>
            <v-card class="rounded-lg">
                <v-card-title class="bg-secondary_dark">
                    <v-row class="mx-3 mt-0 mb-0">
                        <v-col cols="12">
                            <h4 class="text-center p-0">
                                Abrir caja
                            </h4>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <v-form ref="formCreate">
                        <v-row no-gutters>
                            <v-col cols="12">
                                <v-alert color="primary" icon="mdi-alert" variant="outlined" class="text-center mt-3">
                                    No hay un corte de caja abierto.
                                    <strong>Es necesario abrir uno nuevo</strong>.<br />
                                    1. Selecciona una caja (Si no tienes una da clic en
                                    CREAR CAJA)
                                    <br />
                                    2. Ingresa el monto con el que abre la caja <br />
                                    3. Da clic en ACEPTAR y listo, podrás empezar a vender.
                                </v-alert>
                            </v-col>
                            <v-col cols="12" lg="6" class="pt-5">
                                <v-select v-model="salebox_id" variant="outlined" label="Seleccionar caja"
                                    :items="saleboxes" item-value="id" item-title="name" :rules="boxRules" />
                            </v-col>
                            <v-col cols="12" lg="6" class="text-center pt-4 pb-4">
                                <v-btn class="rounded-lg" flat color="primary" @click="openSalebox">
                                    <v-icon>mdi-plus</v-icon>
                                    Crear caja
                                </v-btn>
                            </v-col>
                            <v-col cols="12" lg="6">
                                <v-text-field variant="outlined" label="Importe" v-model="amount"
                                    :rules="accountRules" />
                            </v-col>
                            <v-col cols="12">
                                <v-textarea filled rows="2" v-model="comment" variant="outlined" label="Comentarios" />
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-card-actions class="justify-center">
                    <v-row class="mx-0">
                        <v-col cols="12" lg="6">
                            <v-btn block depressed class="rounded-lg text-fail" @click="closeDialogCashCut()">
                                Cerrar
                            </v-btn>
                        </v-col>
                        <v-col cols="12" lg="6">
                            <v-btn block depressed class="bg-primary rounded-lg white--text" @click="storeCashCut()">
                                Aceptar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="openCreateBox" :width="dialogWidthBox()">
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
                            <v-btn block depressed class="bg-primary rounded-lg white--text" @click="storeCashCut()">
                                Agregar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- <v-notification-dialog>
            <v-row class="mx-0">
                <v-col class="text-center">
                    <v-btn class="rounded-lg" large depressed block color="primary text-white" @click="closeDialog()">
                        Entendido
                    </v-btn>
                </v-col>
            </v-row>
        </v-notification-dialog> -->
        <!-- <alert-progress>
            <div class="sk-chase">
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
            </div>
        </alert-progress> -->
        <Alert />
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useCashCutStore } from '@/pinia/cashcut';
import { useAlertNormalStore } from '@/pinia/alert';

const cashCutStore = useCashCutStore();
const alertStore = useAlertNormalStore();


defineProps({
    saleboxes: Array,
});

onMounted(() => {
    openDialogSaleBox.value = true;
});

const openDialogSaleBox = ref(false);
const openCreateBox = ref(false);
const salebox = ref('');
const salebox_id = ref(null);
const amount = ref(null);
const comment = ref(null);

const dialogWidth = () => {
    return window.innerWidth < 600 ? '90%' : '50%';
}

const dialogWidthBox = () => {
    return window.innerWidth < 600 ? '90%' : '40%';
}

const boxRules = [
    v => !!v || 'Este campo es requerido',
]

const accountRules = [
    v => !!v || 'Este campo es requerido',
    v => /^[0-9]+(\.[0-9]{1,2})?$/.test(v) || 'El importe debe ser un número válido',
]

const closeDialogBox = () => {
    openCreateBox.value = false;
}

const openSalebox = () => {
    openCreateBox.value = true;
}

const closeDialogCashCut = () => {
    openDialogSaleBox.value = false;
}

const storeCashCut = () => {
    let params = {
        salebox_id: salebox_id.value,
        amount: amount.value,
        comment: comment.value,
    }

    cashCutStore.storeCashcuts(params).then((res) => {
        alertStore.show = true;
        alertStore.color = "success";
        alertStore.msg = "Se han creado una nuevo corte de caja";
        alertStore.type = 0;

        cashCutStore.listCashcuts().then((res) => {
            if (res.data.cashcuts.length === 0) {
                openDialogSaleBox.value = true;
            } else {
                openDialogSaleBox.value = false;
            }
        });
    }).catch((error) => {
        alertStore.show = true;
        alertStore.color = "fail";
        alertStore.msg = "No se ha podido crear el corte de caja";
        alertStore.type = 1;

        cashCutStore.listCashcuts().then((res) => {
            if (res.data.cashcuts.length === 0) {
                openDialogSaleBox.value = true;
            } else {
                openDialogSaleBox.value = false;
            }
        });
    })
}




</script>