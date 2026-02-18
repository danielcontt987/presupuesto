<template>
    <v-app-bar elevation="0" app class="border">

        <v-app-bar-nav-icon v-if="size" @click="toggleDrawer" />
        <v-toolbar-title><b>LUXSOFT</b></v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon @click="toggleFullScreen">
            <v-icon>mdi-fullscreen</v-icon>
        </v-btn>
        <v-btn icon @click="toggleTheme">
            <v-icon>{{ themeName === 'customDarkTheme' ? 'mdi-white-balance-sunny' : 'mdi-weather-night' }}</v-icon>
        </v-btn>
    </v-app-bar>
</template>

<script setup> 
import { useCustomTheme } from "@/composable/useCustomMode";
import { useGlobals } from "@/pinia/globals";
const globalsStore = useGlobals();
const toggleDrawer = (value) => {
    globalsStore.setDrawer(!globalsStore.drawer);
};
import { computed } from "vue";
import { useDisplay } from "vuetify";
const display = useDisplay();
const size = computed(() => !display.mdAndUp.value);
const { toggleTheme, themeName } = useCustomTheme()


const toggleFullScreen = () => {
    if (!document.fullscreenElement) {
        // Entrar a pantalla completa
        const elem = document.documentElement;
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) { // Safari
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) { // IE11
            elem.msRequestFullscreen();
        }
    } else {
        // Salir de pantalla completa
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) { // Safari
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) { // IE11
            document.msExitFullscreen();
        }
    }
};
</script>

<style scoped>
:root {
    --v-theme-border: #e0e0e0;
}
.border {
    border-bottom: 1px solid var(--v-theme-border);
}

</style>