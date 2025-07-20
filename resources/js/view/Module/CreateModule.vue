<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" md="10">
                <vc-back-button @backAction="goTo"></vc-back-button>
            </v-col>
            <v-col cols="12">
                <CardModule />
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import VcBackButton from "../../components/global/BackButton.vue";
import CardModule from "../../components/Module/CardModule.vue";
import { useRouter } from "vue-router";
const router = useRouter();
const goTo = () => {
    router.push("/inicio");
};
</script>
