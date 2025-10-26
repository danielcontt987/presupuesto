<template>
    <v-container fluid>
        <v-row v-if="cashCutStore.infoCashCut != null">
            <v-col cols="6">
                <p><b class="text-primary">Nombre: </b>{{ cashCutStore.infoCashCut.user.name + " " +
                    cashCutStore.infoCashCut.user.lastname }}</p>
                <p><b class="text-primary">Caja:</b> {{ cashCutStore.infoCashCut.salebox.name }} </p>
            </v-col>
            <v-col cols="6" class="text-right">
                <p class="text-primary"><b>Última venta:</b></p>
                <p class="text-primary"><b>Venta del día:</b></p>
                <p class="text-primary"><b>Venta en espera:</b></p>
                <p class="text-primary"><b>Monto vendido:</b></p>
            </v-col>
            <v-col cols="4">
                <v-select variant="outlined" label="Clientes" />
            </v-col>
            <v-col cols="8">
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
                        <card-grid color="fail" icon="mdi-close" text="Cancelar venta" @click="cancelDialog()" />
                    </v-col>
                    <v-col cols="6">
                        <card-grid color="greenLight" icon="mdi-more" text="Más opciones" />
                    </v-col>
                    <v-col cols="6">
                        <card-grid color="success" icon="mdi mdi-cash-register" text="Pagar"
                            @click="createSale($event)" />
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" md="5" lg="4">
                <card-info-sale :products-count="totalProducts" :total="total" />
            </v-col>
            <v-col cols="12" style="overflow-y: hidden; !important">
                <dialog-open-box :saleboxes="saleboxStore.saleboxes" v-if="dialogData" />
            </v-col>

        </v-row>
        <Alert />
        <v-dialog v-if="openDialogPay" v-model="openDialogPay" fullscreen persistent
            transition="dialog-bottom-transition">
            <v-card>
                <v-card-title class="bg-primary justify-center">
                    <v-row class="mt-3 mb-3">
                        <v-col cols="8" md="10">
                            <h4 class="white--text">Total a pagar</h4>
                        </v-col>
                        <v-col cols="4" md="2">
                            <v-btn block color="white" outlined large class="rounded-lg" @click="closeDialog">
                                Cerrar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text>
                    <v-row class="mt-3 mb-3">
                        <v-col cols="12" md="6">
                            <v-card class="bg-cardColor rounded-lg shadow" flat>
                                <v-card-title class="text-center justify-center">
                                    <v-chip flat class="bg-primary white--text rounded-lg px-3 py-2">PAGO DE
                                        CONTADO</v-chip>
                                </v-card-title>
                                <v-card-text>
                                    <h4 class="white--text text-center my-4">Metodos de pago disponibles</h4>
                                    <v-form ref="form" v-model="valid">
                                        <v-row>
                                            <v-col cols="12">
                                                <span class="text-greySpan my-2">Cantidad con efectivo</span>
                                                <v-text-field prepend-inner-icon="mdi-cash" prefix="$" v-model="cash"
                                                    label="Catidad en efectivo" hide-details single-line
                                                    variant="outlined" color="primary">
                                                    <template v-slot:append-inner>
                                                        <v-tooltip bottom>
                                                            <template v-slot:activator="{ props }">
                                                                <v-icon v-bind="props" color="primary">mdi-send</v-icon>
                                                            </template>
                                                            <span>Ingresar</span>
                                                        </v-tooltip>
                                                    </template>
                                                </v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <span class="text-greySpan my-2">Cantidad con transferencia</span>
                                                <v-text-field prepend-inner-icon="mdi-cash" prefix="$"
                                                    v-model="transfer" label="Catidad en transferencia" hide-details
                                                    single-line variant="outlined" color="primary">
                                                    <template v-slot:append-inner>
                                                        <v-tooltip bottom>
                                                            <template v-slot:activator="{ props }">
                                                                <v-icon v-bind="props" color="primary">mdi-send</v-icon>
                                                            </template>
                                                            <span>Ingresar</span>
                                                        </v-tooltip>
                                                    </template>
                                                </v-text-field>
                                            </v-col>
                                            <v-col cols="12">
                                                <span class="text-greySpan my-2">Cantidad con tarjeta</span>
                                                <v-text-field prepend-inner-icon="mdi-cash" prefix="$" v-model="card"
                                                    label="Catidad en tarjeta" hide-details single-line
                                                    variant="outlined" color="primary">
                                                    <template v-slot:append-inner>
                                                        <v-tooltip bottom>
                                                            <template v-slot:activator="{ props }">
                                                                <v-icon v-bind="props" color="primary">mdi-send</v-icon>
                                                            </template>
                                                            <span>Ingresar</span>
                                                        </v-tooltip>
                                                    </template>
                                                </v-text-field>
                                            </v-col>
                                        </v-row>
                                    </v-form>
                                </v-card-text>
                            </v-card>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-card class="bg-cardColor rounded-lg shadow" flat>
                                <v-card-title class="text-center justify-center">
                                    <v-alert type="primary" icon="mdi-check" variant="outlined" class="rounded-lg">
                                        <h2>Total: {{ currency(parseFloat(total)) }}</h2>
                                    </v-alert>
                                </v-card-title>
                                <v-card-text>
                                    <v-row class="my-5">
                                        <v-col cols="6">
                                            <h2 class="text-greySpan">PAGADO</h2>
                                        </v-col>
                                        <v-col cols="6" class="text-right">
                                            <h2 class="text-success">{{ currency(pagado) }}</h2>
                                        </v-col>

                                        <v-col cols="6">
                                            <h2 class="text-greySpan">FALTANTE</h2>
                                        </v-col>
                                        <v-col cols="6" class="text-right">
                                            <h2 class="text-fail">{{ currency(faltante) }}</h2>
                                        </v-col>
                                        <v-col cols="6">
                                            <h2 class="text-greySpan">CAMBIO</h2>
                                        </v-col>
                                        <v-col cols="6" class="text-right">
                                            <h2 class="text-primary">{{ currency(cambio) }}</h2>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-textarea v-model="pointsaleStore.observation" label="Observación"
                                                hide-details single-line variant="outlined"
                                                color="primary"></v-textarea>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                                <v-card-actions class="justify-center">
                                    <v-btn :disabled="!validPay" block
                                        class="bg-primary text-white rounded-lg block py-6">PAGAR</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
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

