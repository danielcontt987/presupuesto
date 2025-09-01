<template>
    <v-row>
        <!-- <v-col cols="12">
            <v-card class="rounded-lg" flat>
                <v-card-title>
                    <v-row>
                        <v-col cols="12" md="9">
                            <v-chip
                                color="background"
                                class="text-primary rounded-lg pa-5 font-weight-bold text-uppercase"
                                label
                            >
                                Filtros
                            </v-chip>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-card-text class="mt-3">
                    <v-row>
                        <v-col cols="12" md="5">
                            <v-text-field
                                variant="outlined"
                                v-model="startDate"
                                label="Fecha de inicio"
                                prepend-inner="mdi-calendar"
                                @click.append="show('start')"
                                clearable
                            />
                        </v-col>
                        <v-col cols="12" md="5">
                            <v-text-field
                                variant="outlined"
                                v-model="endDate"
                                label="Fecha de final"
                                @click.append="show('end')"
                                clearable
                            />
                        </v-col>
                        <v-col cols="12" md="2">
                            <v-btn size="x-large" class="rounded-lg" flat block color="primary" @click="consultArea()">
                                Filtrar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-col> -->
        <v-col cols="12">
            <v-card class="rounded-lg" flat>
                <v-card-title>
                    <v-row>
                        <v-col cols="12" md="9">
                            <v-chip color="background"
                                class="text-primary rounded-lg pa-5 font-weight-bold text-uppercase" label>
                                Áreas registradas
                            </v-chip>
                        </v-col>
                    </v-row>
                    <v-tabs v-model="selectedtab" class="mt-5" centered background-color="background" grow>
                        <v-tab value="one"
                            class="rounded-lg mr-3 bg-background text-weight-bold text-primary"><b>Áreas</b></v-tab>
                        <v-tab value="two" class="rounded-lg bg-background text-primary"><b>Usuarios</b></v-tab>
                    </v-tabs>
                </v-card-title>

                <v-card-text>
                    <v-window v-model="selectedtab">
                        <window-tab-area value="one" />
                        <v-window-item value="two">
                            Tab Two content
                        </v-window-item>
                    </v-window>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
    <v-dialog v-model="showDatePicker" width="400" transition="dialog-bottom-transition">
        <v-card flat class="ma-2 rounded-card" style="overflow: hidden !important">
            <v-row>
                <v-date-picker class="ma-2 pa-0 text-center" v-model="tempDate" width="800"
                    :max="startDate == null ?? today" color="primary"></v-date-picker>
            </v-row>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" class="rounded-lg" x-large text depressed block @click="acceptDate">
                    Aceptar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>


<script setup>
import { computed, ref } from "vue";
import { useAreaStore } from "@/pinia/area.js";
import WindowTabArea from "./Tabs/WindowTabArea.vue";
import moment from "moment";

const areaStore = useAreaStore();
const search = ref(null);
const selectedtab = ref(null);
const showDatePicker = ref(false);
const dateType = ref('start');

const startDate = ref(null);
const endDate = ref(null);
const tempDate = ref(null);

const consultArea = () => {
    let params = {
        startDate: startDate,
        endDate: endDate,
    };
    areaStore.getArea(params);
};

const acceptDate = () => {
    if (dateType.value === 'start') {
        startDate.value = moment(tempDate.value).format("YYYY-MM-DD");
    } else {
        endDate.value = moment(tempDate.value).format("YYYY-MM-DD");
    }
    showDatePicker.value = false;
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

const today = computed(() => {
    return moment().format('YYYY-MM-DD');
})
</script>

<style>
.v-card {
    border-radius: 12px !important;
}
</style>