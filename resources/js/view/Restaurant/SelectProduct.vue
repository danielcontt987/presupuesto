<template>
    <v-navigation-drawer class="bg-white" permanent :location="sizeMd" width="400">
        <v-list-item lines="two" subtitle="Mesa seleccionada" title="Mesa 1">
            <template #prepend>
                <v-avatar color="#00CFB5" :size="40" class="bordered-avatar font-weight-bold">
                    <span class="text-white font-bold">{{ 1 }}</span>
                </v-avatar>
            </template>
        </v-list-item>
        <v-list-item class="text-center" v-if="restaurantStore.items.length == 0">
            <v-col cols="12" class="text-center">
                <v-icon color="background" size="200">mdi-food-apple-outline</v-icon>
                <p class="text-primary text-center font-weight-bold">
                    Sin orden agregada
                </p>
            </v-col>
        </v-list-item>
        <v-list-item>
            <v-row no-gutters class="mt-6" v-if="restaurantStore.items.length > 0">
                <v-col cols="12">
                    <v-btn color="primary" @click="openOrden = true">
                        <v-badge color="error" :content="restaurantStore.items.length" offset-x="-15" offset-y="-6">
                            <span class="py-2">Ver pedido</span>
                        </v-badge>
                    </v-btn>
                </v-col>
            </v-row>
        </v-list-item>
        <v-list-item class="py-2">
            <v-row no-gutters>
                <v-col cols="12" v-for="item in restaurantStore.items" :key="item.id">
                    <v-card variant="outlined" class="mb-2" color="grey">
                        <v-card-text>
                            <v-row no-gutters>
                                <span>{{ item.qty }} x</span>
                                <span class="text-black font-weight-bold ml-2">
                                    {{ item.name }}
                                </span>
                            </v-row>
                            <v-row no-gutters>
                                <span class="text-black">
                                    {{ item.comment ? item.comment : 'Sin comentario' }}
                                </span>
                            </v-row>
                            <v-row no-gutters>
                                <span class="text-black">
                                    {{ item.price ? currency(item.price) : 'Sin precio' }}
                                </span>
                            </v-row>
                            <v-row no-gutters class="text-right justify-end">
                                <v-btn icon @click="removeItem(item)" class="rounded-lg" flat size="small"
                                    color="error">
                                    <v-icon>mdi-delete</v-icon>
                                </v-btn>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-list-item>

        <template v-slot:append>
            <div class="pa-2">
                <v-btn class="bg-primary text-white" block flat>
                    Agregar a la cuenta
                </v-btn>
            </div>
        </template>
    </v-navigation-drawer>

    <!-- Contenido principal -->
    <v-container fluid>
        <v-row>
            <v-col cols="12" md="10">
                <vc-back-button @backAction="navigateToHome"></vc-back-button>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" md="12">
                <v-row v-if="mdDown" no-gutters>
                    <v-col cols="12" md="8">
                        <v-select label="Cocina fría" :items="['Ensaladas', 'Sopas', 'Entradas']" item-title="text"
                            item-value="value" variant="solo" flat />
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field label="Buscar producto" variant="solo" flat />
                    </v-col>
                </v-row>
                <v-row v-else>
                    <v-col cols="12" md="8">
                        <v-select label="Cocina fría" :items="['Ensaladas', 'Sopas', 'Entradas']" item-title="text"
                            item-value="value" variant="solo" flat />
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field label="Buscar producto" variant="solo" flat />
                    </v-col>
                </v-row>
                <v-row no-gutters>
                    <v-col cols="12">
                        <v-sheet class="mx-auto bg-white rounded-lg pa-2">
                            <v-slide-group show-arrows>
                                <v-slide-group-item v-for="n in 25" :key="n" v-slot="{ isSelected, toggle }">
                                    <v-btn :color="isSelected ? 'primary' : undefined" class="ma-2" rounded
                                        @click="toggle">
                                        Options {{ n }}
                                    </v-btn>
                                </v-slide-group-item>
                            </v-slide-group>
                        </v-sheet>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" md="4" v-for="product in productStore.products" :key="product.id">
                        <v-card class="pa-2" flat @click="selectProduct(product)">
                            <v-card-text>
                                <h3 class="text-uppercase">{{ product.name }}</h3>
                                <p>{{ currency(product.price_sale) }}</p>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
    <v-dialog v-model="openOrden" width="750" persistent class="rounded-lg">
        <card-base-modal outlined :loading="isLoading">
            <template v-slot:text>
                <v-card-text class="mt-3 py-2">
                    <v-row class="mx-0">
                        <v-col cols="12" style="padding-left: 0">
                            <v-chip color="background" class="text-primary rounded-lg pa-6 font-weight-bold" label>
                                Agregar comanda
                            </v-chip>
                        </v-col>
                    </v-row>
                    <template template v-if="product">
                        <v-row no-gutters class="mt-5">
                            <v-col cols="12" class="mb-6">
                                <p class="font-weight-bold">{{ product && product.name }}</p>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field label="Cantidad" v-model="product.qty" type="number" variant="outlined" />
                            </v-col>
                            <v-col cols="12">
                                <v-text-field label="Comentario" v-model="product.comment" variant="outlined" />
                            </v-col>
                        </v-row>
                    </template>
                </v-card-text>
            </template>
            <template v-slot:actions>
                <v-card-actions class="mt-3 py-2">
                    <v-col cols="12" md="6" order="2" order-md="1">
                        <v-btn class="rounded-lg" size="large" @click="closeModal()" text depressed block color="error">
                            Cerrar
                        </v-btn>
                    </v-col>
                    <v-col cols="12" md="6" order="1" order-md="2">
                        <v-btn class="rounded-lg bg-primary" size="large" @click="addCommand" depressed block>
                            Agregar
                        </v-btn>
                    </v-col>
                </v-card-actions>
            </template>
        </card-base-modal>
    </v-dialog>
