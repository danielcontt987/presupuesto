<template>
    <v-dialog v-model="moduleStore.showEdit" width="500" persistent v-if="moduleStore.moduleEdit != null">
        <v-card class="my-0 pb-2 rounded-lg overflow-hidden">
            <v-card-title>
                <v-row class="mx-0">
                    <v-col cols="12" style="padding-left: 0">
                        <v-chip color="background" class="text-primary rounded-lg pa-5 font-weight-bold" label>
                            Actualizar módulo
                        </v-chip>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12">
                        <v-text-field variant="outlined" label="Nombre *" v-model="editModule.name" color="primary" />
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions class="mx-3">
                <v-row>
                    <v-col cols="12" md="6">
                        <v-btn large block class="rounded-lg" depressed color="error" @click="closeModal">
                            Cerrar
                        </v-btn>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-btn large block class="rounded-lg bg-primary" depressed @click="udpateModule()">
                            Actualizar
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <Alert />
    <!-- <AlertError /> -->
</template>

<script setup>
import { useAlertNormalStore } from '@/pinia/alert.js';
import { useErrorNormalStore } from '@/pinia/error.js';
import { useModuleStore } from '@/pinia/module.js';
import { ref } from "vue";
defineProps({
    item: {
        type: Object,
    }
});

const alertNormal = useAlertNormalStore();
const alertError = useErrorNormalStore();
const moduleStore = useModuleStore();

const editModule = ref({
    name: moduleStore.moduleEdit != null ? moduleStore.moduleEdit.name : null
})

const udpateModule = () => {

    let params = {
        id: moduleStore.moduleEdit.id,
        name: editModule.value.name
    }

    moduleStore.updateModule(params).then(() => {
        closeModal();
        alertNormal.show = true;
        (alertNormal.color = "success"),
            (alertNormal.msg = "Se ha actualizado el nuevo módulo"),
            (alertNormal.type = 0),
            moduleStore.listModule();
    }).catch(() => {
        alertError.showError = true;
        alertError.msgError = "success";
        alertError.colorError = "Ha ocurrido en el sistema al actulizar el módulo";
        alertError.typeError = 0;
    })
}

const closeModal = () => {
    moduleStore.closeModalEdit(false)
    moduleStore.clearModuleEdit()
}
</script>
<style scoped>
.v-card {
    border-radius: 12px
}
</style>