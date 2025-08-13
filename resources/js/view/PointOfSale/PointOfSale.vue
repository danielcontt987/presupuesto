<template>
    <v-container fluid>
        <v-row v-if="infoCashCut != null">
            <v-col cols="6">
                <p><b class="text-primary">Nombre: </b>{{ infoCashCut.user.name + " " + infoCashCut.user.lastname }}</p>
                <p><b class="text-primary">Caja:</b> {{ infoCashCut.salebox.name }} </p>
            </v-col>
            <v-col cols="6" class="text-right">
                <p class="text-primary"><b>Última cotización:</b></p>
                <p class="text-primary"><b>Cotización del día:</b></p>
                <p class="text-primary"><b>Cotización en espera:</b></p>
                <p class="text-primary"><b>Monto cotizado:</b></p>
            </v-col>
            <v-col cols="4">
                <v-select variant="outlined" label="Clientes" />
            </v-col>
            <v-col cols="8">
                <!-- <v-combobox
                    variant="outlined"
                    :items="productStore.products"
                    item-title="name"
                    v-model="product"
                    label="Productos"
                    @update:model-value="addProduct"
                /> -->

                <v-autocomplete variant="outlined" return-object :items="productStore.products" item-title="name"
                    v-model="product" label="Productos" @update:modelValue="addProduct" v-model:search="search"
                    @keyup.enter="consultProduct(search)" />
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <div class="table-responsive">
                    <v-data-table class="rounded-lg bg-cardColor" :headers="headers" :items="pagedProducts">
                        <template v-slot:item.quantity="{ item }">
                            <v-text-field v-model="item.quantity" outlined dense class="rounded-lg" type="number"
                                variant="outlined" />
                        </template>
                        <template v-slot:item.price="{ item }">
                            <v-text-field v-model="item.price_sale" outlined dense class="rounded-lg" type="number"
                                variant="outlined" />
                        </template>
                        <template v-slot:item.subtotal="{ item }">
                            {{ currency(parseFloat(item.quantity) * parseFloat(item.price_sale)) }}
                        </template>
                        <template v-slot:item.total="{ item }">
                            {{ currency(parseFloat(item.quantity) * parseFloat(item.price_sale)) }}
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-btn icon class="rounded-lg" color="error" flat
                                @click="pointsaleStore.removeProducts(item)">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </template>
                    </v-data-table>
                    <div class="text-center pt-2">
                        <v-pagination v-model="page" :length="pageCount" size="small" color="primary"></v-pagination>
                    </div>
                </div>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" md="7" lg="8">
                <v-row>
                    <v-col cols="6" class="pb-0">
                        <card-grid color="grey" icon="mdi mdi-percent" text="Aplicar descuento" />
                    </v-col>
                    <v-col cols="6" class="pb-0">
                        <card-grid color="fail" icon="mdi-close" text="Cancelar cotización" @click="cancelDialog()" />
                    </v-col>
                    <v-col cols="6">
                        <card-grid color="greenLight" icon="mdi-more" text="Más opciones" />
                    </v-col>
                    <v-col cols="6">
                        <card-grid color="success" icon="mdi mdi-cash-register" text="Cotiazar"
                            @click="createSale($event)" />
                    </v-col>
                </v-row>
            </v-col>
            <!-- <v-col cols="12" md="5" lg="4">
                <card-info-sale :products-count="totalProducts" :subtotal="subtotal" :iva="iva" :total="total" />
            </v-col> -->
            <v-col cols="12" md="5" lg="4">
                <card-info-sale :products-count="totalProducts" :total="total" />
            </v-col>
            <v-col cols="12" style="overflow-y: hidden; !important">
                <dialog-open-box :saleboxes="saleboxStore.saleboxes" v-if="dialogData" />
            </v-col>
        </v-row>
        <Alert />
    </v-container>
</template>

<style>
.v-table>.v-table__wrapper>table>tbody>tr>th,
.v-table>.v-table__wrapper>table>thead>tr>th,
.v-table>.v-table__wrapper>table>tfoot>tr>th {
    white-space: nowrap;
}
</style>

<script setup>
import { ref, onMounted, computed } from 'vue';

