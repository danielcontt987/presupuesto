<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12">
                <v-card class="rounded-lg" elevation="0">
                    <v-card-title>
                        <v-row>
                            <v-col cols="12" lg="10" sm="12">
                                <p :class="mobile == true? 'text-center' : ''" >Clientes</p>
                            </v-col>
                            <v-col cols="12" lg="2" sm="12">
                                <v-btn id="menu-activator" color="primary" elevation="0"  class="rounded-lg" block>
                                    Opciones
                                </v-btn>

                                <v-menu activator="#menu-activator">
                                    <v-list>
                                        <v-list-item
                                        >
                                            <v-list-item-title>
                                              Agregar clientes
                                            </v-list-item-title>
                                        </v-list-item>
                                        <v-list-item
                                        >
                                            <v-list-item-title>
                                              Descargar PDF
                                            </v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>
                            </v-col>
                        </v-row>
                    </v-card-title>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { computed } from "vue";
import { useDisplay } from "vuetify";

const breakpoints = useDisplay();

const mobile = computed(() => {
  if (breakpoints.smAndDown.value) {
    return true;
  }
  return false
});
</script>

<style></style>
