<template>
    <v-container fluid>
        <v-row class="mt-3">
            <v-col cols="12" md="10">
                <vc-back-button @backAction="navigateToHome"></vc-back-button>
            </v-col>
            <v-col cols="12" md="2" sm="12" class="text-end">
                <v-btn class="elevation-0 rounded-lg font-weight-bold" color="primary" icon
                    :block="size ? true : false">
                    <v-icon>mdi-reload</v-icon>
                </v-btn>
            </v-col>
        </v-row>
        <!-- <v-row>
            <v-col cols="12" md="6" lg="4">
                <info-card icon="mdi-alert-circle" title="Pedidos pendientes" text="1" color="warning" />
            </v-col>
            <v-col cols="12" md="6" lg="4">
                <info-card icon="mdi-chef-hat" title="En preparación" text="1" color="primary" />
            </v-col>
            <v-col cols="12" md="6" lg="4">
                <info-card icon="mdi-checkbox-marked-circle-outline" title="Listo" text="1" color="success" />
            </v-col>
        </v-row> -->
        <v-row>
            <v-col v-for="(stat, index) in statCards" :key="index" cols="12" md="6" lg="4">
                <v-card class="rounded-lg pa-6" flat>
                    <div class="d-flex align-center justify-space-between">
                        <div>
                            <p :class="`text-subtitle-2 font-weight-medium ${stat.textColor}`">
                                {{ stat.title }}
                            </p>
                            <p :class="`text-h5 font-weight-bold ${stat.textColor}`">
                                {{ getOrdersByStatus(stat.value).value.length }}
                            </p>
                        </div>
                        <div :class="`${stat.color} pa-3 rounded-lg`">
                            <v-icon color="white" size="28">{{ stat.icon }}</v-icon>
                        </div>
                    </div>
                </v-card>
            </v-col>
        </v-row>
        <v-row class="d-flex ga-4" style="overflow-x: auto; flex-wrap: nowrap;" v-if="restaurantStore.statuses">
            <v-col v-for="(column, index) in restaurantStore.statuses" :data-status="column.title" :key="index"
                cols="12" sm="6" md="4">
                <!-- Header de columna -->
                <v-card class="pa-4 mb-4" flat>
                    <div class="d-flex justify-space-between align-center">
                        <span class="font-weight-medium text-body-1">
                            {{ column.title === 'pending' ? 'Pendiente' :
                                column.title === 'in_process' ? 'En preparación' : 'Listo' }}
                        </span>
                        <!-- <v-chip size="small" color="primary" text-color="white">
                            {{ getOrdersByStatus(column.title).value.length }}
                        </v-chip> -->
                    </div>
                </v-card>

                <!-- Draggable -->
                <draggable v-model="columnsData[column.title]" group="tasks" item-key="id"
                    @change="(evt) => handleDragChange(evt, column.title)" class="kanban-tasks d-flex flex-column ga-4">
                    <template #item="{ element }">
                        <v-card class="pa-4 rounded-lg" flat color="white">
                            <!-- Header -->
                            <div class="d-flex justify-space-between align-center mb-2">
                                <span class="font-weight-semibold text-body-1 text-grey-darken-1">
                                    # {{ element.id }}
                                </span>
                                <v-chip size="large" variant="tonal" class="rounded-lg"
                                    :color="getColorByPriority(element.status)" text-color="white">
                                    {{ element.status === 'pending' ? 'Pendiente' :
                                        element.status === 'in_process' ? 'En preparación' : 'Listo' }}
                                </v-chip>
                            </div>

                            <!-- Items -->
                            <div v-for="(item, i) in element.items" :key="i" class="d-flex justify-space-between py-1">
                                <span class="text-body-2">{{ item.qty }}x {{ item.product }}</span>
                                <span class="text-body-2 font-weight-medium">{{ currency(item.price) }}</span>
                            </div>

                            <!-- Footer -->
                            <div class="d-flex justify-space-between align-center mt-2">
                                <span class="text-caption text-grey-darken-2">
                                    <v-chip variant="tonal" class="rounded-lg" color="cyan-accent-4">Mesa {{
                                        element.table
                                    }}</v-chip>
                                </span>
                                <span class="text-body-2 font-weight-bold">
                                    Total: {{ currency(element.total) }}
                                </span>
                            </div>


                            <!-- Acción -->
                            <v-card-actions class="pa-0 mt-3">
                                <v-btn class="rounded-lg" :class="'bg-' + getColorByPriority(element.status)" flat
                                    block>
                                    {{ element.status === 'pending' ? 'Marcar como en preparación' :
                                        element.status === 'in_process' ? 'Marcar listo' : 'Marca como servido' }}
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </template>
                </draggable>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { computed, onMounted, ref, reactive } from 'vue';
