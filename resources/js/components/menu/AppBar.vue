<template>
    <v-app-bar color="primary">
        <v-toolbar-title>
            <div class="d-flex align-center">
                <router-link to="/inicio" class="d-flex align-center justify-center">
                    <v-img src="../img/logo.webp" width="50" height="50" eager />
                </router-link>
                <div class="ml-2 white--text hidden-xs-only" v-if="currentRouteName != 'Inicio'">
                    |
                </div>
                <small class="ml-2 white--text hidden-xs-only font-weight-bold" v-if="currentRouteName != 'Inicio'">
                    {{ currentRouteName }}
                </small>
            </div>
        </v-toolbar-title>
        <v-btn color="white" icon @click="toggleFullScreen()">
            <v-icon color="white">mdi-vector-square</v-icon>
        </v-btn>
        <v-btn color="white" icon @click="toggleTheme()">
            <v-icon color="white">{{ themeName === 'customDarkTheme' ? 'mdi-weather-sunny' : 'mdi-weather-night'
                }}</v-icon>
        </v-btn>
        <v-btn color="white" icon>
            <v-icon>mdi-account</v-icon>
            <v-menu activator="parent">
                <v-list class="bg-cardColor">
                    <v-list-item @click="goToPerfil()">
                        <v-list-item-title>Mi perfil</v-list-item-title>
                    </v-list-item>
                    <v-list-item @click="logout()">
                        <v-list-item-title>Cerrar sesión</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-btn>
    </v-app-bar>
</template>

<script setup>
import axios from "axios";
import { computed, onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useCustomTheme } from "@/composable/useCustomMode";
import { el } from "vuetify/locale";
const { toggleTheme, themeName } = useCustomTheme()

const router = useRouter();
const route = useRoute();
const currentRouteName = computed(() => {
    return route.name;
});

onMounted(() => {
    if (localStorage.getItem("darkMode")) {
        darkMode.value = JSON.parse(localStorage.getItem("darkMode"));
    }
});

const logout = () => {
    axios.post("user/logout").then(() => {
        window.location.href = "/login";
    });
};

const goToPerfil = () => {
    router.push("/mi-perfil");
};

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

<style></style>
