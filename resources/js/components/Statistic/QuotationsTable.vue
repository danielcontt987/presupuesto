<template>
    <v-card class="rounded-lg" flat>
        <v-card-title>
            <v-row>
                <v-col cols="12" md="9">
                    <v-chip color="background" :style="size ? 'width: 100%; text-align: center' : ''"
                        :class="size ? 'd-flex justify-center' : ''"
                        class="text-primary rounded-lg pa-5 font-weight-bold text-uppercase" label>
                        Cotizaciones
                    </v-chip>
                </v-col>
            </v-row>
        </v-card-title>
        <v-card-text class="mt-3">
            <v-row>
                <v-col cols="12">
                    <v-data-table :headers="headers" :items="items">
                        <template #item.status="{ item }">
                            <v-chip variant="tonal" color="greenLight" class="rounded-lg"
                                v-if="item.status === 'Finalizado'">
                                <b>Activo</b>
                            </v-chip>
                            <v-chip variant="tonal" color="fail" class="rounded-lg" v-else>
                                <b>Cancelada</b>
                            </v-chip>
                        </template>

                        <template #item.folio="{ item }">
                            <v-chip variant="tonal" color="fail" class="rounded-lg">{{ item.folio }}</v-chip>
                        </template>

                        <template #item.total="{ item }">
                            {{ currency(item.total) }}
                        </template>

                        <template #item.client="{ item }">
                            {{ item.client ? item.client.name + " " + item.client.lastname : "Sin cliente" }}
                        </template>

                        <template #item.ticket="{ item }">
                            <v-chip variant="tonal" color="titleCard" class="rounded-lg">Ticket</v-chip>
                        </template>

                        <template #item.actions="{ item }">
                            <!-- Ver detalle -->
                            <v-tooltip location="bottom">
                                <template #activator="{ props }">
                                    <v-btn v-bind="props" @click="$emit('edit', item)" icon class="rounded-lg" flat
                                        size="small" color="primary" :class="xs ? '' : 'mr-2'">
                                        <v-icon>mdi-eye</v-icon>
                                    </v-btn>
                                </template>
                                Ver detalle
                            </v-tooltip>

                            <!-- Imprimir nuevamente -->
                            <v-tooltip location="bottom">
                                <template #activator="{ props }">
                                    <v-btn v-bind="props" @click="$emit('print', item)" icon class="rounded-lg" flat
                                        size="small" color="greenLight" :class="xs ? '' : 'mr-2'">
                                        <v-icon>mdi-printer</v-icon>
                                    </v-btn>
                                </template>
                                Imprimir nuevamente
                            </v-tooltip>

                            <!-- Cancelar -->
                            <v-tooltip location="bottom">
                                <template #activator="{ props }">
                                    <v-btn v-bind="props" @click="$emit('delete', item)" icon class="rounded-lg" flat
                                        size="small" color="fail">
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
</template>

<script setup>
import { computed } from "vue";
import accounting from "accounting";
import { useDisplay } from "vuetify";


const props = defineProps({
    items: Array,
    headers: Array,
    xs: Boolean,
});

const emits = defineEmits(["edit", "print", "delete"]);

const display = useDisplay();
const size = computed(() => !display.mdAndUp.value);

const currency = (value) => accounting.formatMoney(value, "$", 2, ",", ".");

</script>