import { useProductStore } from '@/pinia/product.js';
import { usePointsaleStore } from '@/pinia/pointsale.js';
import { useSaleboxStore } from '@/pinia/salebox.js';
import { useCashCutStore } from '@/pinia/cashcut.js';
import { useAlertNormalStore } from '@/pinia/alert.js';
import { useBusinessStore } from '@/pinia/business.js';

import CardGrid from '@/components/PointSale/Cards/CardGrid.vue';
import CardInfoSale from '@/components/PointSale/Cards/CardInfoSale.vue';
import DialogOpenBox from '@/components/PointSale/dialogs/DialogOpenBox.vue';
import currency from '@/helper/currency.js';

import accounting from 'accounting';

const productStore = useProductStore();
const pointsaleStore = usePointsaleStore();
const saleboxStore = useSaleboxStore();
const cashCutStore = useCashCutStore();
const alertStore = useAlertNormalStore();
const businessStore = useBusinessStore();

onMounted(async () => {
    pointsaleStore.clearSale();
    let params = {
        is_service: false
    };
    await Promise.all([
        productStore.listProducts(params),
        saleboxStore.listSaleboxes(),
        businessStore.listBusiness(),
        cashCutStore.listCashcuts()
    ]);
    if (!cashCutStore.infoCashCut) {
        dialogData.value = true;
    } else {
        dialogData.value = false;
    }
});



const product = ref(null);
const search = ref(null);
const page = ref(1);
const itemsPerPage = ref(5);
const cash = ref(0);
const transfer = ref(0);
const card = ref(0);
const dialogData = ref(false);
const openDialogPay = ref(false);
const valid = ref(false);


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

const closeDialog = () => {
    openDialogPay.value = false;
}

const consultProduct = (search) => {
    let params = {
        search: search
    }
    productStore.consultProducts(params);
}

const createSale = () => {
    if (pointsaleStore.products.length == 0) {
        alertStore.show = true;
        alertStore.color = "error";
        alertStore.msg = "No hay productos en la venta";
        alertStore.type = 1;
        return;
    }
    openDialogPay.value = true;
}


const totalProducts = computed(() => {
    return pointsaleStore.products.length;
});

const pagado = computed(() => {
    return (Number(cash.value) || 0) + (Number(transfer.value) || 0) + (Number(card.value) || 0)
})

const faltante = computed(() => {
    const diff = Number(total.value) - pagado.value
    return diff > 0 ? diff : 0
})

const cambio = computed(() => {
    const diff = pagado.value - Number(total.value)
    return diff > 0 ? diff : 0
})

const validPay = computed(() => {
    return pagado.value >= Number(total.value)
})

const total = computed(() => {
    const sum = pointsaleStore.products.reduce((acc, item) => {
        return acc + (parseFloat(item.quantity) * parseFloat(item.price_sale));
    }, 0);
    return Math.round(sum * 100) / 100;
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

<style scoped>
.shadow {
    box-shadow: 0px 0px 25px #192a6733;
}
</style>