<template>
    <v-card flat class="rounded-lg">
        <v-card-title>
            <v-row class="mx-0">
                <v-col cols="12" md="9" style="padding-left: 0">
                    <v-chip
                        color="background"
                        class="text-primary rounded-lg pa-5 font-weight-bold"
                        label
                    >
                        Usuarios registrdos
                    </v-chip>
                </v-col>
                <v-col cols="12" md="3" class="text-right">
                    <v-btn
                        color="background"
                        class="rounded-lg text-primary text-uppercase"
                        flat
                        @click="editForm"
                    >
                        <b>{{ edit ? "Cancelar" : "Editar" }}</b>
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-title>
        <v-card-text>
            <v-row class="py-5 px-1">
                <v-col class="pb-0" cols="12" md="4">
                    <v-card class="bg-background rounded-lg" flat>
                        <v-card-text>
                            <h3 class="text-center">José Daniel Contreras Pérez</h3>
                        </v-card-text>
                        <v-card-actions>
                            <v-row no-gutter>
                                <v-col cols="12" md="6">
                                    <v-btn
                                        class="rounded-lg"
                                        large
                                        text
                                        depressed
                                        block
                                        color="error"
                                    >
                                        Quitar
                                    </v-btn>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-btn
                                        class="rounded-lg bg-primary"
                                        large
                                        depressed
                                        block
                                    >
                                       Encargado
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>
