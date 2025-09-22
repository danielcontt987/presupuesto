<template>
    <v-container fluid>
        <back-button @backAction="goToBack()">
            <v-btn class="rounded-lg" color="primary" size="large" flat>
                Editar
                <v-icon class="ml-2">mdi-pencil</v-icon>
            </v-btn>
        </back-button>
        <v-row>
            <v-col cols="12" md="12">
                <!-- Header -->
                <v-card class="mb-8" flat>
                    <v-card-text>
                        <v-row align="center" justify="space-between">
                            <v-row align="center" class="gap-4 my-3 ml-4">
                                <v-avatar class="rounded-lg" size="48"
                                    :color="product && product && product.is_service ? 'purple lighten-4' : 'sky'">
                                    <v-icon size="30"
                                        :color="product && product.is_service ? 'purple darken-2' : 'blue-darken-4'"
                                        class="ml-0">
                                        mdi-package-variant-closed
                                    </v-icon>
                                </v-avatar>
                                <div class="mb-3">
                                    <h1 class="ml-4 text-h5 font-weight-bold mr-3">{{ product && product.name }}</h1>
                                    <v-row class="mt-2 ml-4" dense>
                                        <v-chip small variant="tonal"
                                            :color="product && product.is_service ? 'purple lighten-4' : 'fail'"
                                            class="mr-2 rounded-lg"
                                            :text-color="product && product.is_service ? 'purple darken-2' : 'blue darken-2'">
                                            {{ product && product.is_service ? 'Servicio' : 'Producto' }}
                                        </v-chip>
                                        <v-chip class="rounded-lg" variant="tonal" color="greenLight">
                                            CODIGÓ: {{ product && product.folio }}
                                        </v-chip>
                                    </v-row>
                                </div>
                            </v-row>
                        </v-row>
                    </v-card-text>
                </v-card>

                <v-row>
                    <!-- Main Info -->
                    <v-col cols="12" lg="8" class="d-flex flex-column gap-4">
                        <!-- Descripción -->
                        <v-card flat class="mb-8">
                            <v-card-title class="d-flex align-center mt-2 mb-2">
                                <v-icon color="greyIcon">mdi-file-document-outline</v-icon>
                                <h4 class="font-weight-medium ml-1">Descripción</h4>
                            </v-card-title>
                            <v-card-text class="mr-10">
                                <p class="ml-2">{{ product && product.description }}</p>
                            </v-card-text>
                        </v-card>

                        <!-- Códigos y referencias -->
                        <v-card flat class="mb-8">
                            <!-- <v-icon>mdi-pound</v-icon>
                                <h5 class="text-subtitle-1 font-weight-medium">Códigos y Referencias</h5> -->
                            <v-card-title class="d-flex align-center mt-2 mb-2">
                                <v-icon color="greyIcon">mdi-pound</v-icon>
                                <h4 class="font-weight-medium ml-1">Códigos y Referencias</h4>
                            </v-card-title>
                            <v-row class="ml-1 mr-1 mb-2">
                                <v-col cols="12" md="6" v-for="(item, index) in references" :key="index">
                                    <v-card flat color="greyDense">
                                        <v-card-text>
                                            <v-row align="center" justify="space-between">
                                                <v-row align="center" class="gap-4 my-3 ml-4">
                                                    <v-icon size="25" class="ml-0" color="greyIcon">
                                                        {{ item.icon }}
                                                    </v-icon>
                                                    <div>
                                                        <p class="ml-4 font-weight-bold mr-3">{{ item.label
                                                        }}</p>
                                                        <v-row class="mt-2 ml-4" dense>
                                                            <p>
                                                                {{ item.value }}
                                                            </p>
                                                        </v-row>
                                                    </div>
                                                </v-row>
                                            </v-row>
                                        </v-card-text>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-card>

                        <!-- Precios -->
                        <v-card flat>
                            <v-card-title class="d-flex align-center gap-2 mt-3 mb-3">
                                <v-icon color="success">mdi-currency-usd</v-icon>
                                <span class="font-weight-medium">Precios</span>
                            </v-card-title>
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-card class="pa-4 lighten-5 rounded-lg ml-6 bg-green-lighten-5 pa-9" flat>
                                        <v-row align="center" class="mb-2">
                                            <v-icon small color="green darken-2">mdi-store</v-icon>
                                            <span class="ml-2 font-weight-bold text-green-darken-4">Precios de
                                                Tienda</span>
                                        </v-row>
                                        <v-row justify="space-between">
                                            <span class="text-green-darken-1">Precio Normal:</span>
                                            <span class="font-weight-bold text-green-darken-4">{{
                                                formatPrice(product && product.price_shop)
                                                }}</span>
                                        </v-row>
                                        <v-row justify="space-between">
                                            <span class="text-green-darken-1">Precio Especial:</span>
                                            <span class="font-weight-bold text-green-darken-4">{{
                                                formatPrice(product && product.price_s_shop)
                                                }}</span>
                                        </v-row>
                                    </v-card>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-card class="pa-4 rounded-lg mr-6 bg-blue-lighten-5 pa-9" flat>
                                        <v-row align="center" class="mb-2">
                                            <v-icon small color="blue darken-2">mdi-store</v-icon>
                                            <span class="ml-2 font-weight-bold text-blue-darken-4">Precios de
                                                Venta</span>
                                        </v-row>
                                        <v-row justify="space-between">
                                            <span class="text-blue-darken-1">Precio Normal:</span>
                                            <span class="font-weight-bold text-blue-darken-4">{{
                                                formatPrice(product && product.price_shop)
                                                }}</span>
                                        </v-row>
                                        <v-row justify="space-between">
                                            <span class="text-blue-darken-1">Precio Especial:</span>
                                            <span class="font-weight-bold text-blue-darken-4">{{
                                                formatPrice(product && product.price_s_shop)
                                                }}</span>
                                        </v-row>
                                    </v-card>
                                </v-col>
                            </v-row>
                            <v-card color="greyDense" class="ma-6 px-5 py-3 rounded-lg" flat>
                                <v-card-text>
                                    <v-row justify="space-between" align="center">
                                        <v-row align="center" class="gap-2">
                                            <v-icon color="greyIcon" small>mdi-percent</v-icon>
                                            <span class="font-weight-medium ml-2">IVA</span>
                                        </v-row>
                                        <span class="font-weight-medium">{{ product && product.iva }}%</span>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                        </v-card>
                    </v-col>

                    <!-- Sidebar -->
                    <v-col cols="12" lg="4" class="d-flex flex-column gap-4">
                        <v-card flat class="mb-8">
                            <v-card-title class="d-flex align-center mt-2 mb-2">
                                <v-icon color="greyIcon">mdi-weight-kilogram</v-icon>
                                <h4 class="font-weight-medium ml-1">Precios</h4>
                            </v-card-title>
                            <v-card color="greyDense" class="ma-6 px-5 py-3 rounded-lg" flat>
                                <v-card-text>
                                    <v-row justify="space-between" align="center">
                                        <v-row align="center" class="gap-2">
                                            <v-icon color="greyIcon" small>mdi-percent</v-icon>
                                            <span class="font-weight-medium ml-2">Peso</span>
                                        </v-row>
                                        <span class="font-weight-medium">{{ product && product.weight }} kg</span>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                        </v-card>
                        <v-card flat class="mb-8">
                            <v-card-title class="d-flex align-center mt-2 mb-2">
                                <v-icon color="greyIcon">mdi-office-building</v-icon>
                                <h4 class="font-weight-medium ml-1">Relaciones</h4>
                            </v-card-title>
                            <v-card color="greyDense" class="ma-6 px-5 py-3 rounded-lg" flat>
                                <v-card-text>
                                    <v-row justify="space-between" align="center">
                                        <v-row align="center" class="gap-2">
                                            <span class="font-weight-medium ml-2">Negocio</span>
                                        </v-row>
                                        <span class="font-weight-medium">{{ "Jose Daniel" }}</span>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                            <v-card color="greyDense" class="ma-6 px-5 py-3 rounded-lg" flat>
                                <v-card-text>
                                    <v-row justify="space-between" align="center">
                                        <v-row align="center" class="gap-2">
                                            <span class="font-weight-medium ml-2">Usuario</span>
                                        </v-row>
                                        <span class="font-weight-medium">Juan Manuel</span>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                            <v-card color="greyDense" class="ma-6 px-5 py-3 rounded-lg" flat>
                                <v-card-text>
                                    <v-row justify="space-between" align="center">
                                        <v-row align="center" class="gap-2">
                                            <span class="font-weight-medium ml-2">Categoría</span>
                                        </v-row>
                                        <span class="font-weight-medium">{{ product ? product.category.name
                                            : "NA" }}</span>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                        </v-card>
                        <!-- Fechas -->
                        <v-card flat>
                            <v-card-title class="d-flex align-center gap-2 mt-3 mb-3">
                                <v-icon color="greyIcon">mdi-calendar</v-icon>
                                <span class="font-weight-medium">Fechas</span>
                            </v-card-title>
                            <v-card-text>
                                <v-card color="greyDense" class=" mb-3 py-3 rounded-lg" flat>
                                    <v-card-text>
                                        <v-row justify="space-between" align="center">
                                            <v-row align="center" class="gap-2">
                                                <span class="font-weight-medium ml-5">Creado</span>
                                            </v-row>
                                            <span class="font-weight-medium mr-5">{{ formatDate(product &&
                                                product.created_at)
                                            }}</span>
                                        </v-row>
                                    </v-card-text>
                                </v-card>
                                <v-card color="greyDense" class="py-3 rounded-lg" flat>
                                    <v-card-text>
                                        <v-row justify="space-between" align="center">
                                            <v-row align="center" class="gap-2">
                                                <span class="font-weight-medium ml-5">Actualizado</span>
                                            </v-row>
                                            <span class="font-weight-medium mr-5">{{ formatDate(product &&
                                                product.updated_at)
                                            }}</span>
                                        </v-row>
                                    </v-card-text>
                                </v-card>
                                <!-- <v-row justify="space-between" v-if="product && product.deleted_at">
                                    <span class="red--text">Eliminado</span>
                                    <span class="red--text">{{ formatDate(product && product.deleted_at) }}</span>
                                </v-row> -->
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useProductStore } from '@/pinia/product';
import { useRouter } from 'vue-router';
import BackButton from '@/components/Global/BackButton.vue';

