<script setup>
import { ref } from "vue";

const drawer = ref(false);
const tab = ref("building");

const menuItems = [
    { title: "Home", link: "/" },
    { title: "Projects", link: "/projects" },
    { title: "Services", link: "/services" },
    { title: "About Us", link: "/about" },
    { title: "Blog", link: "/blog" },
    { title: "Contact", link: "/contact" },
];
</script>

<template>
    <v-app>
        <!-- Header -->
        <v-app-bar flat color="primary" dark>
            <v-app-bar-nav-icon @click="drawer = !drawer" />
            <v-toolbar-title>Construct</v-toolbar-title>
            <v-spacer />
            <v-btn text v-for="item in menuItems" :key="item.title" :to="item.link">
                {{ item.title }}
            </v-btn>
        </v-app-bar>

        <!-- Navigation Drawer -->
        <v-navigation-drawer v-model="drawer" temporary>
            <v-list>
                <v-list-item v-for="item in menuItems" :key="item.title" :to="item.link">
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <!-- Hero Section -->
        <v-container fluid class="py-12 text-center"
            style="background:url('/images/background02.jpg'); background-size:cover;">
            <h1 class="display-2 font-weight-bold white--text">
                We <span class="text-warning">Build</span> Great Projects
            </h1>
            <p class="white--text">We aim to eliminate the task of dividing your project between different companies.
            </p>
            <v-btn color="yellow" variant="outlined" class="mt-4">Contact Us</v-btn>
        </v-container>

        <!-- Tabs Section -->
        <v-container class="my-12">
            <v-tabs v-model="tab" align-tabs="center" color="primary">
                <v-tab value="building">Building</v-tab>
                <v-tab value="construction">Construction</v-tab>
                <v-tab value="isolation">Isolation</v-tab>
            </v-tabs>

            <v-window v-model="tab" class="mt-6">
                <v-window-item value="building">
                    <v-row>
                        <v-col cols="12" md="6">
                            <h2>Building A New Green House</h2>
                            <p>
                                We are a company that offers design and build services for you
                                from initial sketches to the final construction.
                            </p>
                            <v-btn color="red" variant="outlined">Contact Us</v-btn>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-img src="/images/image02.png" />
                        </v-col>
                    </v-row>
                </v-window-item>

                <v-window-item value="construction">
                    <h2>Construction Tab</h2>
                    <p>Content for construction projects...</p>
                </v-window-item>

                <v-window-item value="isolation">
                    <h2>Isolation Tab</h2>
                    <p>Content for isolation projects...</p>
                </v-window-item>
            </v-window>
        </v-container>

        <!-- Footer -->
        <v-footer color="primary" app>
            <v-col class="text-center white--text">
                © {{ new Date().getFullYear() }} Construct. All rights reserved.
            </v-col>
        </v-footer>
    </v-app>
</template>