import { useProductStore } from '../../pinia/product';
import { usePointsaleStore } from '../../pinia/pointsale';
import { useSaleboxStore } from '../../pinia/salebox';
import { useCashCutStore } from '../../pinia/cashcut';
import { useAlertNormalStore } from '../../pinia/alert';
import CardGrid from '../../components/PointSale/Cards/CardGrid.vue';
import CardInfoSale from '../../components/PointSale/Cards/CardInfoSale.vue';
import DialogOpenBox from '../../components/PointSale/dialogs/DialogOpenBox.vue';
import accounting from 'accounting';

const productStore = useProductStore();
const pointsaleStore = usePointsaleStore();
const saleboxStore = useSaleboxStore();
const cashCutStore = useCashCutStore();
const alertStore = useAlertNormalStore();

onMounted(() => {
    productStore.listProducts();
    saleboxStore.listSaleboxes();
    cashCutStore.listCashcuts().then((res) => {
        if (res.data.cashcuts == null) {
            dialogData.value = true;
        } else {
            infoCashCut.value = res.data.cashcuts;
            dialogData.value = false;

        }
    });
});


const product = ref(null);
const dialogData = ref(false);
const infoCashCut = ref(null);
const search = ref(null);
const isProcessing = ref(false);
const page = ref(1);
const itemsPerPage = ref(5);


const headers = ref(
    [
        { title: 'Conceptos', key: 'name' },
        { title: 'Cantidad', key: 'quantity' },
        { title: 'Precio', key: 'price' },
        { title: 'Subtotal', key: 'subtotal' },
        { title: 'Total', key: 'total' },
        { title: 'Acciones', sortable: false, key: 'actions' },
    ]
)

const addProduct = () => {
    pointsaleStore.addProducts(product.value);
    product.value = null;
}

const currency = (value) => {
    if (value >= 0) return accounting.formatMoney(value);
    else if (!!value) return accounting.formatMoney(Math.abs(value));
    else return accounting.formatMoney(0, "- $ ");
}

const consultProduct = (search) => {
    let params = {
        search: search
    }
    productStore.consultProducts(params);
}

const createSale = () => {
    if (isProcessing.value) return; // Evita duplicación
    isProcessing.value = true;
    if (pointsaleStore.products.length == 0) {
        alertStore.show = true;
        alertStore.color = "error";
        alertStore.msg = "No hay productos en la cotización";
        alertStore.type = 1;
        return;
    }
    let params = {
        products: JSON.stringify(pointsaleStore.products),
        cashcut_id: infoCashCut.value.id,
        user_id: infoCashCut.value.user.id,
        salebox_id: infoCashCut.value.salebox.id,
        total: total.value,
        iva: iva.value,
        subtotal: subtotal.value
    }
    pointsaleStore.storeSale(params).then((response) => {
        window.open('/print-ticket/' + response.data.sale.id, '_blank');
        alertStore.show = true;
        alertStore.color = "success";
        alertStore.msg = "Se ha creado la cotización correctamente";
        alertStore.type = 0;
        isProcessing.value = false;
        pointsaleStore.products = [];
    }).catch((error) => {
        alertStore.show = true;
        alertStore.color = "error";
        alertStore.msg = "Se ha producido un error al crear la cotización";
        alertStore.type = 1;
    })
}

const totalProducts = computed(() => {
    return pointsaleStore.products.length;
});

const total = computed(() => {
    const sum = pointsaleStore.products.reduce((acc, item) => {
        return acc + (parseFloat(item.quantity) * parseFloat(item.price_sale));
    }, 0);
    return Math.round(sum * 100) / 100; // Redondear a dos decimales
});

const iva = computed(() => {
    return total.value * 0.16;
});

const subtotal = computed(() => {
    return total.value - iva.value;
});

const pagedProducts = computed(() => {
    const startIndex = (page.value - 1) * itemsPerPage.value;
    const endIndex = startIndex + itemsPerPage.value;
    return pointsaleStore.products.slice(startIndex, endIndex);
});

// **Cálculo del total de páginas**
const pageCount = computed(() => Math.ceil(pointsaleStore.products.length / itemsPerPage.value));

</script>