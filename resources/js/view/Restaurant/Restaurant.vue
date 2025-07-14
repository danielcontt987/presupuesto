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
                    <span>Unir Mesas</span>
                </v-btn>
            </v-col>
            <v-col cols="6" xl="2" lg="2" md="2" class="py-1">
                <v-btn class="mt-0 rounded-lg text-primary py-7 px-1" color="white" depressed block flat>
                    <v-icon start size="30">mdi-shape-square-rounded-plus</v-icon>
                    <span>Mesas</span>
                </v-btn>
            </v-col>
            <v-col cols="12" md="4" class="py-1">
                <v-btn class="mt-0 rounded-lg text-primary py-7 px-1" color="white" depressed block flat>
                    <v-icon start size="30">mdi-shape-square-rounded-plus</v-icon>
                    <span>Meseros</span>
                </v-btn>
            </v-col>
        </v-row>

        <v-row v-if="restaurantStore.tables && restaurantStore.tables.length > 0">
            <table-card v-for="table in restaurantStore.tables" :key="table.id" :table="table" @select="openDrawer" />
        </v-row>
        <!-- Drawer lateral -->
        <v-navigation-drawer v-model="drawer" location="right" temporary width="400" elevation="6">
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

import { onMounted, ref } from 'vue';
import TableCard from '../../components/Restaurant/Tables.vue';
import DialogBox from '../../components/Modal/DialogBox.vue';
import StatusTable from '../../components/Restaurant/StatusTable.vue';
import { useRestauratStore } from '../../pinia/restaurant';
import { useRouter } from 'vue-router';
const router = useRouter();

const restaurantStore = useRestauratStore();

onMounted(() => {
    restaurantStore.listTables();
});


const saleItems = [];
const selectedTable = ref(null);
const drawer = ref(false);

const openDrawer = (table) => {
    restaurantStore.listItems({ table_id: table.id });

    if (restaurantStore.items.length > 0) {
        selectedTable.value = table;
        drawer.value = true;
    } else {
        restaurantStore.setTable(table);
        router.push({ name: 'Seleccionar' });
    }
};

</script>

<style scoped>
.shadow {
    box-shadow: 0px 0px 16px #192a6733;
}
</style>