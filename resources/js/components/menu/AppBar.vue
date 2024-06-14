<template>
    <v-app-bar color="primary">
        <!--  -->
        <v-toolbar-title>
            <div class="d-flex align-center">
                <router-link
                    to="/inicio"
                    class="d-flex align-center justify-center"
                >
                    <v-img src="../img/logo.png" width="50" height="50" />
                </router-link>
                <div
                    class="ml-2 white--text hidden-xs-only"
                    v-if="currentRouteName != 'Inicio'"
                >
                    |
                </div>
                <small
                    class="ml-2 white--text hidden-xs-only font-weight-bold"
                    v-if="currentRouteName != 'Inicio'"
                >
                    {{ currentRouteName }}
                </small>
            </div>
        </v-toolbar-title>

        <v-btn color="white" icon>
            <v-icon>mdi-account</v-icon>
            <v-menu activator="parent">
                <v-list>
                    <v-list-item>
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
import { computed } from "vue";
import { useRoute } from "vue-router";
const route = useRoute();
const currentRouteName = computed(() => {
    return route.name;
});

const logout = () => {
    axios.post("user/logout").then(() => {
        window.location.href = "/login";
    });
};
</script>

<style></style>
