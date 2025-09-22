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
    // 1️⃣ Cargar órdenes iniciales
    await restaurantStore.listItemCook();

    // Inicializar columnas locales
    restaurantStore.statuses.forEach(status => {
        columnsData[status.title] = restaurantStore.commandsCook.filter(
            o => o.status === status.title
        ) || [];
    });

    // 2️⃣ Listener de Echo (solo una vez)
    if (window.Echo) {
        window.Echo.channel('cook-items')
            .listen('.OrderStatusChangeEvent', (e) => {

                // Actualizar store global
                restaurantStore.commandsCook = e.items;

                // Actualizar columnas locales
                restaurantStore.statuses.forEach(status => {
                    const filtered = restaurantStore.commandsCook.filter(o => o.status === status.title);
                    if (columnsData[status.title]) {
                        columnsData[status.title].splice(0, columnsData[status.title].length, ...filtered);
                    } else {
                        columnsData[status.title] = filtered;
                    }
                });
            });
    }
});


const handleDragChange = async (evt, newStatus) => {
    if (!evt.added) return;

    const movedOrder = evt.added.element;
    const oldStatus = evt.removed?.element?.status || movedOrder.status;

    // Actualizar status localmente
    movedOrder.status = newStatus;

    // Actualizar store global
    restaurantStore.commandsCook = restaurantStore.commandsCook.map(o =>
        o.id === movedOrder.id ? movedOrder : o
    );

    // Actualizar columnas locales
    restaurantStore.statuses.forEach(status => {
        const filtered = restaurantStore.commandsCook.filter(o => o.status === status.title) || [];
        if (columnsData[status.title]) {
            columnsData[status.title].splice(0, columnsData[status.title].length, ...filtered);
        } else {
            columnsData[status.title] = filtered;
        }
    });

    // Enviar cambio al backend
    try {
        await axios.post('/restaurant/update-order', {
            id: movedOrder.id,
            oldStatus,
            newStatus
        });
    } catch (error) {
        console.error('Error updating order in backend:', error);
    }
};

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