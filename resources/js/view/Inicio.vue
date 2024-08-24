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
                >
                </v-text-field>
            </v-col>
            <v-col
                cols="6"
                sm="4"
                md="4"
                lg="3"
                v-for="(item, key) in permissions"
                :key="key"
            >
                <div
                    class="rounded-card d-flex justify-center align-center flex-column py-5"
                    @click="goTo(item.route, item.name)"
                >
                    <i
                        class="mb-2 icon-text mdi"
                        style="font-size: 4rem"
                        :class="item.icon"
                    ></i>
                    <h4
                        class="icon-text px-4 text-center d-inline-block text-truncate"
                    >
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
    -webkit-box-shadow: inset 0px 0px 0px 2px #192a67;
    -moz-box-shadow: inset 0px 0px 0px 2px #192a67;
    box-shadow: inset 0px 0px 0px 2px #192a67;
}

.rounded-card:hover {
    background-color: #192a67;
    cursor: pointer;
    border: none;
    transition: 400ms;
}

.rounded-card:hover .icon-text {
    color: #fff !important;
}
</style>
<script setup>
import { computed, ref } from "vue";
import { useRouter } from "vue-router";
const router = useRouter();

const search = ref("");
const  permissions_arr = [
        {
            name: "Ajustes",
            route: "/configuracion",
            icon: "mdi-cog-outline",
            visibility: false,
        },
        {
            name: "Clientes",
            route: "/clientes",
            icon: "mdi-account-group",
            visibility: false,
        },
        {
            name: "Áreas",
            route: "/areas",
            icon: "mdi-package",
            visibility: false,
        },
        {
            name: "Punto de venta",
            route: "/punto-de-venta",
            icon: "mdi-file-outline",
            visibility: false,
        },
        {
            name: "Estadísticas",
            route: "/cotizaciones",
            icon: "mdi-chart-areaspline",
            visibility: false,
        },
        {
            name: "Registrar modulos",
            route: "/crear-modulos",
            icon: "mdi-chart-areaspline",
            visibility: false,
        },
];

const normalizeString = str => {
    return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
}

const goTo = (route) => {
   router.push(route)
};

const permissions = computed(() => {
    const searchTerm = search.value.toLowerCase();
    return permissions_arr.filter(item =>
        normalizeString(item.name).includes(searchTerm)
    );
})

</script>

<style></style>
