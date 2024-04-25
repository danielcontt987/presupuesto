<template>
    <v-container fluid>
        <v-dialog persistent max-width="550" v-model="alertNormal.show">
            <v-card class="rounded-lg ma-0" rounded="7">
                <v-card-title class="text-center">
                    <v-row>
                        <v-col cols="12" class="text-center mb-2">
                            <v-avatar variant="tonal" :color="alertNormal.color" size="100">
                                <v-icon size="84" :color="alertNormal.color">{{
                                    alertNormal.icon
                                }}</v-icon>
                            </v-avatar>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-title
                    class="text-center text-black"
                    style="font-weight: bold; word-break: break-word"
                    v-if="alertNormal.title"
                >
                    <v-row class="mx-0">
                        <v-col cols="12" class="text-center">
                            {{ alertNormal.title }}
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text
                    class="text-center"
                    style="font-size: 18px; word-break: break-word"
                >
                    <span v-html="alertNormal.msg"></span>
                </v-card-text>
                <v-card-actions class="mb-3" v-if="alertNormal.type == 0">
                    <v-row class="mx-0">
                        <v-col class="text-center">
                            <v-btn
                                size="large"
                                flat
                                block
                                class="bg-primary"
                                @click="closeModal()"
                            >
                                Entendido
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script setup>
import { useAlertNormalStore } from "../../../pinia/alert.js";
const alertNormal = useAlertNormalStore();

const closeModal = () => {
    alertNormal.$reset();
};
</script>
