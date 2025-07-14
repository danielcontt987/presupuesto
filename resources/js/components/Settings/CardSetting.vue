<template>
    <CardBaseModal outlined v-if="settingStore.business">
        <template v-slot:text>
            <v-card-text class="mt-3 py-2 px-5">
                <v-row class="mx-0">
                    <v-col cols="12" style="padding-left: 0">
                        <v-chip color="background" class="text-primary rounded-lg pa-6 font-weight-bold" label>
                            Configuraciones para inpresora
                        </v-chip>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-row class="mb-0 mt-1" no-gutters>
                            <v-col cols="12">
                                <h4 class="font-weight-light mb-0">
                                    Tipo de documento
                                </h4>
                                <h3 class="font-weight-bold mb-0" v-if="settingStore.business.type_doc == 'document'">
                                    Hoja
                                </h3>
                                <h3 class="font-weight-bold mb-0" v-else-if="settingStore.business.type_doc == 'note'">
                                    Nota de venta
                                </h3>
                                <h3 class="font-weight-bold mb-0" v-else>
                                    Ticket
                                </h3>
                            </v-col>
                            <v-col cols="12" class="d-flex justify-space-between">
                                <div v-if="settingStore.business.iva === true">
                                    <h4 class="font-weight-light mt-4">
                                        Con IVA
                                    </h4>
                                </div>
                                <div v-else>
                                    <h4 class="font-weight-light mt-4">
                                        Sin IVA
                                    </h4>
                                </div>
                                <div>
                                    <v-switch :disabled="!settingStore.business.iva" v-model="settingStore.business.iva"
                                        color="primary" hide-details inset></v-switch>
                                </div>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
        </template>
        <template v-slot:actions>
            <v-card-actions>
                <v-row>
                    <v-col cols="12">
                        <v-btn large block class="rounded-lg" variant="outlined" depressed color="primary"
                            @click="updateInfo()">
                            Actualizar datos
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </template>
    </CardBaseModal>
    <v-dialog v-model="openModal" width="500" persistent class="rounded-lg">
        <card-base-modal outlined :loading="isLoading">
            <template v-slot:text>
                <v-card-text class="mt-3 py-2">
                    <v-row class="mx-0">
                        <v-col cols="12" style="padding-left: 0">
                            <v-chip color="background" class="text-primary rounded-lg pa-6 font-weight-bold" label>
                                Actualizar configuración de la empresa
                            </v-chip>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-select variant="outlined" label="Tipo de documento" :items="type_docs" item-title="text"
                                item-value="value" v-model="editSetting.type_doc" />
                        </v-col>
                        <v-col cols="12" class="d-flex justify-space-between">
                            <div v-if="editSetting.iva === true">
                                <h4 class="font-weight-light mt-4">
                                    Con IVA
                                </h4>
                            </div>
                            <div v-else>
                                <h4 class="font-weight-light mt-4">
                                    Sin IVA
                                </h4>
                            </div>
                            <div>
                                <v-switch v-model="editSetting.iva" color="primary" hide-details inset></v-switch>
                            </div>
                        </v-col>
                    </v-row>
                </v-card-text>
            </template>
            <template v-slot:actions>
                <v-card-actions class="mt-3 py-2">
                    <v-row>
                        <v-col cols="12" md="6" order="2" order-md="1">
                            <v-btn class="rounded-lg" text depressed flat size="large" block color="error"
                                @click="openModal = false">
                                Cerrar
                            </v-btn>
                        </v-col>
                        <v-col cols="12" md="6" order="1" order-md="2">
                            <v-btn class="bg-primary rounded-lg" flat size="large" block @click="update()">
                                Actualizar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-actions>
            </template>
        </card-base-modal>
    </v-dialog>
    <Alert />

</template>

<script setup>
import CardBaseModal from "../global/CardBaseModal.vue";
import { useAlertNormalStore } from "../../pinia/alert";
import { useSettingStore } from "../../pinia/setting";
import { onMounted, ref } from "vue";

const openModal = ref(false);
const name = ref("");
const cellphone1 = ref("");
const cellphone2 = ref("");
const whatsapp = ref("");
const email_company = ref("");
const isLoading = ref(false);
const editSetting = ref(null)
const type_docs = [
    {
        text: "Nota de venta",
        value: "note"
    },
    {
        text: "Hoja",
        value: "document"
    },
    {
        text: "Ticket",
        value: "ticket"
    },
]

const settingStore = useSettingStore();
const alertNormal = useAlertNormalStore();

onMounted(() => {
    editSetting.value = JSON.parse(JSON.stringify(settingStore.business))
})

const updateInfo = () => {
    openModal.value = true;
    name.value = settingStore.business.name;
    cellphone1.value = settingStore.business.telephone1;
    cellphone2.value = settingStore.business.telephone2;
    whatsapp.value = settingStore.business.whatsapp;
    email_company.value = settingStore.business.email_company;
};

const update = () => {
    let params = {
        "name": name.value,
        "cellphone1": cellphone1.value,
        "cellphone2": cellphone2.value,
        "whatsapp": whatsapp.value,
        "email_company": email_company.value,
    }

    settingStore.updatePart1(params).then((response) => {

        openModal.value = false;
        alertNormal.show = true;
        (alertNormal.color = "success"),
            (alertNormal.msg =
                "Se actualizó correctamente la información"),
            (alertNormal.type = 0),
            (alertNormal.icon = "mdi-check-circle-outline");
    });
};

</script>
