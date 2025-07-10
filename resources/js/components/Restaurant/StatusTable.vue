<template>
    <grid-card-item color="#E5EBF2" icon="mdi-chart-bubble" text="Estatus de las mesas" @card-click="openDialog"
        :isBigger="false" />
    <v-dialog v-model="openModal" width="950">
        <card-base-modal outlined :loading="isLoading">
            <template v-slot:text>
                <v-card-text class="mt-3 py-2">
                    <v-row class="mx-0">
                        <v-col cols="12" style="padding-left: 0">
                            <v-chip color="background" class="text-primary rounded-lg pa-6 font-weight-bold" label>
                                Estatus de las mesas
                            </v-chip>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <div class="grid">

                                <div class="card available">
                                    <div class="card-icon"></div>
                                    <div>
                                        <p class="card-title">Disponible</p>
                                        <p class="card-text">Lista para nuevos clientes</p>
                                    </div>
                                </div>

                                <div class="card occupied">
                                    <div class="card-icon"></div>
                                    <div>
                                        <p class="card-title">Ocupada</p>
                                        <p class="card-text">Clientes siendo atendidos</p>
                                    </div>
                                </div>

                                <div class="card reserved">
                                    <div class="card-icon"></div>
                                    <div>
                                        <p class="card-title">Reservada</p>
                                        <p class="card-text">Reservación confirmada</p>
                                    </div>
                                </div>
                            </div>
                        </v-col>
                    </v-row>
                </v-card-text>
            </template>
            <template v-slot:actions>
                <v-card-actions class="mt-3 py-2">
                    <v-row>
                        <v-col cols="12">
                            <v-btn class="rounded-lg" text depressed flat size="large" block color="error"
                                @click="openModal = false">
                                Cerrar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-actions>
            </template>
        </card-base-modal>
    </v-dialog>
</template>

<script setup>
import { ref } from 'vue';
import GridCardItem from '../Modal/GridCardItem.vue';
import CardBaseModal from '../global/CardBaseModal.vue';

const openModal = ref(false);
const isLoading = ref(false)

const openDialog = () => {
    openModal.value = true;
}
</script>

<style scope>
.grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
}

@media (min-width: 768px) {
    .grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

.card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    border-radius: 16px;
    cursor: pointer;
    border: 1px solid;
    transition: box-shadow 0.3s, transform 0.3s;
}

.card:hover {
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.card-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s;
}

.card:hover .card-icon {
    transform: scale(1.1);
}

/* Disponible */
.available {
    background: linear-gradient(to right, #ecfdf5, #d1fae5);
    border-color: #a7f3d0;
}

.available .card-icon {
    background: linear-gradient(to right, #34d399, #22c55e);
}

.available .card-title {
    color: #065f46;
}

.available .card-text {
    color: #047857;
}

/* Ocupada */
.occupied {
    background: linear-gradient(to right, #fee2e2, #fce7f3);
    border-color: #fecaca;
}

.occupied .card-icon {
    background: linear-gradient(to right, #f87171, #ec4899);
}

.occupied .card-title {
    color: #7f1d1d;
}

.occupied .card-text {
    color: #b91c1c;
}

/* Reservada */
.reserved {
    background: linear-gradient(to right, #fef3c7, #ffedd5);
    border-color: #fcd34d;
}

.reserved .card-icon {
    background: linear-gradient(to right, #fbbf24, #f97316);
}

.reserved .card-title {
    color: #78350f;
}

.reserved .card-text {
    color: #b45309;
}
</style>