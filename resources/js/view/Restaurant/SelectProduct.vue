<template>
    <v-navigation-drawer class="bg-white" permanent v-if="openDrawerUpdate" :location="sizeMd" width="400">
        <v-list-item lines="two" subtitle="Mesa seleccionada"
            :title="restaurantStore.selectedTable ? restaurantStore.selectedTable.name : 'Sin mesa seleccionada'">
            <template #prepend>
                <v-avatar color="#00CFB5" :size="40" class="bordered-avatar font-weight-bold">
                    <span class="text-white font-bold">{{ restaurantStore.selectedTable ??
                        restaurantStore.selectedTable.number }}</span>
                </v-avatar>
            </template>
        </v-list-item>
        <v-list-item class="text-center" v-if="restaurantStore.commands && restaurantStore.commands.length == 0">
            <v-col cols="12" class="text-center mt-12">
                <v-icon color="background" size="200">mdi-food-apple-outline</v-icon>
                <p class="text-primary text-center font-weight-bold">
                    Sin orden agregada
                </p>
            </v-col>
        </v-list-item>
        <v-list-item>
            <v-row no-gutters class="mt-6" v-if="restaurantStore.commands.length > 0">
                <v-col cols="12">
                    <v-btn color="primary" @click="openCommand = true">
                        <v-badge color="error" :content="restaurantStore.commands.length" offset-x="-15" offset-y="-6">
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

    <template v-if="openDrawerUpdate == false">
        <v-btn class="bg-primary text-white" style="position: absolute; bottom: 16px; left: 16px; z-index: 20;" icon
            size="large" @click="openDrawer = !openDrawer">
            <v-badge color="error" :content="restaurantStore.commands.length" offset-x="-16" offset-y="-17">
                <v-icon>mdi-plus</v-icon>
            </v-badge>
        </v-btn>
    </template>

    <v-navigation-drawer class="bg-white" v-model="openDrawer" v-if="!openDrawerUpdate" location="right" width="400">
        <v-list-item lines="three" subtitle="Mesa seleccionada"
            :title="restaurantStore.selectedTable ? restaurantStore.selectedTable.name : 'Sin mesa seleccionada'">
            <!-- Avatar a la izquierda -->
            <template #prepend>
                <v-avatar color="#00CFB5" :size="40" class="bordered-avatar font-weight-bold">
                    <span class="text-white font-bold">{{ restaurantStore.selectedTable ?
                        restaurantStore.selectedTable.number : 'Sin mesa seleccionada' }}</span>
                </v-avatar>
            </template>

            <!-- Botón de cerrar a la derecha -->
            <template #append>
                <v-btn icon @click="openDrawer = false" flat v-if="mobile">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </template>
        </v-list-item>

        <v-list-item class="text-center" v-if="restaurantStore.commands && restaurantStore.commands.length == 0">
            <v-col cols="12" class="text-center mt-12">
                <v-icon color="background" size="200">mdi-food-apple-outline</v-icon>
                <p class="text-primary text-center font-weight-bold">
                    Sin orden agregada
                </p>
            </v-col>
        </v-list-item>
        <v-list-item>
            <v-row no-gutters class="mt-6" v-if="restaurantStore.commands.length > 0">
                <v-col cols="12">
                    <v-btn color="primary" @click="openCommand = true">
                        <v-badge color="error" :content="restaurantStore.commands.length" offset-x="-15" offset-y="-6">
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
                <v-btn class="bg-primary text-white" block flat @click="addAccount()">
                    Agregar a la cuenta
                </v-btn>
            </div>
            <div class="pa-2" v-if="restaurantStore.commands && restaurantStore.commands.length > 0">
                <v-btn class="bg-greenLight text-white" block flat @click="payAccount()">
                    Pagar y cuenta
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
                        <v-select v-model="category" :items="restaurantStore.categories" item-value="id"
                            item-title="name" label="Categoría" :loading="isLoading" variant="solo" flat
                            @update:model-value="onCategoryChange" />
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field label="Buscar producto" variant="solo" flat />
                    </v-col>
                </v-row>
                <v-row v-else>
                    <v-col cols="12" md="8">
                        <v-select v-model="category" :items="restaurantStore.categories" item-value="id"
                            item-title="name" label="Categoría" :loading="isLoading" variant="solo" flat
                            @update:model-value="onCategoryChange" />
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-text-field label="Buscar producto" variant="solo" flat />
                    </v-col>
                </v-row>
                <!-- <v-row no-gutters>
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
                </v-row> -->
                <v-row>
                    <v-col cols="12" md="4" v-for="n in 9" :key="n" v-if="isLoadingProduct">
                        <v-skeleton-loader class="rounded-lg" flat type="heading, text" />
                    </v-col>
                    <v-col v-else cols="12" md="4" v-for="product in productStore.products" :key="product.id">
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
    <v-dialog v-model="openCommand" width="850" persistent class="rounded-lg">
        <card-base-modal outlined :loading="isLoading">
            <template v-slot:text>
                <v-card-text class="mt-3 py-2">
                    <v-row class="mx-0">
                        <v-col cols="12" style="padding-left: 0">
                            <v-chip color="background" class="text-primary rounded-lg pa-6 font-weight-bold" label>
                                Comanda(s)
                            </v-chip>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="12" v-for="item in restaurantStore.commands" :key="item.id">
                            <v-expansion-panels>
                                <v-expansion-panel expand>
                                    <v-expansion-panel-title class="text-primary"> <b> Comanda #{{ item.id }}</b>
                                    </v-expansion-panel-title>
                                    <v-expansion-panel-text>
                                        <v-data-table :headers="headers" :items="item.details" class="elevation-0" flat>
                                            <template v-slot:item.name="{ item }">
                                                {{ item.product.name }}
                                            </template>
                                            <template v-slot:item.note="{ item }">
                                                {{ item.notes ? item.notes : 'Sin comentario' }}
                                            </template>
                                            <template v-slot:item.qty="{ item }">
                                                {{ item.quantity }}
                                            </template>
                                            <template v-slot:item.price="{ item }">
                                                {{ currency(item.price) }}
                                            </template>
                                            <template v-slot:item.total="{ item }">
                                                {{ currency(item.total) }}
                                            </template>

                                        </v-data-table>
                                    </v-expansion-panel-text>
                                </v-expansion-panel>
                            </v-expansion-panels>
                        </v-col>
                    </v-row>
                </v-card-text>
            </template>
            <template v-slot:actions>
                <v-card-actions class="mt-3 py-2">
                    <v-col cols="12" order="1" order-md="1">
                        <v-btn class="rounded-lg" size="large" @click="openCommand = false" text depressed block
                            color="error">
                            Cerrar
                        </v-btn>
                    </v-col>
                </v-card-actions>
            </template>
        </card-base-modal>
    </v-dialog>
    <v-dialog v-model="openOrden" width="850" persistent class="rounded-lg">
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
                    <v-col cols="12" md="6" order="1" order-md="1">
                        <v-btn class="rounded-lg" size="large" @click="closeModal()" text depressed block color="error">
                            Cerrar
                        </v-btn>
                    </v-col>
                    <v-col cols="12" md="6" order="2" order-md="2">
                        <v-btn class="rounded-lg bg-primary" size="large" @click="addCommand" depressed block>
                            Cerrar
                        </v-btn>
                    </v-col>
                </v-card-actions>
            </template>
        </card-base-modal>
    </v-dialog>
    <Alert />
