<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" md="3">
                <v-card color="cardColor" class="rounded-lg" flat>
                    <v-card-title>
                        <v-row>
                            <v-col cols="12" md="9">
                                <v-chip
                                    class="bg-chipCard text-colorText rounded-lg pa-5 font-weight-bold text-uppercase"
                                    label>
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
                                    <v-list-subheader class="text-center align-center justify-center">José Daniel
                                        Contreras Perez</v-list-subheader>
                                    <br>
                                    <v-list-item v-for="(item, i) in items" :key="i" :value="item" color="primary">
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
            <v-col cols="12" md="3">
                <v-row>
                    <v-col cols="12">
                        <v-btn large block class="rounded-lg" variant="outlined" depressed color="primaryBg"
                            @click="updateText()">
                            Actualizar datos
                        </v-btn>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
    <v-dialog v-model="openModal" width="500" persistent class="rounded-lg">
        <card-base-modal outlined :loading="isLoading">
            <template v-slot:text>
                <v-card-text class="mt-3 py-2">
                    <v-row class="mx-0">
                        <v-col cols="12" style="padding-left: 0">
                            <v-chip color="background" class="text-primary rounded-lg pa-6 font-weight-bold" label>
                                Agregar
                            </v-chip>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12">
                            <div v-if="cameraReady">
                                <video ref="video" autoplay muted width="320" height="240" />
                            </div>
                            <button @click="initCamera">Iniciar cámara</button>
                            <button @click="stopCamera">Deterner cámara</button>
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
                            <v-btn class="bg-primary rounded-lg" flat size="large" block @click="register()">
                                Actualizar
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-actions>
            </template>
        </card-base-modal>
    </v-dialog>
</template>

<script setup>
import * as faceapi from 'face-api.js'
import { ref, onMounted, nextTick } from 'vue';
import CardBaseModal from '../../components/global/CardBaseModal.vue';

const items = [
    { text: 'Administrador', icon: 'mdi-account-outline' },
    { text: 'Jan 20, 1980', icon: 'mdi-calendar-outline' },
    { text: 'Tepic, Nay, Mex', icon: 'mdi-map-marker-outline' },
    { text: 'jose@gmail.com', icon: 'mdi-email-outline' },
    { text: '3112234567', icon: 'mdi-phone-outline' },
];

const openModal = ref(false);
const isLoading = ref(true);
const video = ref(null)


const updateText = (() => {
    openModal.value = true;
    isLoading.value = false;
})

const getDescriptor = async () => {
    const detection = await faceapi
        .detectSingleFace(video.value, new faceapi.TinyFaceDetectorOptions())
        .withFaceLandmarks()
        .withFaceDescriptor()
    if (!detection) throw new Error('No se detectó rostro')
    return Array.from(detection.descriptor)
}

const register = async () => {
    try {
        const descriptor = await getDescriptor()
        const email = prompt('Ingresa tu email para registrar')
        await axios.post('/user/update-face', { email, descriptor })
        alert('Rostro registrado')
    } catch (err) {
        alert(err.message)
    }
}


const cameraReady = ref(false)

const initCamera = async () => {
  cameraReady.value = true // muestra el <video>
  await nextTick()         // espera a que <video> se monte

  await faceapi.nets.tinyFaceDetector.loadFromUri('/models')
  await faceapi.nets.faceLandmark68Net.loadFromUri('/models')
  await faceapi.nets.faceRecognitionNet.loadFromUri('/models')

  const stream = await navigator.mediaDevices.getUserMedia({ video: true })

  if (video.value) {
    video.value.srcObject = stream
  } else {
    console.error('video.value es null')
  }
}

const stopCamera = () => {
  if (video.value && video.value.srcObject) {
    video.value.srcObject.getTracks().forEach(track => track.stop())
    video.value.srcObject = null
  }
}


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
    margin-right: 8px;
    /* Puedes reducir aún más, ej. 4px */
    padding: 0;
    font-size: 20px;
    /* Opcional: para que no sea muy grande */
    vertical-align: middle;
}
</style>