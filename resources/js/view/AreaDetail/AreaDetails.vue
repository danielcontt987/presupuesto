<template>
    <v-container fluid>
        <back-button @backAction="goToBack()" />
        <v-row>
            <v-col cols="12" md="5">
                <card-my-area-detail />
            </v-col>
            <v-col cols="12" md="7">
                <modules-card />
            </v-col>
            <v-col cols="12" md="7">
                <user-assign />
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { onMounted } from "vue";
import { useRouter } from "vue-router";
import { useAreaStore } from "@/pinia/area.js";
import CardMyAreaDetail from "@/components/AreaDetails/CardMyAreaDetail.vue";
import ModulesCard from "@/components/AreaDetails/ModulesCard.vue";
import BackButton from "@/components/global/BackButton.vue";
import UserAssign from "@/components/AreaDetails/UserAssign.vue";
const areaStore = useAreaStore();
const router = useRouter();

onMounted(() => {
    if (areaStore.area_id == 0) {
        router.push("/areas");
    }
});

const goToBack = () => {
    router.push("/areas");
}
</script>
