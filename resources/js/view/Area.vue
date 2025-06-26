<template>
    <v-container>
        <v-row v-if="areaStore.isLoading">
            <v-col cols="12">
                <v-card
                    elevation="0"
                    style="margin-bottom: 0px !important"
                    class="rounded-lg"
                    ><v-skeleton-loader type="article"></v-skeleton-loader
                    ><v-skeleton-loader type="article"></v-skeleton-loader
                ></v-card>
            </v-col>
        </v-row>
        <v-row v-else>
            <v-col class="12">
                <CardArea />
            </v-col>
            <v-col class="12">
                <CardArea />
            </v-col>
            <v-col class="12">
                <CardArea />
            </v-col>
            <v-col class="12">
                <CardArea />
            </v-col>
            <v-col class="12">
                <CardArea />
            </v-col>
            <v-col class="12">
                <CardArea />
            </v-col>
            <v-col class="12">
                <CardArea />
            </v-col>
            <v-col class="12">
                <CardArea />
            </v-col>
            <v-col class="12">
                <CardArea />
            </v-col>
            <v-col class="12">
                <CardArea />
            </v-col>
            
        </v-row>
    </v-container>
</template>

<script setup>
import VcBackButton from "../components/global/BackButton.vue";
import CardArea from "../components/Areas/CardArea.vue";
import { onMounted } from "vue";
import { useAreaStore } from "../pinia/area.js";
import { useRouter } from "vue-router";
const areaStore = useAreaStore();


const router = useRouter();

const navigateToHome = () => {
    router.push("/inicio");
};

onMounted(() => {
    areaStore.getArea();
});
</script>
