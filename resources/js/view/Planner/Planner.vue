<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" md="10">
                <vc-back-button @backAction="navigateToHome"></vc-back-button>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <card-base-modal outlined>
                    <template v-slot:text>
                        <v-card-text class="mt-3 py-2 mb-3">
                            <v-row class="mx-0">
                                <v-col cols="12" md="9" style="padding-left: 0">
                                    <v-chip color="background" class="text-primary rounded-lg pa-5 font-weight-bold"
                                        label>
                                        Proyectos
                                    </v-chip>
                                </v-col>
                                <v-col cols="12" md="3" class="text-right">
                                    <v-btn class="elevation-0 rounded-lg font-weight-bold mx-0" color="primary"
                                        variant="outlined">
                                        Agregar proyecto
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </template>
                </card-base-modal>
            </v-col>
            <v-col cols="12" v-for="project in pagedProjects" :key="project.id">
                <card-base-modal outlined>
                    <template v-slot:text>
                        <v-card-text class="mt-3 py-2 mb-3">
                            <v-row class="mx-0">
                                <v-col cols="12" md="9" style="padding-left: 0">
                                    <v-chip color="background" class="text-primary rounded-lg pa-5 font-weight-bold"
                                        label>
                                        {{ "MANAGER" }}
                                    </v-chip>
                                </v-col>
                                <v-col cols="12" md="3" class="text-right">
                                    <v-btn class="elevation-0 rounded-lg font-weight-bold mx-0" icon>
                                        <v-icon>mdi-dots-vertical</v-icon>
                                        <v-menu activator="parent">
                                            <v-list>
                                                <v-list-item @click="goToDetails(project.id)">
                                                    <v-list-item-title>Ver proyecto</v-list-item-title>
                                                </v-list-item>
                                            </v-list>
                                        </v-menu>
                                    </v-btn>
                                </v-col>
                                <v-col cols="12">
                                    <h1>{{ project.name }}</h1>
                                    <p class="text-grey_dark">Cliente: {{ project.name_client }}</p>
                                    <p class="tex-grey_dark">{{ project.description }}</p>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </template>
                </card-base-modal>

            </v-col>
            <v-col cols="12">
                <div class="text-center pt-2">
                    <v-pagination v-model="page" :length="pageCount" :total-visible="5" size="small" color="primary" />
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>




<script setup>

import { onMounted, ref, computed } from "vue";
import CardBaseModal from "@/components/global/CardBaseModal.vue";
import VcBackButton from "@/components/global/BackButton.vue";
import { useRouter } from "vue-router";
import { usePlannerStore } from "@/pinia/planner";
const plannerStore = usePlannerStore();
const router = useRouter();

const page = ref(1);
const itemsPerPage = ref(5);


const pagedProjects = computed(() => {
    const startIndex = (page.value - 1) * itemsPerPage.value;
    const endIndex = startIndex + itemsPerPage.value;
    return plannerStore.projects.slice(startIndex, endIndex);
});

const pageCount = computed(() => Math.ceil(plannerStore.projects.length / itemsPerPage.value));

onMounted(() => {
    plannerStore.listProject();
});


//Variables

//Methods
const navigateToHome = () => {
    router.push({ name: 'home' });
};

const goToDetails = (id) => {
    plannerStore.getProject(id).then(() => {
        plannerStore.setProjectId(id);
        router.push({ name: 'Detalle del proyecto' });
    });
};


</script>