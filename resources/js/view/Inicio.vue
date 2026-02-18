<template>
    <v-container fluid>

        <!-- BIENVENIDA -->
        <v-row>
            <v-col>
                <h2 class="font-weight-bold">👋 Bienvenido, Daniel</h2>
                <p class="text-grey">Resumen general del sistema</p>
            </v-col>
        </v-row>

        <!-- KPI CARDS -->
        <v-row>
            <v-col cols="12" md="4" v-for="card in stats" :key="card.title">
                <info-card :icon="card.icon" :title="card.title" :text="card.value" :color="card.color" />
            </v-col>
        </v-row>

        <!-- GRAFICAS -->
        <v-row>
            <v-col cols="12" md="7">
                <v-card elevation="0" style="margin-bottom: 0px !important" class="rounded-lg">
                    <v-card-title>
                        <v-row class="mx-0">
                            <v-col cols="12">
                                <v-chip color="background" class="text-primary rounded-lg pa-5 font-weight-bold" label
                                    width="100%">
                                    Ventas últimos 7 días
                                </v-chip>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text>
                        <canvas id="salesChart"></canvas>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" md="5">
                <!-- <v-card rounded="xl" class="pa-4">
                    <h3>🔥 Productos más vendidos</h3>
                   
                </v-card> -->
                <v-card elevation="0" style="margin-bottom: 0px !important" class="rounded-lg">
                    <v-card-title>
                        <v-row class="mx-0">
                            <v-col cols="12">
                                <v-chip color="background" class="text-primary rounded-lg pa-5 font-weight-bold" label
                                    width="100%">
                                    Productos más vendidos
                                </v-chip>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text>
                        <canvas id="topProductsChart"></canvas>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <!-- TABLA ULTIMAS COTIZACIONES -->
        <v-row>
            <v-col>
                <v-card elevation="0" style="margin-bottom: 0px !important" class="rounded-lg">
                    <v-card-title>
                        <v-row class="mx-0">
                            <v-col cols="12">
                                <v-chip color="background" class="text-primary rounded-lg pa-5 font-weight-bold" label
                                    width="100%">
                                    Últimas cotizaciones
                                </v-chip>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text>
                        <v-table>
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Cliente</th>
                                    <th>Total</th>
                                    <th>Fecha</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="q in quotes" :key="q.id">
                                    <td>{{ q.folio }}</td>
                                    <td>{{ q.client }}</td>
                                    <td>${{ q.total }}</td>
                                    <td>{{ q.date }}</td>
                                    <td>
                                        <v-chip :color="q.status === 'Activo' ? 'green' : 'red'" size="small">
                                            {{ q.status }}
                                        </v-chip>
                                    </td>
                                </tr>
                            </tbody>
                        </v-table>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

    </v-container>
</template>

<script setup>
import { onMounted } from 'vue'
import Chart from 'chart.js/auto'
import InfoCard from '@/components/Statistic/InfoCard.vue'

const stats = [
    { title: 'Ventas Hoy', value: '$1,250', icon: 'mdi-cash', color: 'green' },
    //   { title: 'Cotizaciones', value: '23', icon: 'mdi-file-document', color: 'blue' },
    { title: 'Clientes', value: '120', icon: 'mdi-account-group', color: 'purple' },
    { title: 'Productos', value: '520', icon: 'mdi-package-variant', color: 'orange' }
]

const quotes = [
    { id: 1, folio: '00021', client: 'Juan Pérez', total: 500, date: '2026-02-10', status: 'Activo' },
    { id: 2, folio: '00022', client: 'Sin cliente', total: 1200, date: '2026-02-10', status: 'Activo' }
]

onMounted(() => {
    // Ventas chart
    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'],
            datasets: [{
                label: 'Ventas',
                data: [120, 300, 250, 500, 200, 400, 350],
            }]
        }
    })

    // Productos top
    new Chart(document.getElementById('topProductsChart'), {
        type: 'bar',
        data: {
            labels: ['Laptop', 'Mouse', 'Teclado'],
            datasets: [{
                label: 'Ventas',
                data: [120, 90, 50],
            }]
        }
    })
})
</script>
