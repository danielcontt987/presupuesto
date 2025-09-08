<template>
    <v-container grid-list-xl fluid class="grey lighten-4 px-4">
        <v-row class="mt-3">
            <v-col cols="12" md="10">
                <vc-back-button @backAction="navigateToHome"></vc-back-button>
            </v-col>
            <v-col cols="12" md="2" sm="12" class="text-end">
                <slot></slot>
            </v-col>
        </v-row>

        <v-row v-if="settingStore.isLoading">
            <v-col cols="12" md="5">
                <v-card elevation="0" style="margin-bottom: 0px !important" class="rounded-lg">
                    <v-skeleton-loader type="article" />
                    <v-skeleton-loader type="article" />
                    <v-skeleton-loader type="article" />
                </v-card>
            </v-col>
        </v-row>

        <v-row v-else>
            <v-col cols="12" md="4">
                <v-row no-gutters>
                    <v-col cols="12">
                        <card-info />
                    </v-col>
                    <v-col cols="12" class="mx-0">
                        <operation-psw />
                    </v-col>
                    <v-col cols="12" class="mx-0">
                        <info-password />
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" md="4">
                <v-row no-gutters>
                    <v-col cols="12">
                        <card-fiscal />
                    </v-col>
                    <v-col cols="12" class="mx-0">
                        <card-ubication />
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" md="4">
                <v-row no-gutters>
                    <v-col cols="12">
                        <card-more-info />
                    </v-col>
                    <v-col cols="12">
                        <card-setting />
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useSettingStore } from "@/pinia/setting.js";
import { useRouter } from 'vue-router';

import VcBackButton from '@/components/global/BackButton.vue';
import CardInfo from '@/components/Settings/CardInfo.vue';
import OperationPsw from '@/components/Settings/OperationPsw.vue';
import CardFiscal from "@/components/Settings/CardFiscal.vue";
import CardUbication from "@/components/Settings/CardUbication.vue";
import InfoPassword from "@/components/Settings/InfoPassword.vue";
import CardMoreInfo from "@/components/Settings/CardMoreInfo.vue";
import CardSetting from "@/components/Settings/CardSetting.vue";


const settingStore = useSettingStore();

const router = useRouter();


onMounted(() => {
    settingStore.getSetting();
});

const openModal = ref(false);
const name = ref("");
const cellphone1 = ref("");
const cellphone2 = ref("");
const whatsapp = ref("");
const email = ref("");

const updateInfo = () => {
    openModal.value = true;
};

const navigateToHome = () => {
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
