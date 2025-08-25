<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" md="10">
                <vc-back-button @backAction="navigateToHome"></vc-back-button>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-card class="rounded-lg" flat>
                    <v-card-title>
                        <v-row>
                            <v-col cols="12" md="9">
                                <v-chip color="background" :style="size
                                    ? 'width: 100%; text-align: center'
                                    : ''
                                    " :class="size ? 'd-flex justify-center' : ''"
                                    class="text-primary rounded-lg pa-5 font-weight-bold text-uppercase" label>
                                    Detalle de la venta
                                </v-chip>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text class="mt-3">
                        <v-row class="mt-3">
                            <v-col md="3" cols="12">
                                <p class="text-primary">CAJA</p>
                                <v-chip variant="tonal" color="greenLight" class="rounded-lg mt-2"
                                    v-if="statisticStore && statisticStore.datailSale && statisticStore.datailSale.salebox">
                                    {{ statisticStore.datailSale.salebox.name }}
                                </v-chip>
                            </v-col>
                            <v-col md="3" cols="12">
                                <p class="text-primary">FOLIO</p>
                                <v-chip variant="tonal" color="fail" class="rounded-lg mt-2"
                                    v-if="statisticStore && statisticStore.datailSale">
                                    {{ statisticStore.datailSale.folio }}
                                </v-chip>
                            </v-col>
                            <v-col md="3" cols="12">
                                <p class="text-primary">USUARIO</p>
                                <h3 class="font-weight-bold text-grey_dark mt-2" v-if="statisticStore">{{
                                    'Jose Daniel Contreras Perez'
                                    }}</h3>
                            </v-col>
                            <v-col md="3" cols="12">
                                <p class="text-primary">CLIENTE</p>
                                <h3 class="font-weight-bold text-grey_dark mt-2" v-if="statisticStore">{{
                                    "Jose Damina Lopez Perez"
                                    }}</h3>
                            </v-col>
                            <v-col md="3" cols="12">
                                <p class="text-primary">FECHA DE COTIZACIÓN</p>
                                <h3 class="font-weight-bold text-grey_dark mt-2"
                                    v-if="statisticStore && statisticStore.datailSale">{{
                                        statisticStore.datailSale.saledate
                                    }}</h3>
                            </v-col>
                            <v-col md="3" cols="12">
                                <p class="text-primary">SUBTOTAL</p>
                                <h3 class="font-weight-bold text-grey_dark mt-2"
                                    v-if="statisticStore && statisticStore.datailSale">{{
                                        currency(statisticStore.datailSale.subtotal) }}</h3>
                            </v-col>
                            <v-col md="3" cols="12">
                                <p class="text-primary">IVA</p>
                                <h3 class="font-weight-bold text-grey_dark mt-2"
                                    v-if="statisticStore && statisticStore.datailSale">{{
                                        currency(statisticStore.datailSale.iva) }}</h3>
                            </v-col>
                            <v-col md="3" cols="12">
                                <p class="text-primary">TOTAL</p>
                                <h3 class="font-weight-bold text-grey_dark mt-2"
                                    v-if="statisticStore && statisticStore.datailSale">{{
                                        currency(statisticStore.datailSale.total) }}</h3>
                            </v-col>
                            <v-col md="3" cols="12">
                                <p class="text-primary">DOCUMENTO EXPEDIDO</p>
                                <h3 class="font-weight-bold text-grey_dark mt-2"
                                    v-if="statisticStore && statisticStore.datailSale">{{
                                        'COTIZACIÓN' }}</h3>
                            </v-col>
                            <v-col md="3" cols="12">
                                <p class="text-primary">ESTATUS DE COTIZACIÓN</p>
                                <!-- <h3 class="font-weight-bold text-grey_dark mt-2" v-if="statisticStore">{{
                                    'Sin descuentos' }}</h3> -->
                                <v-chip variant="tonal" color="success" class="rounded-lg mt-2" v-if="statisticStore">
                                    {{ "FINALIZADA" }}
                                </v-chip>
                            </v-col>
                            <v-col md="3" cols="12">
                                <p class="text-primary">ESTATUS DE PAGO</p>
                                <h3 class="font-weight-bold text-grey_dark mt-2" v-if="statisticStore">{{
                                    'Sin descuentos' }}</h3>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12">
                <v-card class="rounded-lg" flat>
                    <v-card-title>
                        <v-row>
                            <v-col cols="12" md="9">
                                <v-chip color="background" :style="size
                                    ? 'width: 100%; text-align: center'
                                    : ''
                                    " :class="size ? 'd-flex justify-center' : ''"
                                    class="text-primary rounded-lg pa-5 font-weight-bold text-uppercase" label>
                                    Metodos de pago
                                </v-chip>
                            </v-col>
                        </v-row>
                    </v-card-title>
                </v-card>
                <v-row class="mt-3">
                    <v-col cols="12" md="3">
                        <info-card title="TARJETA"
                            :text="statisticStore && statisticStore.datailSale ? statisticStore.datailSale.card : 0"
                            color="primary" :showAvatar="false" isCurrency />
                    </v-col>
                    <v-col cols="12" md="3">
                        <info-card icon="mdi-arrow-up-bold" title="EFECTIVO"
                            :text="statisticStore && statisticStore.datailSale ? statisticStore.datailSale.cash : 0"
                            color="success" :showAvatar="false" isCurrency />
                    </v-col>
                    <v-col cols="12" md="3">
                        <info-card icon="mdi-arrow-up-bold" title="TRANSFERENCIA"
                            :text="statisticStore && statisticStore.datailSale ? statisticStore.datailSale.transfer : 0"
                            color="primary" :showAvatar="false" isCurrency />
                    </v-col>
                    <v-col cols="12" md="3">
                        <info-card icon="mdi-arrow-up-bold" title="CHEQUE"
                            :text="statisticStore && statisticStore.datailSale ? statisticStore.datailSale.check : 0"
                            color="primary" :showAvatar="false" isCurrency />
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12">
                <v-card class="rounded-lg" flat>
                    <v-card-title>
                        <v-row>
                            <v-col cols="12" md="9">
                                <v-chip color="background" :style="size
                                    ? 'width: 100%; text-align: center'
                                    : ''
                                    " :class="size ? 'd-flex justify-center' : ''"
                                    class="text-primary rounded-lg pa-5 font-weight-bold text-uppercase" label>
                                    Artículos cotizados
                                </v-chip>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text class="mt-3" v-if="statisticStore && statisticStore.datailSale">
                        <v-data-table :headers="headers" :items="statisticStore.datailSale.details">
                            <template #item.total="{ item }">
                                {{ currency(item.total) }}
                            </template>
                            <template #item.priceUnit="{ item }">
                                {{ currency(item.total / (item.quantity)) }}
                            </template>
                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import VcBackButton from '../../components/global/BackButton.vue';
import { useDisplay } from 'vuetify';
import { useRouter } from 'vue-router';
import { computed } from 'vue';
import { useStatisticStore } from '../../pinia/statistic';
import accounting from 'accounting';
import InfoCard from '../../components/Statistic/InfoCard.vue';


// variables
const headers = [
    { title: 'Producto', align: 'center', key: 'product.name' },
    { title: 'Cantidad', align: 'center', key: 'quantity' },
    { title: 'Precio unitario', align: 'center', key: 'priceUnit' },
    { title: 'Total', align: 'center', key: 'total' },
];

//composables
const display = useDisplay();
const router = useRouter();
const statisticStore = useStatisticStore();



//computed
const size = computed(() => {
    if (display.mdAndUp.value) {
        return false;
    } else {
        return true;
    }
});

const currency = (value) => {
    return accounting.formatMoney(value, "$", 2, ",", ".");
};

//methods
const navigateToHome = () => {
    router.push({ name: 'Estadísticas' });
}
</script>