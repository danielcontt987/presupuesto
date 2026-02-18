<template>
  <v-navigation-drawer class="bg-white" v-model="drawer" :rail="rail" permanent color="background_drawer" v-if="!size">
    <v-list density="compact" nav>
      <v-list-item v-for="(item, index) in dataFiltered" :key="index" @click="
        setActive(item.route);
      $router.push(item.route);
      " :class="{ 'bg-primary': isCurrentRoute(item.route) }" class="overflow-y text-white mx-0 w-full rounded-lg">
        <v-icon v-if="rail" :title="item.name" :class="isCurrentRoute(item.route) ? 'white' : 'text-grey_dark'">
          {{ item.icon }}
        </v-icon>
        <v-icon v-if="rail == false" :title="item.name"
          :class="isCurrentRoute(item.route) ? 'grey_dark' : 'text-grey_dark'" class="mr-5" color="white">
          {{ item.icon }}
        </v-icon>
        <span v-if="!rail" :title="item.name"
          :class="isCurrentRoute(item.route) ? 'text-background_white font-weight-normal' : 'text-grey_dark font-weight-normal'">{{ item.name }}</span>
      </v-list-item>
    </v-list>
    <!-- Botón para contraer/expandir el drawer -->
    <template v-slot:append>
      <v-list-item class="text-grey_dark mx-0 w-full rounded-lg" v-if="rail == false" @click.stop="rail = !rail">
        <v-icon class="text-purple_primary mr-5"> mdi-arrow-collapse </v-icon>
        <span class="text-purple_primary"> <b>Contraer</b> </span>
      </v-list-item>
      <v-list-item class="text-purple_primary mx-0 w-full rounded-lg" prepend-icon="mdi-arrow-expand" v-else
        @click.stop="rail = !rail">
        <v-icon class="text-purple_primary"> mdi-arrow-expand </v-icon>
      </v-list-item>
    </template>
  </v-navigation-drawer>
  <v-navigation-drawer v-else v-model="globalsStore.drawer" temporary>
    <v-list density="compact" nav>
      <v-list-item v-for="(item, index) in dataFiltered" :key="index" @click="
        setActive(item.route);
      $router.push(item.route);
      " :class="{ 'bg-primary': isCurrentRoute(item.route) }" class="overflow-y text-white mx-0 w-full rounded-lg">
        <v-icon v-if="rail" :title="item.name" :class="isCurrentRoute(item.route) ? 'white' : 'text-grey_dark'">
          {{ item.icon }}
        </v-icon>
        <v-icon v-if="rail == false" :title="item.name"
          :class="isCurrentRoute(item.route) ? 'grey_dark' : 'text-grey_dark'" class="mr-5" color="white">
          {{ item.icon }}
        </v-icon>
        <span v-if="!rail" :title="item.name"
          :class="isCurrentRoute(item.route) ? 'text-background_white ' : 'text-grey_dark'">{{ item.name }}</span>
      </v-list-item>



    </v-list>
    <!-- Botón para contraer/expandir el drawer -->
    <template v-slot:append>
      <div class="pa-2">
        <v-btn class="rounded-lg mx-auto bg-primary" block @click="globalsStore.setDrawer(false)">Cerrar</v-btn>
      </div>
    </template>
  </v-navigation-drawer>
</template>
<script setup>
import { ref, onMounted, watch, inject, computed } from "vue";
import { useUserStore } from "@/pinia/user";
import { useGlobals } from "@/pinia/globals";
const globalsStore = useGlobals();
const userStore = useUserStore();

import { useDisplay } from "vuetify";
const display = useDisplay();
const size = computed(() => !display.mdAndUp.value);

onMounted(() => {
  isLoading.value = true;
  userStore.consultUser().then((response) => {
    permissions.value = response.data.permissions
  }).catch((error) => {
  }).finally(() => {
    isLoading.value = false;
  })
})

const isLoading = ref(false);
const permissions = ref([]);
const search = ref('');
const activeItem = ref('');

const normalizeString = (str) => {
  return str
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '');
};

const dataFiltered = computed(() => {
  const normalizedSearch = normalizeString(search.value);

  return navigationItems.value
    .filter((item) => {
      return item.visibility && normalizeString(item.name).includes(normalizedSearch);
    });
});

const updateVisibility = () => {

  if (!Array.isArray(permissions.value)) {
    console.warn('Permissions data is not an array:', permissions.value);
    return;
  }

  permissions.value.forEach((element) => {
    const index = navigationItems.value.findIndex(
      (item) => item.name === element.name
    );
    if (index !== -1) {
      navigationItems.value[index].visibility = true;
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


const props = defineProps({
  drawer: Boolean
})

const emit = defineEmits(['update:drawer'])

const drawer = ref(props.drawer)

watch(() => props.drawer, val => drawer.value = val)

watch(drawer, val => emit('update:drawer', val))
const rail = ref(false)

const drawerD = ref(false)


const navigationItems = ref([
  {
    name: 'Inicio',
    route: '/inicio',
    icon: 'mdi-home',
    visibility: true,
  },
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
    icon: 'mdi-point-of-sale',
    visibility: false,
  },
  {
    name: 'Restaurante',
    route: '/restaurante',
    icon: 'mdi-food',
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
  {
    name: 'Productos',
    route: '/productos',
    icon: 'mdi-tag',
    visibility: false,
  },
  {
    name: 'Estadísticas',
    route: '/estadisticas',
    icon: 'mdi-chart-areaspline',
    visibility: false,
  },
  {
    name: 'Planificador',
    route: '/planificador',
    icon: 'mdi-chart-areaspline',
    visibility: false,
  },
  {
    name: 'Cocina',
    route: '/cocina',
    icon: 'mdi-chart-areaspline',
    visibility: false,
  },
  {
    name: 'Administración de tarjetas',
    route: '/tarjetas',
    icon: 'mdi-card',
    visibility: false,
  },
  {
    name: 'Cotizaciones',
    route: '/cotizaciones',
    icon: 'mdi-card',
    visibility: false,
  },
]);

const setActive = (route) => {
  if (route === "/punto-de-venta") {
    activeItem.value = route;
    rail.value = false;
    drawerD.value = false;
  } else {
    activeItem.value = route;
    rail.value = false;
  }
};

const isCurrentRoute = (route) => {
  return route === activeItem.value;
};

// Sincroniza el valor del drawer cuando cambia en el componente padre
watch(
  () => props.drawer,
  (newDrawer) => {
    drawer.value = newDrawer;
  }
);

onMounted(() => {
  rail.value = false;
})

// Emite el evento cuando el drawer local cambia
watch(
  () => drawer.value,
  (newDrawer) => {
    emit("update:drawer", newDrawer);
  }
);

// Cierra el drawer cuando el componente se monta
onMounted(() => {
  drawer.value = true;
});
</script>
<style scoped>
.bg-primary {
  background: #5d87ff;
}
</style>
