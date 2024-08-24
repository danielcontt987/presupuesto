<template>
    <v-row>
        <v-col cols="12">
            <v-card class="rounded-lg" flat>
                <v-card-title>
                    <v-row>
                        <v-col cols="12" md="9">
                            <v-chip color="background"
                                :style="
                                    size
                                        ? 'width: 100%; text-align: center'
                                        : ''
                                "
                                :class="size ? 'd-flex justify-center' : ''"
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
                            <v-btn size="x-large" block color="primary" flat >
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
            <ClientTable :clients="FilterClients"></ClientTable>
        </v-col>
    </v-row>
    <v-dialog v-model="showDatePicker" width="400" transition="dialog-bottom-transition" persistent>
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
//Imports
import { computed, onMounted, ref } from "vue";
import moment from "moment";
import { useDisplay } from "vuetify";
import ClientTable from "./ClientTable.vue";

const display = useDisplay();


//Mounted

onMounted(() =>{
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

//Methods

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

// Computed
const today = computed(() => {
    return moment().format('YYYY-MM-DD');
});

const FilterClients = computed(() => {
  return clients.filter((event) => {
    const name = event.name ? event.name.toLowerCase() : '';
    const searchText = search.value ? search.value.toLowerCase() : '';
    return name.includes(searchText);
  });
});

const size = computed(() => {
    if (display.mdAndUp.value) {
        return false;
    }else{        
        return true;
    }
})

const clients = [
    {
        name: "Daniel",
        status: "active",
        phone: "311230145",
        email: "jose@daniel.com",
    },
    {
        name: "Daniel Contreras",
        status: "inactivo",
        phone: "311230145",
        email: "jose@daniel.com",
    }
];
</script>

<style>
.v-card {
    border-radius: 12px !important;
}
</style>