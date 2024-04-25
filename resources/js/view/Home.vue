<template>
    <v-app>
        <slider />
        <v-container>
            <v-row class="text-center mt-6 mb-3">
                <v-col cols="12">
                    <h2>Servicios</h2>
                </v-col>
            </v-row>
            <v-row>
                <v-col
                    cols="12"
                    md="4"
                    v-for="(item, index) in items"
                    :key="index"
                >
                    <card-info
                        :icon="item.icon"
                        :title="item.title"
                        :text="item.text"
                    />
                </v-col>
            </v-row>
        </v-container>
        <!-- <v-footer class="bg-backgroundColor" v-if="router.path == '/'">
                <div class="text-center w-100 bg-backgroundColor">
                    {{ 'Derechos de autor &copy; ' + new Date().getFullYear() + '. Todos los derechos reservados.' }}
                </div>
            </v-footer> -->
    </v-app>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import AppBar from "../components/AppBar.vue";
import CardInfo from "../components/info/CardInfo.vue";
import Slider from "../components/Slider.vue";

// const router = useRouter();

const items = ref([
    {
        icon: "mdi-note",
        title: "Presupuestos",
        text: "Ofrecemos consultas gratuitas donde discutiremos tus necesidades y a su vez te proporcionaremos un estimado inicial del costo.",
    },

    {
        icon: "mdi-home",
        title: "Contrucciones",
        text: "Utilizamos los materiales más duraderos y las técnicas de construcción más avanzadas para garantizar la calidad y la seguridad de tu hogar.",
    },

    {
        icon: "mdi-bitbucket",
        title: "impermeabilizante",
        text: "Basándonos en las necesidades específicas de tu hogar, te ofreceremos las mejores soluciones de impermeabilización de muy alta calidad.",
    },
]);
</script>

<style></style>