</template>


<script setup>
import accounting from 'accounting';
import { computed, nextTick, onMounted, ref } from 'vue';
import { useRestauratStore } from '../../pinia/restaurant';
import { useRouter } from 'vue-router';
import { useProductStore } from '../../pinia/product';
import CardBaseModal from '../../components/global/CardBaseModal.vue';
import VcBackButton from '../../components/global/BackButton.vue';
import { useDisplay } from 'vuetify';

const { mdAndDown } = useDisplay();

const router = useRouter();

const restaurantStore = useRestauratStore();
const productStore = useProductStore();

const product = ref(null);
const isLoading = ref(false);
const products = ref([]);

onMounted(() => {
    if (restaurantStore.selectedTable == null) {
        router.push({ name: 'Restaurante' });
    }

    productStore.listProducts();

});


const sizeMd = computed(() => {
    return mdAndDown.value ? 'bottom' : 'right';
});

const mdDown = computed(() => {
    return mdAndDown.value;
});


const currency = (value) => {
    if (value >= 0) return accounting.formatMoney(value);
    else if (!!value) return accounting.formatMoney(Math.abs(value));
    else return accounting.formatMoney(0, "- $ ");
}



const openOrden = ref(false);
const selectProduct = (item) => {
    openOrden.value = true;
    product.value = item;
    product.value = {
        ...product.value,
        qty: 1,
        comment: null,
    };
};

const closeModal = async () => {
    openOrden.value = false;

    await nextTick(); // o setTimeout(() => { ... }, 100);
    product.value = null;
};

const navigateToHome = () => {
    router.push('/inicio');
};

const addCommand = () => {
    if (product.value.qty <= 0) {
        alert('La cantidad debe ser mayor a 0');
        return;
    }

    const fakeId = `${product.value.id}-${Date.now()}-${Math.random().toString(36).substring(2, 6)}`;

    restaurantStore.addItem({
        id: fakeId,
        name: product.value.name,
        price: product.value.price_sale,
        product_id: product.value.id,
        qty: product.value.qty,
        comment: product.value.comment,
        table_id: restaurantStore.selectedTable.id,
    });

    closeModal();
};

const removeItem = (item) => {
    restaurantStore.removeItem(item)
};


</script>