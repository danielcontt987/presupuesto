<template>
    <v-container fluid>
        <back-button @backAction="goToBack()"/>
        <v-row>
            <v-col cols="12" md="5"> 
                <card-my-area-detail />
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { onMounted } from "vue";
import { useRouter } from "vue-router";
import { useAreaStore } from "../../pinia/area.js";
import CardMyAreaDetail from "../../components/AreaDetails/CardMyAreaDetail.vue";
import BackButton from "../../components/global/BackButton.vue";
const areaStore = useAreaStore();
const router = useRouter();

onMounted(() => {
    if (areaStore.area_id == 0) {
        router.push("/areas");
    }
});

const goToBack = () =>{
    router.push("/areas");
}
</script>
