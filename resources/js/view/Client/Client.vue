<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" md="10">
                <vc-back-button @backAction="navigateToHome"></vc-back-button>
            </v-col>
            <v-col cols="12">
                <FilterClients />
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { useRouter } from 'vue-router';
import FilterClients from '../../components/Client/FilterClients.vue';
import VcBackButton from '../../components/global/BackButton.vue'
//Instance's composable from vue
const router = useRouter();

//Methods

const navigateToHome = () => {
    router.push("/inicio");
};
</script>