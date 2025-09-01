<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" md="10">
                <vc-back-button @backAction="navigateToHome"></vc-back-button>
            </v-col>
            <v-col cols="12">
                <v-card flat>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" md="4">
                                <v-text-field label="Nombre del producto *" color="primary" variant="outlined"
                                    v-model="product.name" hide-details />
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field label="Folio" color="primary" variant="outlined" hide-details
                                    v-model="product.folio" />
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field label="Codígo de barras *" color="primary" variant="outlined" hide-details
                                    v-model="product.barcode" />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field label="Descripción" color="primary" variant="outlined" hide-details
                                    v-model="product.description" />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-autocomplete label="Categorias *" color="primary" variant="outlined"
                                    :items="categories" item-title="name" item-value="id" hide-details
                                    v-model="product.category_id" />
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-text-field label="Precio de compra sin IVA *" color="primary" variant="outlined"
                                    hide-details v-model="product.price_s_shop" />
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-text-field label="Precio de compra" color="primary" variant="outlined" hide-details
                                    v-model="product.price_shop" />
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-text-field label="Precio de venta sin IVA*" color="primary" variant="outlined"
                                    hide-details v-model="product.price_s_iva" />
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-text-field label="Precio de venta" color="primary" variant="outlined" hide-details
                                    v-model="product.price" />
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-autocomplete label="Tipo *" color="primary" variant="outlined" hide-details
                                    v-model="product.type" :items="ProductTypes" item-title="text" />
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-text-field label="Existencias *" color="primary" variant="outlined" hide-details
                                    v-model="product.stock" />
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-text-field label="Peso (kgs) *" color="primary" variant="outlined" hide-details
                                    v-model="product.weight" />
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions class="mx-3">
                        <v-row class="mb-3">
                            <v-col cols="12">
                                <v-btn large size="large" block class="rounded-lg bg-primary" depressed
                                    @click="createProduct">
                                    Guardar
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
        <Alert />
    </v-container>
</template>

<script setup>
import { useRouter } from 'vue-router';
import VcBackButton from '@/components/global/BackButton.vue';
import { onMounted, ref } from 'vue';
import { useProductStore } from '@/pinia/product';
import { useAlertNormalStore } from '@/pinia/alert';

const router = useRouter();
const alertStore = useAlertNormalStore();
const productStore = useProductStore();

onMounted(() => {
    productStore.listCategory().then((response) => {
        categories.value = response.data
    })
})

//Varibles
const categories = ref([]);
const product = ref({
    name: "",
    folio: "",
    barcode: "",
    description: "",
    category_id: "",
    price_s_shop: "",
    price_shop: "",
    price: "",
    price_s_iva: "",
    type: "",
    stock: 0,
    weight: "",

});

const ProductTypes = ref([
    {
        text: "Pieza",
        value: "piece"
    },
    {
        text: "Kilogramo",
        value: "kilogram"
    },
    {
        text: "Caja",
        value: "box"
    },
    {
        text: "Mixto",
        value: "mixto"
    },
    {
        text: "Kit",
        value: "kit"
    },
    {
        text: "Litro",
        value: "liter"
    }
])

//Methods
const navigateToHome = () => {
    router.push('/productos');
};

const createProduct = () => {
    let params = {
        product: product.value
    }
    productStore.storeProduct(params).then((response) => {
        alertStore.show = true;
        alertStore.color = "success";
        alertStore.msg = "Se ha creado un nuevo producto correctamente";
        navigateToHome();
    }).catch((error) => {
        alertStore.show = true;
        alertStore.color = "error";
        alertStore.msg = "Se ha producido un error al crear el producto";

    })
}


</script>