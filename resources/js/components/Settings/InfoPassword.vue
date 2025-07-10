<template>
    <CardBaseModal outlined v-if="settingStore.business">
        <template v-slot:text>
            <v-card-text class="mt-3 py-2 px-5">
                <v-row class="mx-0">
                    <v-col cols="12" style="padding-left: 0">
                        <v-chip color="background" class="text-primary rounded-lg pa-6 font-weight-bold" label>
                            Internet
                        </v-chip>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" class="d-flex justify-center">
                        <v-icon disabled size="120" style="color: #192a672b !important">mdi-wifi</v-icon>
                    </v-col>
                    <v-col cols="12" v-if="settingStore.business.internet">
                        <h3 class="text-primary">{{ settingStore.business.internet }}</h3>
                    </v-col>
                    <v-col cols="12" class="d-flex text-justify">
                        <p>
                            La contraseña de Wi-Fi aparece impreso en el ticket de venta y
                            le permite a tus clientes utilizar la red Wi-Fi del establecimiento
                        </p>
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
</template>

<script setup>
import { useSettingStore } from "../../pinia/setting";
import CardBaseModal from '../global/CardBaseModal.vue';
const settingStore = useSettingStore();

</script>