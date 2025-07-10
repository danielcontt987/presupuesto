<template>
    <v-row no-gutters class="py-4">
        <v-col cols="12">
            <v-row class="bg-white">
                <v-col class="12">
                    <div class="scroll-container">
                        <v-row align="center" justify="center">
                            <v-col cols="2" class="text-center">
                                <dialog-box />
                            </v-col>
                            <v-col cols="2" class="text-center">
                                <status-table />
                            </v-col>
                            <v-col cols="2" class="text-center">
                                <dialog-box />
                            </v-col>
                            <v-col cols="2" class="text-center">
                                <dialog-box />
                            </v-col>
                            <v-col cols="2" class="text-center">
                                <dialog-box />
                            </v-col>
                        </v-row>
                    </div>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
    <v-container fluid>
        <v-row class="my-2">
            <v-col cols="6" xl="2" lg="2" md="2" class="py-1">
                <v-btn class="mt-0 rounded-lg text-primary py-7 px-1" color="white" depressed block flat>
                    <v-icon start size="30">mdi-motorbike</v-icon>
                    <span>Delivery</span>
                </v-btn>
            </v-col>
            <v-col cols="6" xl="2" lg="2" md="2" class="py-1">
                <v-btn class="mt-0 rounded-lg text-primary py-7 px-1" color="white" depressed block flat>
                    <v-icon start size="30">mdi-home-circle-outline</v-icon>
                    <span>Recoge Aquí</span>
                </v-btn>
            </v-col>
            <v-col cols="6" xl="2" lg="2" md="2" class="py-1">
                <v-btn class="mt-0 rounded-lg text-primary py-7 px-1" color="white" depressed block flat>
                    <v-icon start size="30">mdi-shape-square-rounded-plus</v-icon>
                    <span>Mesas</span>
                </v-btn>
            </v-col>
            <v-col cols="6" xl="2" lg="2" md="2" class="py-1">
                <v-btn class="mt-0 rounded-lg text-primary py-7 px-1" color="white" depressed block flat>
                    <v-icon start size="30">mdi-shape-square-rounded-plus</v-icon>
                    <span>Mesas</span>
                </v-btn>
            </v-col>
            <v-col cols="6" md="4" class="py-1">
                <v-btn class="mt-0 rounded-lg text-primary py-7 px-1" color="white" depressed block flat>
                    <v-icon start size="30">mdi-shape-square-rounded-plus</v-icon>
                    <span>Meseros</span>
                </v-btn>
            </v-col>
        </v-row>
        <v-row>
            <v-col v-for="(table, index) in tables" :key="index" cols="12" md="3">
                <TableCard :table="table" @select="openDrawer" />
            </v-col>
        </v-row>
        <!-- Drawer lateral -->
        <v-navigation-drawer v-model="drawer" location="right" temporary width="400" elevation="6">
            <!-- <v-list color="transparent">
                <v-list-item prepend-icon="mdi-view-dashboard" title="Dashboard"></v-list-item>
                <v-list-item prepend-icon="mdi-account-box" title="Account"></v-list-item>
                <v-list-item prepend-icon="mdi-gavel" title="Admin"></v-list-item>
            </v-list>

            <template v-slot:append>
                <div class="pa-2">
                    <v-btn block>
                        Logout
                    </v-btn>
                </div>
            </template> -->
            <v-row v-if="saleItems.length == 0" class="mt-10">
                <v-col cols="12" class="text-center">
                    <v-icon color="background" size="200">mdi-table</v-icon>
                    <p class="primary-text text-center">
                        <b>No has seleccionado una mesa</b>
                    </p>
                    <p class="primary-text text-center">
                        Para interactuar con pedidos y totales, selecciona la
                        mesa que desees revisar
                    </p>
                </v-col>
            </v-row>
        </v-navigation-drawer>
    </v-container>
</template>

<script setup>

import { ref } from 'vue';
import { useRouter } from 'vue-router';
import TableCard from '../../components/Restaurant/Tables.vue';
import DialogBox from '../../components/Modal/DialogBox.vue';
import StatusTable from '../../components/Restaurant/StatusTable.vue';

const router = useRouter();

const tables = [
    {
        number: 1,
        status: 'occupied',
        capacity: 4,
        orders: []
    },
    {
        id: '2',
        number: 2,
        capacity: 2,
        status: 'available',
        orders: []
    },
    {
        id: '3',
        number: 2,
        capacity: 1,
        status: 'reserved',
        orders: []
    },
    {
        id: '4',
        number: 2,
        capacity: 1,
        status: 'reserved',
        orders: []
    },
];
const saleItems = [];
const selectedTable = ref(null);
const drawer = ref(false);

const openDrawer = (table) => {
    selectedTable.value = table;
    drawer.value = true;
};

</script>

<style scoped>
.shadow {
    box-shadow: 0px 0px 16px #192a6733;
}
</style>