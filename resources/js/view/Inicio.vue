<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12">
                <v-text-field
                    v-model="search"
                    variant="outlined"
                    label="Buscar"
                    prepend-inner-icon="mdi-magnify"
                    class="mt-2 mb-2"
                    clearable
                />
            </v-col>
            <v-col
                cols="6"
                sm="4"
                md="4"
                lg="3"
                v-for="(item, key) in dataFiltered"
                :key="key"
            >
                <div
                    class="rounded-card d-flex justify-center align-center flex-column py-5"
                    @click="goTo(item.route)"
                >
                    <i
                        class="mb-2 icon-text mdi"
                        style="font-size: 4rem"
                        :class="item.icon"
                    ></i>
                    <h4 class="icon-text px-4 text-center d-inline-block text-truncate">
                        {{ item.name }}
                    </h4>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<style scoped>
.icon-text {
    color: #192a67 !important;
}

.loader-container {
    position: relative;
    top: 0;
    left: 50%;
    bottom: 0;
    right: 50%;
    padding-top: 20%;
}

.rounded-card {
    border-radius: 1rem !important;
    background-color: transparent;
    transition: 100ms;
    box-shadow: inset 0px 0px 0px 2px #192a67;
}

.rounded-card:hover {
    background-color: #192a67;
    cursor: pointer;
    transition: 400ms;
}

.rounded-card:hover .icon-text {
    color: #fff !important;
}
</style>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import { useModuleStore } from '../pinia/module';

const router = useRouter();
const module = useModuleStore();

const search = ref('');
const permissions_arr = ref([
    {
        name: 'Ajustes',
        route: '/configuracion',
        icon: 'mdi-cog-outline',
        visibility: false,
    },
    {
        name: 'Clientes',
        route: '/clientes',
        icon: 'mdi-account-group',
        visibility: false,
    },
    {
        name: 'Áreas',
        route: '/areas',
        icon: 'mdi-package',
        visibility: false,
    },
    {
        name: 'Punto de venta',
        route: '/punto-de-venta',
        icon: 'mdi-file-outline',
        visibility: false,
    },
    {
        name: 'Estadísticas',
        route: '/cotizaciones',
        icon: 'mdi-chart-areaspline',
        visibility: false,
    },
    {
        name: 'Registrar modulos',
        route: '/crear-modulos',
        icon: 'mdi-chart-areaspline',
        visibility: false,
    },
    {
        name: 'Reportes',
        route: '/reportes',
        icon: 'mdi-chart-areaspline',
        visibility: false,
    },
]);

const permissions = ref([]);

const normalizeString = (str) => {
    return str
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '');
};

const dataFiltered = computed(() => {
    const normalizedSearch = normalizeString(search.value);

    return permissions_arr.value
        .filter((item) => {
            return item.visibility && normalizeString(item.name).includes(normalizedSearch);
        });
});

const goTo = (route) => {
    router.push(route);
};

onMounted(() => {
    module.listModule().then((response) => {
        permissions.value = response.data;
        updateVisibility();
    }).catch(error => {
        console.error('Error fetching permissions:', error);
    });
});

const updateVisibility = () => {
    if (!Array.isArray(permissions.value)) {
        console.warn('Permissions data is not an array:', permissions.value);
        return;
    }

    permissions.value.forEach((element) => {
        const index = permissions_arr.value.findIndex(
            (item) => item.name === element.name
        );
        if (index !== -1) {
            permissions_arr.value[index].visibility = true;
        }
    });
};

// Watch for changes in permissions and update visibility
watch(
    () => permissions.value,
    (newVal) => {
        if (Array.isArray(newVal)) {
            updateVisibility();
        }
    },
    { immediate: true }
);
</script>
