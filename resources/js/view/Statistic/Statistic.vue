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
                                    Filtros
                                </v-chip>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text class="mt-3">
                        <v-row>
                            <v-col cols="12" md="5">
                                <v-text-field variant="outlined" v-model="startDate" label="Fecha de inicio"
                                    prepend-inner="mdi-calendar" @click.append="show('start')" clearable />
                            </v-col>
                            <v-col cols="12" md="5">
                                <v-text-field variant="outlined" v-model="endDate" label="Fecha de final"
                                    @click.append="show('end')" clearable />
                            </v-col>
                            <v-col cols="12" md="2">
                                <v-btn @click="filterDate" size="x-large" block color="primary" flat>
                                    Filtrar
                                </v-btn>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field variant="outlined" v-model="search" label="Buscar" :clearable="true" />
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
                                    Cotizaciones
                                </v-chip>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text class="mt-3">
                        <v-row>
                            <v-col cols="12">
                                <v-data-table :headers="headers" :items="FilterData">
                                    <template v-slot:item.status="{ item }">
                                        <v-chip variant="tonal" color="greenLight" class="rounded-lg"
                                            v-if="item.status == 'Finalizado'">
                                            <b>{{ "Activo" }}</b>
                                        </v-chip>
                                        <v-chip variant="tonal" color="fail" class="rounded-lg" v-else>
                                            <b>{{ "Cancelada" }}</b>
                                        </v-chip>
                                    </template>
                                    <template v-slot:item.folio="{ item }">

                                        <v-chip variant="tonal" color="fail" class="rounded-lg">
                                            {{ item.folio }}
                                        </v-chip>
                                    </template>
                                    <template v-slot:item.total="{ item }">
                                        {{ currency(item.total) }}
                                    </template>
                                    <template v-slot:item.client="{ item }">
                                        {{ item.client ? item.client.name + ' ' + item.client.lastname : 'Sin cliente'
                                        }}
                                    </template>
                                    <template v-slot:item.ticket="{ item }">
                                        <v-chip variant="tonal" color="titleCard" class="rounded-lg">
                                            {{ "Ticket" }}
                                        </v-chip>
                                    </template>
                                    <template v-slot:item.actions="{ item }">
                                        <!-- Ver detalle -->
                                        <v-tooltip location="bottom">
                                            <template #activator="{ props }">
                                                <v-btn v-bind="props" @click="goToDetail(item)" icon class="rounded-lg"
                                                    flat size="small" color="primary" :class="xs ? '' : 'mr-2'">
                                                    <v-icon>mdi-eye</v-icon>
                                                </v-btn>
                                            </template>
                                            Ver detalle
                                        </v-tooltip>

                                        <!-- Imprimir nuevamente -->
                                        <v-tooltip location="bottom">
                                            <template #activator="{ props }">
                                                <v-btn v-bind="props" @click="printTicket(item)" icon class="rounded-lg"
                                                    flat size="small" color="greenLight" :class="xs ? '' : 'mr-2'">
                                                    <v-icon>mdi-printer</v-icon>
                                                </v-btn>
                                            </template>
                                            Imprimir nuevamente
                                        </v-tooltip>

                                        <!-- Cancelar -->
                                        <v-tooltip location="bottom">
                                            <template #activator="{ props }">
                                                <v-btn v-bind="props" @click="deleteClient(item)" icon
                                                    class="rounded-lg" flat size="small" color="fail">
                                                    <v-icon>mdi-cancel</v-icon>
                                                </v-btn>
                                            </template>
                                            Cancelar
                                        </v-tooltip>
                                    </template>
                                </v-data-table>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="6" lg="4">
                <info-card icon="mdi-pound" title="Total de cotizaciones" :text="total" color="greenLight" />
            </v-col>
            <v-col cols="12" md="6" lg="4">
                <info-card icon="mdi-arrow-up-bold" title="Folio de cotización más reciente"
                    :text="sales.length > 0 ? last.folio : 'No hay cotizaciones'" color="warning" />
            </v-col>
            <v-col cols="12" md="6" lg="4">
                <info-card icon="mdi-currency-usd" title="Total " :text="totalAmount" color="success" isCurrency />
            </v-col>

        </v-row>

        <v-dialog v-model="showDatePicker" width="400" transition="dialog-bottom-transition" persistent>
            <v-card flat class="ma-2 rounded-card" style="overflow: hidden !important">
                <v-row>
                    <v-date-picker class="ma-2 pa-0 text-center" v-model="tempDate" width="800" :max="endDate || today"
                        :min="startDate > endDate" color="primary"></v-date-picker>
                </v-row>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" class="rounded-lg" x-large text depressed block @click="acceptDate">
                        Aceptar
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script setup>
//Imports
import { computed, onMounted, ref } from "vue";
import moment from "moment";
import { useStatisticStore } from "@/pinia/statistic.js";
import { useDisplay } from "vuetify";
import { useRouter } from "vue-router";
import accounting from "accounting";
import InfoCard from "@/components/Statistic/InfoCard.vue";
import VcBackButton from "@/components/global/BackButton.vue";
const statisticStore = useStatisticStore();
const display = useDisplay();
const router = useRouter();