</template>


<script setup>
import accounting from 'accounting';
import { computed, nextTick, onMounted, ref } from 'vue';
import { useRestauratStore } from '@/pinia/restaurant';
import { useRouter } from 'vue-router';
import { useProductStore } from '@/pinia/product';
import CardBaseModal from '@/components/global/CardBaseModal.vue';
import VcBackButton from '@/components/global/BackButton.vue';
import { useDisplay } from 'vuetify';
import { useAlertNormalStore } from '@/pinia/alert.js';


const { mdAndDown } = useDisplay();
const { mobile } = useDisplay();
const alertStore = useAlertNormalStore();


const router = useRouter();

const restaurantStore = useRestauratStore();
const productStore = useProductStore();

const product = ref(null);
const isLoading = ref(false);
const isLoadingProduct = ref(true);
const category = ref(null);
const openDrawer = ref(true);


const headers = [
    { title: 'Platillo', align: 'center', key: 'name' },
    { title: 'Comentario', align: 'center', key: 'note' },
    { title: 'Cantidad', align: 'center', key: 'qty' },
    { title: 'Precio', align: 'center', key: 'price' },
    { title: 'Total', align: 'center', key: 'total' },
];

onMounted(() => {
    if (restaurantStore.selectedTable == null) {
        router.push({ name: 'Restaurante' });
    }

    restaurantStore.listItems({ table_id: restaurantStore.selectedTable.id });

    category.value = 0;
    productStore.listProducts().then(() => {
        isLoadingProduct.value = false;
    }).catch(() => {
        isLoadingProduct.value = false;
    }).finally(() => {
        isLoadingProduct.value = false;
    });
    restaurantStore.listCategories().then(() => {
        isLoading.value = false;
    }).catch(() => {
        isLoading.value = false;
    }).finally(() => {
        isLoading.value = false;
    });
});


