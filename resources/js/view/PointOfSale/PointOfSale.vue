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
                <v-combobox
                    variant="outlined"
                    :items="productStore.products"
                    item-title="name"
                    v-model="product"
                    label="Productos"
                    @update:model-value="addProduct"
                />
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-data-table
                    class="rounded-lg"
                    :headers="headers"
                    :items="pointsaleStore.products">
                    <template v-slot:item.quantity="{ item }">
                        <v-text-field
                            v-model="item.quantity"
                            outlined
                            dense
                            class="rounded-lg"
                            type="number"
                            variant="outlined"
                        />
                    </template>
                    <template v-slot:item.price="{ item }">
                        <v-text-field
                            v-model="item.price_sale"
                            outlined
                            dense
                            class="rounded-lg"
                            type="number"
                            variant="outlined"
                        />
                    </template>
                    <template v-slot:item.subtotal="{ item }">
                        {{ parseFloat(item.quantity) * parseFloat(item.price_sale) }}
                    </template>
                    <template v-slot:item.total="{ item }">
                        {{ parseFloat(item.quantity) * parseFloat(item.price_sale)}}
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-btn
                            icon
                            class="rounded-lg"
                            color="error"
                            @click="pointsaleStore.removeProducts(item)"
                            
                        >
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </template>
            </v-data-table>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" md="8">
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
            </v-col>
            <v-col cols="12" md="4">
                <v-row height="100%" width="100%">
                    <v-col cols="12">
                        <v-card color="primary" class="my-0 rounded-lg">
                            <v-card-text class="white--text">
                                
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue';

import {useProductStore} from '../../pinia/product';
import {usePointsaleStore} from '../../pinia/pointsale';
const productStore = useProductStore();
const pointsaleStore = usePointsaleStore();

onMounted(() => {
    productStore.listProducts();
});


const product = ref(null);


const headers = ref(
    [
        { title: 'Producto', align: 'center', key: 'name' },
        { title: 'Cantidad', align: 'center', key: 'quantity' },
        { title: 'Precio unitario', align: 'center', key: 'price' },
        { title: 'Subtotal', align: 'center', key: 'subtotal' },
        { title: 'Total', align: 'center', key: 'total' },
        { title: 'Acciones', align: 'center', sortable: false, key: 'actions' },
    ]
)

const addProduct = () => {
    pointsaleStore.addProducts(product.value);
}

const currency = (value) => {
    if (value >= 0) return accounting.formatMoney(value);
    else if (!!value) return accounting.formatMoney(Math.abs(value));
    else return accounting.formatMoney(0, "- $ ");
}
</script>