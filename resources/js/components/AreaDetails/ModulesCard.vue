<template>
    <v-card flat class="rounded-lg">
        <v-card-title>
            <v-row class="mx-0">
                <v-col cols="12" md="9" style="padding-left: 0">
                    <v-chip color="background" class="text-primary rounded-lg pa-5 font-weight-bold text-uppercase"
                        label>
                        Detalles del area
                    </v-chip>
                </v-col>
                <v-col cols="12" md="3" class="text-right">
                    <v-btn color="background" class="rounded-lg text-primary text-uppercase" flat @click="editForm()">
                        <b>{{ edit ? "Cancelar" : "Editar" }}</b>
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-title>
        <v-card-text class="pt-5">
            <v-row>
                <v-col class="pb-0" cols="12" xl="6" v-for="permission in areaStore.permission" :key="permission.id">
                    <v-card class="my-0 rounded-lg" :class="permission.granted ? 'bg-secondary' : 'bg-greyLight'" flat>
                        <v-card-text class="py-0">
                            <v-row class="d-flex align-center justify-space-between">
                                <v-col class="d-flex align-center" :class="edit ? '' : 'mb-3 mt-3'">
                                    <h5 class="my-0">{{ permission.name }}</h5>
                                </v-col>
                                <v-col class="d-flex justify-end" v-if="edit">
                                    <v-switch color="white" class="mb-0" inset :false-value="0" :true-value="1"
                                        hide-details :v-model="permission.granted"
                                        :input-value="permission.granted"
                                        @change="(value) => changeState(permission.granted, permission)"></v-switch>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-card-text>
        <v-card-actions v-if="edit">
            <v-row>
                <v-col cols="12" md="6" order="2" order-md="1">
                    <v-btn class="rounded-lg" large text depressed block color="error">
                        Cancelar
                    </v-btn>
                </v-col>
                <v-col cols="12" md="6" order="1" order-md="2">
                    <v-btn class="rounded-lg bg-primary" large depressed block @click="storePermission()">
                        Guardar cambios
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-actions>
    </v-card>
    <Alert />
</template>

<script setup>
import { useAlertNormalStore } from "../../pinia/alert.js";
import { ref } from 'vue';
import { useAreaStore } from '../../pinia/area';

const areaStore = useAreaStore();
const alertNormal = useAlertNormalStore();
const edit = ref(false);
const idsPermission = ref([]);

const editForm = () => {
    edit.value = !edit.value;
};

const changeState = (bool, permissionId) => { 
    areaStore.updatePermission(bool, permissionId);
};

const storePermission = () => {
    areaStore.permission.forEach(element => {
        if (element.granted) {
            idsPermission.value.push(element.module_id);
        }
    });
    let params = {
        "ids": idsPermission.value,
        "area_id": areaStore.area_id
    }
    
    areaStore.savePermission(params).then((response) =>{        
        alertNormal.show = true;
        (alertNormal.color = "success"),
        (alertNormal.msg = "Se han creado nuevos permisos"),
        (alertNormal.type = 0),
        (alertNormal.icon = "mdi-check-circle-outline");
        areaStore.consulInfo();
    }).catch((error) => {
        alertNormal.show = true;
        (alertNormal.color = "error"),
        (alertNormal.msg = "Ha ocurrido un error al crear los permisos para el área"),
        (alertNormal.type = 0),
        (alertNormal.icon = "mdi-close-circle-outline");
    })
    
}
</script>