import VcBackButton from '@/components/Global/BackButton.vue';
import { useRestauratStore } from '@/pinia/restaurant.js';
const restaurantStore = useRestauratStore();
import draggable from "vuedraggable";
import { useRouter } from 'vue-router';
import { useDisplay } from 'vuetify';
import accounting from "accounting";
const display = useDisplay();

const router = useRouter();

const columnsData = reactive({});
const size = computed(() => !display.mdAndUp.value);


const currency = (value) => accounting.formatMoney(value, "$", 2, ",", ".");

const getColorByPriority = (priority) => {
    switch (priority) {
        case 'pending':
            return 'yellow-darken-2';
        case 'in_process':
            return 'blue-darken-2';
        default:
            return 'success';
    }
};

//method to navigate to home
const navigateToHome = () => {
    router.push({ name: 'Inicio' });
};


const getOrdersByStatus = (status) => computed({
    get() {
        // commandsCook es directamente el array
        return restaurantStore.commandsCook.filter(o => o.status === status);
    },
    set(newValue) {
        // Actualiza el status de cada orden movida
        newValue.forEach(order => {
            order.status = status;
        });

        // Reemplaza las órdenes del store
        restaurantStore.commandsCook = [
            ...restaurantStore.commandsCook.filter(o => o.status !== status),
            ...newValue
        ];
    }
});


onMounted(async () => {
    await restaurantStore.listItemCook();

    restaurantStore.statuses.forEach(status => {
        columnsData[status.title] = restaurantStore.commandsCook.filter(
            o => o.status === status.title
        ) || [];
    });
});

const handleDragChange = async (evt, newStatus) => {
    if (evt.added) {
        const movedOrder = evt.added.element;

        // oldStatus: usa la propiedad status que ya tiene el elemento
        const oldStatus = evt.removed?.element?.status || movedOrder.status;

        // actualizar status a la columna destino
        movedOrder.status = newStatus;

        // actualizar store global
        restaurantStore.commandsCook = restaurantStore.commandsCook.map(o =>
            o.id === movedOrder.id ? movedOrder : o
        );

        // enviar al backend
        try {
            await axios.post('/restaurant/update-order', {
                id: movedOrder.id,
                oldStatus,
                newStatus
            });
            restaurantStore.listItemCook();
            console.log('Order updated:', movedOrder);
        } catch (error) {
            console.error('Error updating order:', error);
        }
    }
};





const updateColumnOrders = async (status) => {
    const updated = columnsData[status] ?? [];

    if (!updated.length) return;


    updated.forEach(order => order.status = status);

    // Actualizar store
    restaurantStore.commandsCook = [
        ...restaurantStore.commandsCook.filter(
            o => !updated.some(u => u.id === o.id)
        ),
        ...updated
    ];

    console.log('Updated orders:', updated);

    // Enviar al backend
    try {
        for (const order of updated) {

            await axios.post('/restaurant/update-order', {
                id: order.id,
                status: order.status,
                items: order.items,
                table: order.table,
                total: order.total
            });
        }
        console.log('Orders updated in DB successfully');
    } catch (error) {
        console.error('Error updating orders in DB', error);
    }
};


const stats = ref({
    pendingOrders: 12,
    preparingOrders: 8,
    readyOrders: 15,
    avgPreparationTime: 20
});

const statCards = ref([
    {
        title: "Pedidos Pendientes",
        value: "pending",
        icon: "mdi-alert-circle",
        color: "bg-yellow-darken-2",
        bgColor: "bg-yellow-lighten-5",
        textColor: "text-yellow-darken-4"
    },
    {
        title: "En Preparación",
        value: "in_process",
        icon: "mdi-chef-hat",
        color: "bg-blue-darken-2",
        bgColor: "bg-blue-lighten-5",
        textColor: "text-blue-darken-4"
    },
    {
        title: "Listos",
        value: "ready",
        icon: "mdi-check-circle",
        color: "bg-green-darken-2",
        bgColor: "bg-green-lighten-5",
        textColor: "text-green-darken-4"
    },
]);

const columns = ref([
    {
        title: "Pendiente",
        tasks: [
            { id: 1, title: "Configurar proyecto", description: "Inicializar repo con Vue + Vuetify", assignee: "Daniel", priority: "Alta" },
            { id: 2, title: "Diseñar UI", description: "Prototipo con Figma", assignee: "Lucía", priority: "Media" },
        ],
    },
    {
        title: "En Preparación",
        tasks: [
            { id: 3, title: "Backend API", description: "Endpoints en Laravel", assignee: "Pedro", priority: "Alta" },
        ],
    },
    {
        title: "Listo",
        tasks: [
            { id: 4, title: "Documentación", description: "Guía de instalación", assignee: "María", priority: "Baja" },
        ],
    },
]);

</script>

<style scoped>
.kanban-column {
    min-width: 280px;
}

.kanban-tasks {
    min-height: 300px;
}
</style>