<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" md="3">
                <v-card color="cardColor" class="rounded-lg" flat>
                    <v-card-title>
                        <v-row>
                            <v-col cols="12" md="9">
                                <v-chip 
                                    class="bg-chipCard text-colorText rounded-lg pa-5 font-weight-bold text-uppercase" label>
                                    Mi perfil
                                </v-chip>
                            </v-col>
                            <v-col cols="12" md="3" class="text-right">
                                <v-avatar color="chipCard" size="40" class="cursor-pointer">
                                    <v-icon size="20">mdi-pencil</v-icon>
                                </v-avatar>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text class="mt-3 py-2">
                        <v-row class="mx-0">
                            <v-col cols="12" class="text-center">
                                <v-avatar variant="tonal" color="fail" size="100" class="cursor-pointer">
                                    <v-icon size="40">mdi-account</v-icon>
                                </v-avatar>
                            </v-col>
                            <v-col cols="12" class="text-center mt-2">
                                <v-list density="comfortable" class="bg-cardColor no-pointer">
                                    <v-list-subheader class="text-center align-center justify-center">José Daniel Contreras Perez</v-list-subheader>
                                    <br>
                                    <v-list-item v-for="(item, i) in items" :key="i" :value="item" color="primary" >
                                        <template v-slot:prepend>
                                            <v-icon :icon="item.icon" class="me-2 icon-tight"></v-icon>
                                        </template>

                                        <v-list-item-title v-text="item.text"></v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-col>
                            <v-col cols="12" class="text-center">
                                <img src="../../../../public/business/worker.png" alt="" height="100" width="100">
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                         <v-row class="mt-3 mb-3">
                            <v-col cols="12">
                                <v-btn large block class="rounded-lg" variant="outlined" depressed color="primaryBg"
                                    @click="updateInfo()">
                                    Actualizar datos
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
    const items = [
        { text: 'Administrador', icon: 'mdi-account-outline' },
        { text: 'Jan 20, 1980', icon: 'mdi-calendar-outline' },
        { text: 'Tepic, Nay, Mex', icon: 'mdi-map-marker-outline' },
        { text: 'jose@gmail.com', icon: 'mdi-email-outline' },
        { text: '3112234567', icon: 'mdi-phone-outline' },
    ]
</script>

<style scoped>
.font-size-text {
    font-size: 18px;
}

.no-pointer .v-list-item {
    pointer-events: none;
    cursor: default !important;
}

.icon-tight {
  margin-right: 8px; /* Puedes reducir aún más, ej. 4px */
  padding: 0;
  font-size: 20px; /* Opcional: para que no sea muy grande */
  vertical-align: middle;
}
</style>