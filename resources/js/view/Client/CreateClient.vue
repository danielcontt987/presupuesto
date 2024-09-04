<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" md="10">
                <vc-back-button @backAction="navigateToHome"></vc-back-button>
            </v-col>

            <v-col cols="12">
                <v-card>
                    <v-card-text>
                        <v-stepper v-model="step" class="elevation-0">
                            <v-stepper-header class="elevation-0">
                                <v-stepper-item title="Información del cliente" :value="1" color="primary" />
                            </v-stepper-header>
                            <v-stepper-window direction="vertical" v-if="step == 1">
                                <v-stepper-window-item :value="1">
                                    <v-row>
                                        <v-col cols="12" md="4">
                                            <v-text-field label="Nombre *" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="4">
                                            <v-text-field label="Calle *" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="4">
                                            <v-text-field label="Número ext *" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-text-field label="Número int (Opcional)" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-autocomplete label="Colonia *" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-file-input :prepend-icon="null" label="Imagen" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="3">
                                            <v-text-field label="Teléfono *" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="3">
                                            <v-text-field label="Teléfono (Opcional)" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="4">
                                            <v-text-field label="Whatsapp (Opcional)" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="4">
                                            <v-text-field label="Sitio web (Opcional)" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="4">
                                            <v-text-field label="Página de facebook (Opcional)" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                    </v-row>
                                </v-stepper-window-item>
                            </v-stepper-window>
                            <v-stepper-header class="elevation-0">
                                <v-stepper-item title="Datos fiscales" :value="2" color="primary" />
                            </v-stepper-header>
                            <v-stepper-window direction="vertical" v-show="step == 2" elevation="0">
                                <v-stepper-window-item :value="2"> 
                                    <v-row>
                                        <v-col cols="12" md="4">
                                            <v-text-field label="RFC *" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="4">
                                            <v-text-field label="Razón social *" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="4">
                                            <v-text-field label="Calle fiscal *" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="4">
                                            <v-text-field label="Número exterior fiscal *" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="4">
                                            <v-text-field label="Número interior fiscal" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="4">
                                            <v-text-field label="Colonia fiscal *" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="4">
                                            <v-autocomplete label="Zona horaria *" color="primary" :items="timeZone" item-title="text" variant="outlined" hide-details />
                                        </v-col>
                                    </v-row>
                                </v-stepper-window-item>
                            </v-stepper-window>
                            <v-stepper-header class="elevation-0">
                                <v-stepper-item title="Crédito" :value="3" />
                            </v-stepper-header>
                            <v-stepper-window direction="vertical" v-show="step == 3">
                                <v-stepper-window-item :value="3">
                                   <v-row>
                                       <v-col cols="12" md="4">
                                           <v-autocomplete label="Estatus *" color="primary" :items="status" item-title="text" variant="outlined" hide-details />
                                       </v-col>
                                        <v-col cols="12" md="4">
                                                <v-select :items="creditSelect" label="¿Tiene crédito? *" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="4">
                                            <v-text-field label="Número de cliente" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-select :items="unitCredit" label="Periodo de tiempo *" item-title="text" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            <v-text-field type="number" label="Límite de crédito *" color="primary" variant="outlined" hide-details />
                                        </v-col>
                                   </v-row>
                                </v-stepper-window-item>
                            </v-stepper-window>
                        </v-stepper>
                    </v-card-text>
                    <v-card-actions class="mx-3">
                        <v-row class="mb-3">
                            <v-col cols="12" md="6">
                                <v-btn large block size="large" class="rounded-lg bg-warning text-black" depressed @click="step--" v-if="step > 1">
                                    Regresar
                                </v-btn>
                            </v-col>
                            <v-col cols="12" :md="step > 1 ? 6 : 12">
                                <v-btn large size="large" block class="rounded-lg bg-primary" depressed @click="step++">
                                    Continuar
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script setup>
import { ref } from 'vue';
import VcBackButton from '../../components/global/BackButton.vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const navigateToHome = () => {
    router.push("/inicio");
};

const timeZone = ref([
    {
        value: "America/Mexico_City",
        text: "Zona centro"
    }
]);

const status = ref([
    {
        value: "active",
        text: "Activo"
    },
    {
        value: "inactive",
        text: "Inactivo"
    },
    {
        value: "propectus",
        text: "Prospecto"
    },
]);

const creditSelect = ref([
    {
        value: 1,
        text: "Sí"
    },
    {
        value: 0,
        text: "No"
    },
]);

const unitCredit = ref ([
    {
        value: "na",
        text: "N/A"
    },
    {
        value: "days",
        text: "Diario"
    },
    {
        value: "month",
        text: "Mes(es)"
    },
])

const step = ref(1);

</script>