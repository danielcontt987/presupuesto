<template>
    <div>
        <v-dialog v-model="cashCutStore.openDialogCashCut" :width="dialogWidth()" class="mt-0" persistent>
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
        <DialogBox />
        <Alert />
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from "vue-router";
import { useCashCutStore } from '@/pinia/cashcut';
import { useSaleboxStore } from '@/pinia/salebox';
import { useAlertNormalStore } from '@/pinia/alert';
import DialogBox from './DialogBox.vue';

const cashCutStore = useCashCutStore();
const alertStore = useAlertNormalStore();
const saleboxStore = useSaleboxStore();
const router = useRouter();


defineProps({
    saleboxes: Array,
});

onMounted(() => {
    cashCutStore.listCashcuts();
});

const salebox_id = ref(null);
const amount = ref(null);
const comment = ref(null);

const dialogWidth = () => {
    return window.innerWidth < 600 ? '90%' : '50%';
}

const boxRules = [
    v => !!v || 'Este campo es requerido',
]

const accountRules = [
    v => !!v || 'Este campo es requerido',
    v => /^[0-9]+(\.[0-9]{1,2})?$/.test(v) || 'El importe debe ser un número válido',
]


const openSalebox = () => {
    saleboxStore.dialogBox(true);
}

const closeDialogCashCut = () => {
    // openDialogSaleBox.value = false;
    router.push({ name: 'Inicio' });
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
        cashCutStore.dialogCashCut(false);
        cashCutStore.listCashcuts().then((res) => {
            if (res.data.cashcuts.length === 0) {
                cashCutStore.dialogCashCut(true);
            } else {
                cashCutStore.dialogCashCut(false);
            }
        });
    }).catch((error) => {
        alertStore.show = true;
        alertStore.color = "fail";
        alertStore.msg = "No se ha podido crear el corte de a";
        alertStore.type = 1;
    })
}




</script>