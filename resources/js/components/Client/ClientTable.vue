<template>
    <v-card class="rounded-lg" flat>
        <v-card-title>
            <v-row>
                <v-col cols="12" md="9">
                    <v-chip
                        color="background"
                        class="text-primary rounded-lg pa-5 font-weight-bold text-uppercase"
                        label
                        :style="size ? 'width: 100%; text-align: center' : ''"
                        :class="size ? 'd-flex justify-center' : ''"
                    >
                        Clientes
                    </v-chip>
                </v-col>
                <v-col cols="12" md="3" class="text-right">
                    <v-btn class="elevation-0 rounded-lg font-weight-bold" 
                        color="primary" variant="outlined" :block="size ? true : false">
                        Opciones
                        <v-menu activator="parent">
                            <v-list>
                                <v-list-item @click="createClient()">
                                    <v-list-item-title>Agregar clientes</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-title>
        <v-card-text class="mt-3">
            <v-data-table :headers="headers" :items="clients">
                <template v-slot:item.status="{ item }">
                    <v-chip variant="tonal" color="greenLight" class="rounded-lg" v-if="item.status =='active'">
                        <b>{{ "Activo" }}</b>
                    </v-chip>
                    <v-chip variant="tonal" color="fail" class="rounded-lg" v-else>
                        <b>{{ "Inactivo" }}</b>
                    </v-chip>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-btn
                        @click="editClient(item)"
                        icon="mdi-pencil"
                        class="rounded-lg"
                        flat
                        size="small"
                        color="primary"
                        :class="xs ? '' : 'mr-2' "
                    ></v-btn>
                    <v-btn
                        @click="deleteClient(item)"
                        icon="mdi-delete"
                        class="rounded-lg"
                        flat
                        size="small"
                        color="error"
                    ></v-btn>
                </template>
            </v-data-table>
        </v-card-text>
    </v-card>
</template>

<script setup>
import { computed } from 'vue';
import { useRouter } from 'vue-router';
import { useDisplay } from 'vuetify';

defineProps({
    clients:{
        type: Array,
    }
});

const router = useRouter();

const display = useDisplay();

const size = computed(() => !display.mdAndUp.value);
const xs = computed(() => display.xs.value);

const headers = [
    { title: 'Nombre', align: 'center', key: 'name' },
    { title: 'Estado', align: 'center', key: 'status' },
    { title: 'Teléfono', align: 'center', key: 'phone' },
    { title: 'Email', align: 'center', key: 'email' },
    { title: 'Acciones', align: 'center', key: 'actions' },
];

const editClient = item => {
}

const deleteClient = item => {
}

const createClient = () => {
    router.push('/crear-cliente')
}

</script>