const productStore = useProductStore();
const router = useRouter();
const product = ref(null);

onMounted(() => {
    if (productStore.productId == 0) {
        router.push('/productos');
    }
    product.value = productStore.product
});

// const product = {
//     id: 1001,
//     folio: "PROD-2024-001",
//     folio_personality: "PERS-001",
//     name: "Laptop Gaming ASUS ROG",
//     barcode: "7501234567890",
//     description: "Laptop gaming de alto rendimiento con procesador Intel Core i7, 16GB RAM, SSD 1TB, tarjeta gráfica RTX 4060",
//     is_service: false,
//     price_shop: 18500.0,
//     price_s_shop: 17200.0,
//     price_sale: 22000.0,
//     price_s_sale: 20500.0,
//     iva: 16,
//     business_id: 1,
//     user_id: 5,
//     category_id: 3,
//     created_at: "2024-01-15T10:30:00Z",
//     updated_at: "2024-01-20T14:45:00Z",
//     deleted_at: null,
//     weight: 2.5,
//     type: "electronics"
// };

// Computed para referencias
const references = computed(() => {
    return [
        { label: 'Folio', value: product.value && product.value.folio ? product.value.folio : 'NA', icon: 'mdi-tag' },
        { label: 'Folio Personalidad', value: product.value && product.folio_personality ? product.value.folio_personality : 'NA', icon: 'mdi-tag-outline' },
        { label: 'Código de Barras', value: product.value && product.value.barcode ? product.value.barcode : 'NA', icon: 'mdi-barcode' },
        { label: 'Tipo', value: product.value ? product.value.type : "NA", icon: 'mdi-package-variant-closed' }
    ];
});

// Funciones
const goToBack = () => {
    router.push('/inicio');
};

const formatPrice = (value) => {
    return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value);
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('es-MX', {
        year: 'numeric', month: 'long', day: 'numeric',
        hour: '2-digit', minute: '2-digit'
    });
};
</script>
