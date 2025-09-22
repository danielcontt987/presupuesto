<template>
    <v-dialog v-model="plannerStore.isOpenModal" max-width="750">
        <card-base-modal outlined>
            <template v-slot:text>
                <v-card-text class="mt-3 py-2">
                    <v-row class="mx-0">
                        <v-col cols="12" style="padding-left: 0">
                            <v-chip color="background" class="text-primary rounded-lg pa-6 font-weight-bold" label>
                                Agregar Proyectos
                            </v-chip>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field v-model="name" label="Nombre de proyecto" variant="outlined" />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field v-model="description" label="Descripción" variant="outlined" />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field v-model="clientName" label="Cliente" variant="outlined" />
                        </v-col>
                    </v-row>
                </v-card-text>
            </template>
            <template v-slot:actions>
                <v-card-actions class="mt-3 py-2">
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-btn class="rounded-lg bg-primary" @click="addProject" large depressed block
                                :loading="isLoading">
                                Agregar
                            </v-btn>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-btn class="rounded-lg bg-fail" large depressed block :loading="isLoading"
                                @click="plannerStore.openModalExcel(false)">
                                Cerrar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-actions>
            </template>
        </card-base-modal>
    </v-dialog>
    <Alert />

</template>

<script setup>
import { ref } from 'vue'
import { usePlannerStore } from "@/pinia/planner";
import { useAlertNormalStore } from "@/pinia/alert";
import CardBaseModal from '@/components/global/CardBaseModal.vue';



const isLoading = ref(false);
const name = ref('');
const description = ref('');
const clientName = ref('');

const plannerStore = usePlannerStore();
const alertNormalStore = useAlertNormalStore();

const clearModal = () => {
    isLoading.value = false;
    name.value = '';
    description.value = '';
    clientName.value = '';
    plannerStore.openModal(false);
}

const addProject = () => {
    isLoading.value = true;
    let params = {
        name: name.value,
        description: description.value,
        client_name: clientName.value,
    }
    plannerStore.addProject(params).then(() => {
        clearModal();
        alertNormalStore.show = true;
        (alertNormalStore.color = "success"),
            (alertNormalStore.msg = "Se ha creado un nuevo proyecto correctamente"),
            (alertNormalStore.type = 0),
            (alertNormalStore.icon = "mdi-check-circle-outline");
        plannerStore.listProject();
    }).catch(() => {
        alertNormalStore.show = true;
        (alertNormalStore.color = "error"),
            (alertNormalStore.msg = "Error al crear el proyecto"),
            (alertNormalStore.type = 1),
            (alertNormalStore.icon = "mdi-alert-circle-outline");
        isLoading.value = false;
    })
}

</script>