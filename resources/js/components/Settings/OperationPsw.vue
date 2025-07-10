<template>
    <CardBaseModal outlined v-if="settingStore.business">
        <template v-slot:text>
            <v-card-text class="mt-3 py-2 px-5">
                <v-row class="mx-0">
                    <v-col cols="12" style="padding-left: 0">
                        <v-chip color="background" class="text-primary rounded-lg pa-6 font-weight-bold" label>
                            Contraseña de operación
                        </v-chip>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <h4 class="font-weight-bold mb-0">Contraseña de operación actual</h4>
                    </v-col>
                    <v-col cols="12" v-if="settingStore.business.pin">
                        <h3 class="font-weight-bold mb-0 text-primary">
                            {{ settingStore.business.pin }}
                        </h3>
                    </v-col>
                    <v-col cols="12" class="text-left">
                         <h4 class="font-weight-light mb-0">La contraseña de operación es la contraseña que se utiliza para acceder a la aplicación y se puede requerir para funcionalidades dentro del sistema.</h4>
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
                                Actualizar contraseña de operación
                            </v-chip>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field variant="outlined" label="Nombre" v-model="name"></v-text-field>
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
import { useDisplay } from "vuetify";
import CardBaseModal from "../global/CardBaseModal.vue";
import { useAlertNormalStore } from "../../pinia/alert";
import { useSettingStore } from "../../pinia/setting";
import { ref } from "vue";

const openModal = ref(false);
const name = ref("");
const isLoading = ref(false);

const { smAndUp } = useDisplay();
const settingStore = useSettingStore();
const alertNormal = useAlertNormalStore();

const updateInfo = () => {
    openModal.value = true;
    name.value = settingStore.business.name;
};

const update = () => {
    let params = {
        "name": name.value,
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
