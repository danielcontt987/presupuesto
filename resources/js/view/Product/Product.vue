<template>
    <v-container fluid>
        <back-button @backAction="goToBack()" />
        <v-row>
            <v-col cols="12">
                <v-card flat>
                    <v-card-title>
                        <v-row class="mx-3">
                            <v-col cols="12" md="9" style="padding-left: 0">
                                <v-chip color="background" class="text-primary rounded-lg pa-5 font-weight-bold" label
                                    :style="size ? 'width: 100%; text-align: center; margin-left: 10px; margin-right: 25px;' : ''"
                                    :class="size ? 'd-flex justify-center' : ''">
                                    Productos
                                </v-chip>
                            </v-col>
                            <v-col cols="12" md="3" class="text-right">
                                <v-btn class="elevation-0 rounded-lg font-weight-bold mx-0" color="primary"
                                    variant="outlined" :block="size ? true : false">
                                    Opciones
                                    <v-menu activator="parent">
                                        <v-list>
                                            <v-list-item @click="createProduct()">
                                                <v-list-item-title>Agregar producto</v-list-item-title>
                                            </v-list-item>
                                            <v-list-item @click="openModalCategories()">
                                                <v-list-item-title>Categorías</v-list-item-title>
                                            </v-list-item>
                                            <v-list-item @click="openModalCategories()">
                                                <v-list-item-title>Cargar plantilla Excel</v-list-item-title>
                                            </v-list-item>
                                            <v-list-item @click="openModalCategories()">
                                                <v-list-item-title>Kardex de movimientos</v-list-item-title>
                                            </v-list-item>
                                            <v-list-item @click="downloadExcel()">
                                                <v-list-item-title>Descargar Excel</v-list-item-title>
                                            </v-list-item>
                                            <v-list-item @click="openModalCategories()">
                                                <v-list-item-title>Descargar lista de precios</v-list-item-title>
                                            </v-list-item>
                                        </v-list>
                                    </v-menu>
                                </v-btn>
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
                            <v-col cols="12" md="4" v-for="product in products" :key="product.id">
                                <v-card elevation="0" variant="outlined" color="primary">
                                    <v-card-text>
                                        <v-row>
                                            <v-col cols="12" md="6">
                                                <v-chip color="fail" variant="tonal" class="rounded-lg">Folio:
                                                    {{ product.folio }}</v-chip>
                                            </v-col>
                                            <v-spacer></v-spacer>
                                            <v-col cols="12" md="6">
                                                <h5 class="text-primary text-right">CREADO: {{
                                                    $formatDate(product.created_at) }}</h5>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="12" md="6">
                                                <p>ARTÍCULO</p>
                                                <h4 class="text-primary text-transform">{{ product.name }}</h4>
                                            </v-col>
                                            <v-col cols="12" md="6" class="text-right">
                                                <p>EXISTENCIAS</p>
                                                <p class="text-fail">{{ product.inventory_detail.stock }}</p>
                                            </v-col>
                                            <v-col cols="12">
                                                <p>PRECIO</p>
                                                <h4 class="text-success">{{ currency(product.price_sale) }}</h4>
                                            </v-col>
                                            <v-col cols="12">
                                                <p>CATEGORÍAS</p>
                                                <h4 class="text-primary text-transform">{{ product.category.name }}</h4>
                                            </v-col>
                                            <v-col cols="12">
                                                <p>DESCRICIÓN DEL PRODUCTO</p>
                                                <h4 class="text-primary text-transform">{{ product.description }}</h4>
                                            </v-col>
                                            <v-col cols="12" md="6">
                                                <p>CODIGO DE BARRAS</p>
                                                <h4 class="text-fail">{{ product.barcode }}</h4>
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
    <product-dialog />
</template>
<script setup>
import { useRouter } from 'vue-router';
import { useDisplay } from 'vuetify';
import { useProductStore } from '@/pinia/product.js';
import accounting from 'accounting';
import BackButton from '@/components/global/BackButton.vue';

const productStore = useProductStore();


const display = useDisplay();

import { computed, onMounted, ref } from 'vue';
import ProductDialog from '../../components/Product/Dialog/ProductDialog.vue';
const router = useRouter();

const selectedtab = ref(null);
const search = ref("");

const goToBack = () => {
    router.push('/inicio')
}

// const formatCurrency = (value) => {
//     return accounting.formatMoney(value);
// }

const currency = (value) => {
    if (value >= 0) return accounting.formatMoney(value);
    else if (!!value) return accounting.formatMoney(Math.abs(value));
    else return accounting.formatMoney(0, "- $ ");
}

const createProduct = () => {
    router.push('/crear-producto')
}

const downloadExcel = () => {
    const fileExcel = "plantillas/PlantillaDeProductos.xlsx";
    const file = fileExcel.split("/");
    const fileName = file[file.length - 1];
    const element_excel = document.createElement("a");
    element_excel.setAttribute("href", fileExcel);
    element_excel.innerHTML = "";
    element_excel.setAttribute("download", fileName);
    element_excel.click();
}

const openModalCategories = () => {
    productStore.openDialogCategory(true);
}
const size = computed(() => !display.mdAndUp.value);

onMounted(() => {
    productStore.listProducts();
});

const products = computed(() => {
    // const startIndex = (page.value - 1) * itemsPerPage.value;
    // const endIndex = startIndex + itemsPerPage.value;
    // return areasStore.areas.slice(startIndex, endIndex);
    return productStore.products;
});
</script>