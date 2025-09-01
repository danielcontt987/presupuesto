<template>
    <CardBaseModal outlined v-if="settingStore.business">
        <template v-slot:text>
            <v-card-text class="mt-3 py-2 px-5">
                <v-row class="mx-0">
                    <v-col cols="12" style="padding-left: 0">
                        <v-chip color="background" class="text-primary rounded-lg pa-6 font-weight-bold" label>
                            Ubicación de la empresa
                        </v-chip>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <div id="map-view" style="height: 300px;"></div>
                        <p>Latitud: {{ lat }}</p>
                        <p>Longitud: {{ lng }}</p>
                    </v-col>
                    <v-col cols="12">
                        <h4 class="font-weight-light mb-0">
                            La ubicación de tu empresa nos ayuda a determinar donde se deben de registrar su entrada tus
                            colaboradores.
                        </h4>
                    </v-col>
                </v-row>
            </v-card-text>
        </template>
        <template v-slot:actions>
            <v-card-actions>
                <v-row>
                    <v-col cols="12">
                        <v-btn large block class="rounded-lg" variant="outlined" depressed color="primary"
                            @click="updateInfo()">
                            Actualizar datos
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </template>
    </CardBaseModal>
    <v-dialog v-model="openModal" width="500" persistent class="rounded-lg">
        <card-base-modal outlined :loading="isLoading">
            <template v-slot:text>
                <v-card-text class="mt-3 py-2">
                    <v-row class="mx-0">
                        <v-col cols="12" style="padding-left: 0">
                            <v-chip color="background" class="text-primary rounded-lg pa-6 font-weight-bold" label>
                                Actualizar ubicación de la empresa
                            </v-chip>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <div>
                                <div id="map-modal" style="height: 400px;"></div>
                                <p>Lat: {{ lat }}, Lng: {{ lng }}</p>
                            </div>
                        </v-col>
                    </v-row>
                </v-card-text>
            </template>
            <template v-slot:actions>
                <v-card-actions class="mt-3 py-2">
                    <v-row>
                        <v-col cols="12" md="6" order="2" order-md="1">
                            <v-btn class="rounded-lg" text depressed flat size="large" block color="error"
                                @click="openModal = false">
                                Cerrar
                            </v-btn>
                        </v-col>
                        <v-col cols="12" md="6" order="1" order-md="2">
                            <v-btn class="bg-primary rounded-lg" flat size="large" block @click="update()">
                                Actualizar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-actions>
            </template>
        </card-base-modal>
    </v-dialog>
    <Alert />
</template>

<script setup>
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

import { ref, watch, nextTick } from 'vue'
import CardBaseModal from "@/components/global/CardBaseModal.vue"
import { useSettingStore } from "@/pinia/setting";
import { useAlertNormalStore } from "@/pinia/alert";


const openModal = ref(false)
const isLoading = ref(false)
const lat = ref(null)
const lng = ref(null)
const settingStore = useSettingStore()
const alertNormal = useAlertNormalStore();

let viewMap, viewMarker
let modalMap, modalMarker

const updateInfo = () => {
    openModal.value = true
}

const update = (() => {
    let params = {
        "lat": lat.value,
        "long": lng.value,
    }

    settingStore.updateUbication(params).then((response) => {
        openModal.value = false;
        alertNormal.show = true;
        (alertNormal.color = "success"),
            (alertNormal.msg =
                "Se actualizó correctamente la información"),
            (alertNormal.type = 0),
            (alertNormal.icon = "mdi-check-circle-outline");
    });
})

const initMap = async () => {
    await nextTick() // esperar a que se renderice el DOM (el <div id="map">)

    // Si ya hay un mapa, destrúyelo para evitar bugs
    if (modalMap) {
        modalMap.remove()
        modalMap = null
    }

    modalMap = L.map('map-modal').setView([lat.value, lng.value], 5)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(modalMap)

    modalMarker = L.marker([lat.value, lng.value]).addTo(modalMap)

    modalMap.on('click', async (e) => {
        lat.value = e.latlng.lat.toFixed(6)
        lng.value = e.latlng.lng.toFixed(6)

        modalMarker.setLatLng(e.latlng)
    })
}

// Verifica cuando se abre el modal
watch(openModal, (val) => {
    if (val) initMap()
})


watch(
    () => settingStore.business,
    async (business) => {
        if (!business) return

        lat.value = business.lat ?? 19.4326
        lng.value = business.log ?? -99.1332

        await nextTick() // esperar a que <div id="map-view"> exista

        // Si ya hay mapa, destrúyelo y resetea el contenedor
        if (viewMap) {
            viewMap.remove()
            viewMap = null
        }

        // 🔥 Esto es lo que te faltaba
        if (L.DomUtil.get('map-view') != null) {
            L.DomUtil.get('map-view')._leaflet_id = null
        }

        // Crear mapa y marcador
        viewMap = L.map('map-view').setView([lat.value, lng.value], 13)

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(viewMap)

        viewMarker = L.marker([lat.value, lng.value]).addTo(viewMap)
    },
    { immediate: true }
)


</script>
