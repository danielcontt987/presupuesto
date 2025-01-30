<template>
    <v-container fluid>
        <v-row v-if="infoCashCut != null">
            <v-col cols="6">
               <p><b class="text-primary">Nombre: </b>{{infoCashCut.user.name + " " + infoCashCut.user.lastname}}</p>
               <p><b class="text-primary">Caja:</b> {{infoCashCut.salebox.name}} </p>
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
                        {{ currency(parseFloat(item.quantity) * parseFloat(item.price_sale)) }}
                    </template>
                    <template v-slot:item.total="{ item }">
                        {{  currency(parseFloat(item.quantity) * parseFloat(item.price_sale))}}
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-btn
                            icon
                            class="rounded-lg"
                            color="error"
                            flat
                            @click="pointsaleStore.removeProducts(item)"
                            
                        >
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </template>
            </v-data-table>
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
                        <card-grid color="success" icon="mdi mdi-cash-register" text="Cobrar venta"
                             />
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" md="5" lg="4">
                <card-info-sale :products-count="totalProducts" :subtotal="subtotal" :iva="iva" :total="total" />
            </v-col>
            <v-col cols="12" style="overflow-y: hidden; !important">
                <dialog-open-box :saleboxes="saleboxStore.saleboxes" v-if="dialogData"/>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';

import {useProductStore} from '../../pinia/product';
import {usePointsaleStore} from '../../pinia/pointsale';
import { useSaleboxStore } from '../../pinia/salebox';
import { useCashCutStore } from '../../pinia/cashcut';
import CardGrid from '../../components/PointSale/Cards/CardGrid.vue';
import CardInfoSale from '../../components/PointSale/Cards/CardInfoSale.vue';
import DialogOpenBox from '../../components/PointSale/dialogs/DialogOpenBox.vue';
import accounting from 'accounting';

const productStore = useProductStore();
const pointsaleStore = usePointsaleStore();
const saleboxStore = useSaleboxStore();
const cashCutStore = useCashCutStore();

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

const totalProducts = computed(() => {
    return pointsaleStore.products.length;
});

const total = computed(() => {
    return pointsaleStore.products.reduce((acc, item) => {
        return acc + (parseFloat(item.quantity) * parseFloat(item.price_sale));
    }, 0);
});

const iva = computed(() => {
    return total.value * 0.16;
});

const subtotal = computed(() => {
    return total.value - iva.value;
});
</script>