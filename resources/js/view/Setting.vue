<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" md="10">
                <vc-back-button @backAction="navigateToHome"></vc-back-button>
            </v-col>
            <v-col cols="12" md="2" sm="12" class="text-end">
                <slot></slot>
            </v-col>
        </v-row>
        <v-row v-if="settingStore.isLoading">
            <v-col cols="12" md="5">
                <v-card
                    elevation="0"
                    style="margin-bottom: 0px !important"
                    class="rounded-lg"
                    ><v-skeleton-loader type="article"></v-skeleton-loader
                    ><v-skeleton-loader type="article"></v-skeleton-loader
                    ><v-skeleton-loader type="article"></v-skeleton-loader
                ></v-card>
            </v-col>
        </v-row>
        <v-row v-else>
            <v-col cols="12" md="5">
                <v-card
                    elevation="0"
                    style="margin-bottom: 0px !important"
                    class="rounded-lg"
                >
                    <v-card-text v-if="settingStore.business">
                        <v-row class="mx-0">
                            <v-col cols="12" style="padding-left: 0">
                                <v-chip
                                    color="background"
                                    class="text-primary rounded-lg pa-6 font-weight-bold"
                                    label
                                >
                                    Información contacto
                                </v-chip>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <h1 class="font-weight-bold">{{ settingStore.business.name }}</h1>
                            </v-col>
                            <v-col cols="12">
                                <h4 class="font-weight-light mb-0">Teléfono</h4>
                                <h3 class="font-weight-bold mb-0">
                                    {{ settingStore.business.telephone1 }}
                                </h3>
                            </v-col>
                            <v-col cols="12">
                                <h4 class="font-weight-light mb-0">
                                    Teléfono adicional
                                </h4>
                                <h3 class="font-weight-bold mb-0">
                                    {{ settingStore.business.telephone2 }}
                                </h3>
                            </v-col>
                            <v-col cols="12">
                                <h4 class="font-weight-light mb-0">Whatsapp</h4>
                                <h3 class="font-weight-bold mb-0">
                                    {{ settingStore.business.whatsapp }}
                                </h3>
                            </v-col>
                            <v-col cols="12">
                                <h4 class="font-weight-light mb-0">
                                    Correo electrónico
                                </h4>
                                <h3 class="font-weight-bold mb-0">
                                    {{ "jose_daniel16051999@outlook.com" }}
                                </h3>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <!-- <v-card-text v-else>
                        <v-row class="mx-0">
                            <v-col cols="12" style="padding-left: 0">
                                <v-chip
                                    color="background"
                                    class="text-primary rounded-lg pa-6 font-weight-bold"
                                    label
                                >
                                    No se pudo cargar la información de la
                                    empresa.
                                </v-chip>
                            </v-col>
                        </v-row>
                    </v-card-text> -->
                    <v-card-actions>
                        <v-row>
                            <v-col cols="12">
                                <v-btn
                                    large
                                    block
                                    class="rounded-lg"
                                    variant="outlined"
                                    depressed
                                    color="primary"
                                    @click="updateInfo()"
                                >
                                    Actualizar datos
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>

        <v-dialog v-model="openModal" width="500" persistent class="rounded-lg">
            <v-card
                class="my-0 pb-2 rounded-lg"
                style="overflow: hidden: !important;"
            >
                <v-card-title class="bg-primary">
                    <v-row>
                        <v-col cols="12" md="8" lg="10">
                            <h4 class="white--text">Añadir cliente</h4>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text class="mt-3 py-2">
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                variant="outlined"
                                label="Nombre"
                                v-model="name"
                            ></v-text-field>
                            <v-text-field
                                variant="outlined"
                                label="Teléfono"
                                v-model="cellphone1"
                            ></v-text-field>
                            <v-text-field
                                variant="outlined"
                                label="Teléfono adiccional"
                                v-model="cellphone2"
                            ></v-text-field>
                            <v-text-field
                                variant="outlined"
                                label="Whatsapp"
                                v-model="whatsapp"
                            ></v-text-field>
                            <v-text-field
                                variant="outlined"
                                label="Correo electrónico"
                                v-model="email"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-row>
                        <v-col cols="12" md="6" order="2" order-md="1">
                            <v-btn
                                class="rounded-lg"
                                large
                                text
                                depressed
                                block
                                color="error"
                                @click="openModal = false"
                            >
                                Cerrar
                            </v-btn>
                        </v-col>
                        <v-col cols="12" md="6" order="1" order-md="2">
                            <!-- <v-btn
                                class="rounded-lg"
                                large
                                depressed
                                block
                                @click="openModal = false"
                            >
                                Actualizar
                            </v-btn> -->
                            <v-btn
                                class="bg-primary rounded-lg"
                                flat
                                size="large"
                                block
                                @click="update()"
                            >
                                Actualizar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <Alert/>
    </v-container>
</template>

<script setup>
import VcBackButton from '../components/global/BackButton.vue';
import { onMounted, ref } from "vue";
import { useSettingStore } from "../pinia/setting.js";
import { useAlertNormalStore } from "../pinia/alert.js";
import { useRouter } from 'vue-router';
const settingStore = useSettingStore();
const alertNormal = useAlertNormalStore();
const router = useRouter();


onMounted(() => {
    settingStore.getSetting();
});

const openModal = ref(false);
const name = ref ("");
const cellphone1 = ref ("");
const cellphone2 = ref ("");
const whatsapp = ref ("");
const email = ref ("");

const updateInfo = () => {
    openModal.value = true;
};

const navigateToHome = () =>{
    router.push('/inicio');
}

const update = () => {
    let params = {
        "name": name.value,
        "cellphone1": cellphone1.value,
        "cellphone2": cellphone2.value,
        "whatsapp": whatsapp.value,
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