const xs = computed(() => display.xs.value);

//Mounted

onMounted(() => {
    startDate.value = moment().format("YYYY-MM-DD");
    endDate.value = moment().format("YYYY-MM-DD");
})

//Variables
const search = ref('');
const showDatePicker = ref(false);
const dateType = ref('start');

const startDate = ref(null);
const endDate = ref(null);
const tempDate = ref(null);
const total = ref(0);
const totalAmount = ref(0);
const last = ref(null);
const sales = ref([]);

//Methods

const acceptDate = () => {
    if (dateType.value === 'start') {
        startDate.value = moment(tempDate.value).format("YYYY-MM-DD");
    } else {
        endDate.value = moment(tempDate.value).format("YYYY-MM-DD");
    }
    showDatePicker.value = false;
};

const navigateToHome = () => {
    router.push("/inicio");
};
const show = (type) => {
    dateType.value = type;
    if (dateType.value == "start") {
        startDate.value
    }
    if (dateType.value == "end") {
        endDate.value
    }
    showDatePicker.value = true;
};

const goToDetail = (item) => {
    if (!item) {
        router.push({ name: 'Estadísticas' })
        return;
    };

    console.log();

    statisticStore.setSaleId(item.id);
    statisticStore.getSalesDetails(item.id);
    router.push({ name: 'Detalle de cotización' });
};


const printTicket = (item) => {
    window.open(`/print-ticket/${item.id}`, '_blank');
};
// Computed
const today = computed(() => {
    return moment().format('YYYY-MM-DD');
});

const currency = (value) => {
    return accounting.formatMoney(value, "$", 2, ",", ".");
};
const filterDate = () => {
    if (startDate.value && endDate.value) {

        let params = {
            date1: startDate.value,
            date2: endDate.value
        };
        return statisticStore.consultSale(params).then((response) => {
            sales.value = response.data.sales;
            total.value = response.data.total;
            totalAmount.value = response.data.totalAmount;
            last.value = response.data.last;

        }).catch((error) => {
            console.error(error);
        });
    }
};
const FilterData = computed(() => {
    return sales.value.filter((event) => {
        const folio = event.folio ? event.folio.toLowerCase() : '';
        const searchText = search.value ? search.value.toLowerCase() : '';
        return folio.includes(searchText);
    });
});

const size = computed(() => {
    if (display.mdAndUp.value) {
        return false;
    } else {
        return true;
    }
})

const headers = [
    { title: 'Folio', align: 'center', key: 'folio' },
    { title: 'Impresión', align: 'center', key: 'ticket' },
    { title: 'Cliente', align: 'center', key: 'client' },
    { title: 'Total', align: 'center', key: 'total' },
    { title: 'Estatus', align: 'center', key: 'status' },
    { title: 'Fecha de cotización', align: 'center', key: 'saledate' },
    { title: 'Acciones', align: 'center', key: 'actions' },
];

</script>

<style>
.v-card {
    border-radius: 12px !important;
}
</style>