const sizeMd = computed(() => {
    return mdAndDown.value ? 'bottom' : 'right';
});

const mdDown = computed(() => {
    return mdAndDown.value;
});

const openDrawerUpdate = computed(() => {
    if (mdAndDown.value) {
        return openDrawer.value = false;
    }
});




const payAccount = () => {
    return alert('Función en desarrollo');
    if (restaurantStore.items.length == 0) {
        alertStore.show = true;
        alertStore.color = "error";
        alertStore.msg = "No has agrgado ninguna comanda";
        alertStore.type = 1;
        return;
    }

    const total = restaurantStore.items.reduce((acc, item) => acc + (item.price * item.qty), 0);

    let params = {
        table_id: restaurantStore.selectedTable.id,
        items: JSON.stringify(restaurantStore.items),
        total: total,
    };

    restaurantStore.payAccount(params).then(() => {
        alertStore.show = true;
        alertStore.color = "success";
        alertStore.msg = "Cuenta pagada con éxito";
        alertStore.type = 0;
        restaurantStore.items = [];
        if (openDrawerUpdate.value) {
            openDrawer.value = true;
        }

        restaurantStore.listItems({ table_id: restaurantStore.selectedTable.id });

    }).catch(() => {
        alertStore.show = true;
        alertStore.color = "error";
        alertStore.msg = "Error al pagar la cuenta";
        alertStore.type = 1;
    });
}

const addAccount = () => {
    if (restaurantStore.items.length == 0) {
        alertStore.show = true;
        alertStore.color = "error";
        alertStore.msg = "No has agrgado ninguna comanda";
        alertStore.type = 1;
        return;
    }

    const total = restaurantStore.items.reduce((acc, item) => acc + (item.price * item.qty), 0);

    let params = {
        table_id: restaurantStore.selectedTable.id,
        items: JSON.stringify(restaurantStore.items),
        total: total,
    };

    restaurantStore.addToAccount(params).then(() => {
        alertStore.show = true;
        alertStore.color = "success";
        alertStore.msg = "Comanda agregada a la cuenta";
        alertStore.type = 0;
        restaurantStore.items = [];
        if (openDrawerUpdate.value) {
            openDrawer.value = true;
        }

        restaurantStore.listItems({ table_id: restaurantStore.selectedTable.id });

    }).catch(() => {
        alertStore.show = true;
        alertStore.color = "error";
        alertStore.msg = "Error al agregar la comanda a la cuenta";
        alertStore.type = 1;
    });
}

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

const openCommand = ref(false);

const closeModal = async () => {
    openOrden.value = false;

    await nextTick(); // o setTimeout(() => { ... }, 100);
    product.value = null;
};

const navigateToHome = () => {
    router.push('/restaurante');
};

const onCategoryChange = (value) => {
    if (value === 0) {
        productStore.listProducts();
    } else {
        productStore.listProductsByCategory(value);
    }
}

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