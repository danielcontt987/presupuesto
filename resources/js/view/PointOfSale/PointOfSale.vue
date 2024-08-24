<template>
    <v-container fluid>
        <v-row>
            <v-col cols="6">
               <p class="text-primary"><b>Nombre:</b></p>
               <p class="text-primary"><b>Caja:</b></p>
            </v-col>
            <v-col cols="6" class="text-right">
               <p class="text-primary"><b>Última cotización:</b></p>
               <p class="text-primary"><b>Cotización del día:</b></p>
               <p class="text-primary"><b>Cotización en espera:</b></p>
               <p class="text-primary"><b>Monto cotizado:</b></p>
            </v-col>
            <v-col cols="4">
                <v-select
                 variant="outlined"
                 label="Clientes"
                />
            </v-col>
            <v-col cols="8">
                <v-select
                 variant="outlined"
                 label="Servicios"
                />
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-data-table
                    class="rounded-lg"
                    :headers="headers"
                ></v-data-table>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="6">
                <v-card color="grey_dark" class="my-0 rounded-lg">
                    <v-card-text class="white--text d-flex justify-center align-center flex-column">
                            <v-icon size="50" color="white">
                                {{ "mdi-percent" }}
                            </v-icon>
                            <h4 class="mt-3 text-uppercase colorText">
                                {{ "Aplicar descuento" }}
                            </h4>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="6">
                <v-card color="fail" class="my-0 rounded-lg">
                    <v-card-text class="white--text d-flex justify-center align-center flex-column">
                            <v-icon size="50" color="white">
                                {{ "mdi-close" }}
                            </v-icon>
                            <h4 class="mt-3 text-uppercase colorText">
                                {{ "Cancelar cotización" }}
                            </h4>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="6">
                <v-card color="greenLight" class="my-0 rounded-lg">
                    <v-card-text class="white--text d-flex justify-center align-center flex-column">
                            <v-icon size="50" color="white">
                                {{ "mdi-more" }}
                            </v-icon>
                            <h4 class="mt-3 text-uppercase text-white">
                                {{ "Más opciones" }}
                            </h4>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="6">
                <v-card color="success" class="my-0 rounded-lg">
                    <v-card-text class="white--text d-flex justify-center align-center flex-column">
                            <v-icon size="50" color="white">
                                {{ "mdi-cash-register" }}
                            </v-icon>
                            <h4 class="mt-3 text-uppercase colorText">
                                {{ "Cotizar precios" }}
                            </h4>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { ref } from 'vue';

const headers = ref(
    [
        { title: 'Producto', align: 'center'},
        { title: 'Cantidad', align: 'center' },
        { title: 'Área', align: 'center', },
        { title: 'Precio unitario', align: 'center' },
        { title: 'Subtotal', align: 'center' },
        { title: 'Total', align: 'center' },
        { title: 'Acciones', align: 'center', sortable: false },
    ]
)
</script>