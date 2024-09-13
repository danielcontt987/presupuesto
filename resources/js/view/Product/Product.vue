<template>
    <v-container fluid>
        <back-button @backAction="goToBack()" />
        <v-row>
            <v-col cols="12">
                <v-card flat>
                    <v-card-title>
                        <v-row class="mx-3">
                            <v-col cols="12" md="9" style="padding-left: 0">
                                <v-chip color="background" class="text-primary rounded-lg pa-5 font-weight-bold" label>
                                    Productos
                                </v-chip>
                            </v-col>
                        </v-row>
                        <v-tabs v-model="selectedtab" class="mt-5 mx-3" centered background-color="background" grow>
                            <v-tab value="one"
                                class="rounded-lg mr-3 bg-background text-weight-bold text-primary"><b>Productos</b></v-tab>
                            <v-tab value="two" class="rounded-lg bg-background text-primary"><b>Servicios</b></v-tab>
                        </v-tabs>
                    </v-card-title>
                    <v-card-text class="my-2">
                        <v-text-field v-model="search" label="Buscar" variant="outlined" class="mx-3" />
                        <v-row class="mx-0">
                            <v-col cols="12" md="4">
                                <v-card elevation="0" variant="outlined" color="primary">
                                    <v-card-text>
                                        <v-row>
                                            <v-col cols="12" md="6">
                                                <v-chip color="fail" variant="tonal" class="rounded-lg">Folio:
                                                    2569</v-chip>
                                            </v-col>
                                            <v-spacer></v-spacer>
                                            <v-col cols="12" md="6">
                                                <h5 class="text-primary text-right">CREADO: 11/05/2020</h5>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="6">
                                                <p>ARTÍCULO</p>
                                                <h4 class="text-primary">PERA VERDE</h4>
                                            </v-col>
                                            <v-col cols="12" md="6" class="text-right">
                                                <p>EXISTENCIAS</p>
                                                <p class="text-fail">0</p>
                                            </v-col>
                                            <v-col cols="12">
                                                <p>PRECIO</p>
                                                <h4 class="text-primary">$15.09 MXN</h4>
                                            </v-col>
                                            <v-col cols="12">
                                                <p>MARCA / MODELO</p>
                                                <h4 class="text-primary">$15.09 MXN</h4>
                                            </v-col>
                                            <v-col cols="12">
                                                <p>DESCRICIÓN DEL PRODUCTO</p>
                                                <h4 class="text-primary">PERA VERDE DE TEMPORADA</h4>
                                            </v-col>
                                            <v-col cols="12" md="6">
                                                <p>PRECIO CON IVA</p>
                                                <h4 class="text-primary">$17.50 MXN</h4>
                                            </v-col>
                                            <v-col cols="12" md="6" class="text-right">
                                                <p>ALMACÉN</p>
                                                <v-chip class="rounded-lg" variant="tonal"
                                                    color="success">GENERAL</v-chip>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-row>
                                            <v-col cols="12" md="6">
                                                <v-btn class="rounded-lg bg-primary" large depressed block>
                                                    Ver detalle
                                                </v-btn>
                                            </v-col>
                                            <v-col cols="12" md="6">
                                                <v-btn class="rounded-lg bg-fail" large depressed block>
                                                    Eliminar
                                                </v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-card-actions>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script setup>
import { useRouter } from 'vue-router';
import BackButton from '../../components/global/BackButton.vue';
import { ref } from 'vue';
const router = useRouter();

const selectedtab = ref(null);
const search = ref("");

const goToBack = () => {
    router.push('/inicio')
}
</script>