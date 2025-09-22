<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" md="10">
                <vc-back-button @backAction="navigateToHome"></vc-back-button>
            </v-col>
            <v-col cols="12" md="4">
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
            <v-col cols="12" md="8">
                <v-row>
                    <v-col cols="12" md="4" lg="4">
                        <v-card flat>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" md="4" class="d-flex justify-center align-center">
                                        <v-avatar size="56" color="white" class="shadow">
                                            <v-icon color="info" size="32" block>
                                                mdi-currency-usd
                                            </v-icon>
                                        </v-avatar>
                                    </v-col>
                                    <v-col cols="9" lg="10">
                                        <h4 class="text-uppercase font-weight-bold caption">
                                            {{ "Total ventas" }}
                                        </h4>
                                        <h2 class="primary--text font-weight-bold mt-3">
                                            {{ currency(parseFloat(1000)) }}
                                        </h2>
                                        <!-- <h2 class="primary--text font-weight-bold mt-3" :class="color + '--text'"
                                    v-if="isCurrency">
                                    {{ text | currency }}
                                </h2>
                                <h3 class="font-weight-bold mt-3" :class="color + '--text'" v-else>
                                    {{ text }}
                                </h3> -->
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="4" lg="4">
                        <v-card flat>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" md="4" class="d-flex justify-center align-center">
                                        <v-avatar size="56" color="white" class="shadow">
                                            <v-icon color="success" size="32" block>
                                                mdi-currency-usd
                                            </v-icon>
                                        </v-avatar>
                                    </v-col>
                                    <v-col cols="9" lg="10">
                                        <h4 class="text-uppercase font-weight-bold caption">
                                            {{ "Total de venta del día" }}
                                        </h4>
                                        <h2 class="primary--text font-weight-bold mt-3">
                                            {{ currency(parseFloat(1000)) }}
                                        </h2>
                                        <!-- <h2 class="primary--text font-weight-bold mt-3" :class="color + '--text'"
                                    v-if="isCurrency">
                                    {{ text | currency }}
                                </h2>
                                <h3 class="font-weight-bold mt-3" :class="color + '--text'" v-else>
                                    {{ text }}
                                </h3> -->
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="4" lg="4">
                        <v-card flat>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" md="4" class="d-flex justify-center align-center">
                                        <v-avatar size="56" color="white" class="shadow">
                                            <v-icon color="success" size="32" block>
                                                mdi-currency-usd
                                            </v-icon>
                                        </v-avatar>
                                    </v-col>
                                    <v-col cols="9" lg="10">
                                        <h4 class="text-uppercase font-weight-bold caption">
                                            {{ "Total" }}
                                        </h4>
                                        <h2 class="primary--text font-weight-bold mt-3">
                                            {{ currency(parseFloat(1000)) }}
                                        </h2>
                                        <!-- <h2 class="primary--text font-weight-bold mt-3" :class="color + '--text'"
                                    v-if="isCurrency">
                                    {{ text | currency }}
                                </h2>
                                <h3 class="font-weight-bold mt-3" :class="color + '--text'" v-else>
                                    {{ text }}
                                </h3> -->
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-col>
            <!-- <v-col cols="12" md="3">
                <v-row>
                    <v-col cols="12">
                        <v-btn large block class="rounded-lg" variant="outlined" depressed color="primaryBg"
                            @click="updateText()">
                            Actualizar datos
                        </v-btn>
                    </v-col>
                </v-row>
            </v-col> -->
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
import { ref, nextTick } from 'vue';
import CardBaseModal from '../../components/global/CardBaseModal.vue';
import VcBackButton from '../../components/global/BackButton.vue';
import { useRouter } from 'vue-router';
import accounting from 'accounting';



const router = useRouter();
const items = [
    { text: 'Administrador', icon: 'mdi-account-outline' },
    { text: 'Jan 20, 1980', icon: 'mdi-calendar-outline' },
    { text: 'Tepic, Nay, Mex', icon: 'mdi-map-marker-outline' },
    { text: 'jose@gmail.com', icon: 'mdi-email-outline' },
    { text: '3112234567', icon: 'mdi-phone-outline' },
];

const currency = (value) => {
    if (value >= 0) return accounting.formatMoney(value);
    else if (!!value) return accounting.formatMoney(Math.abs(value));
    else return accounting.formatMoney(0, "- $ ");
}

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

const navigateToHome = () => {
    router.push({ name: 'Inicio' });
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

.shadow {
    box-shadow: 0px 0px 16px #192a6733;
}
</style>


<!-- <template>
    <v-card class="pa-6 rounded-xl elevation-3">
        <v-row class="mb-6" justify="space-between" align="center">
            <v-col cols="12" md="6">
                <h2 class="text-h5 font-weight-bold">Editar Perfil de Empleado</h2>
            </v-col>
            <v-col cols="12" md="6" class="d-flex justify-end">
                <v-btn color="red-lighten-1" variant="tonal" class="mr-2" @click="onCancel">
                    <v-icon start>mdi-close</v-icon>Cancelar
                </v-btn>
                <v-btn color="primary" :loading="isLoading" @click="submit">
                    <v-icon start>mdi-content-save</v-icon>{{ isLoading ? 'Guardando...' : 'Guardar Cambios' }}
                </v-btn>
            </v-col>
        </v-row>

        <v-row justify="center" class="mb-4">
            <v-avatar size="96" class="elevation-3" @click="triggerFile" v-if="editable">
                <v-img :src="form.avatar || defaultAvatar" alt="avatar"></v-img>
                <v-overlay absolute opacity="0.4" color="black">
                    <v-icon color="white">mdi-camera</v-icon>
                </v-overlay>
            </v-avatar>
            <v-avatar size="96" class="elevation-3" v-else>
                <v-img :src="form.avatar || defaultAvatar" alt="avatar"></v-img>
            </v-avatar>
            <input ref="fileRef" type="file" accept="image/*" class="d-none" @change="handleFile" />
        </v-row>

        <v-form ref="formRef">
            <v-row dense>
                <v-col cols="12" md="6">
                    <v-text-field v-model="form.firstName" label="Nombre" :error-messages="errors.firstName" required />
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="form.lastName" label="Apellidos" :error-messages="errors.lastName"
                        required />
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="form.email" label="Email" :error-messages="errors.email" required />
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="form.phone" label="Teléfono" :error-messages="errors.phone" required />
                </v-col>
                <v-col cols="12" md="6">
                    <v-select :items="departments" item-title="name" item-value="id" v-model="form.department"
                        label="Departamento" />
                </v-col>
                <v-col cols="12" md="6">
                    <v-select :items="roles" item-title="name" item-value="id" v-model="form.role" label="Cargo" />
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="form.birthDate" type="date" label="Nacimiento" />
                </v-col>
                <v-col cols="12" md="6">
                    <v-text-field v-model="form.hireDate" type="date" label="Contratación" />
                </v-col>
                <v-col cols="12" md="6">
                    <v-select :items="contractTypes" v-model="form.contractType" label="Tipo de Contrato" />
                </v-col>
                <v-col cols="12" md="6">
                    <v-select :items="workLocations" v-model="form.workLocation" label="Modalidad de Trabajo" />
                </v-col>


<v-col cols="12">
                    <v-text-field v-model="form.address.street" label="Dirección" />
                </v-col>
<v-col cols="12" md="6">
                    <v-text-field v-model="form.address.city" label="Ciudad" />
                </v-col>
<v-col cols="12" md="6">
                    <v-text-field v-model="form.address.zipCode" label="Código Postal" />
                </v-col>

<v-col cols="12" md="4">
                    <v-text-field v-model="form.emergencyContact.name" label="Contacto de Emergencia *"
                        :error-messages="errors.emergencyContactName" />
                </v-col>
<v-col cols="12" md="4">
                    <v-text-field v-model="form.emergencyContact.relationship" label="Relación" />
                </v-col>
<v-col cols="12" md="4">
                    <v-text-field v-model="form.emergencyContact.phone" label="Teléfono de Emergencia *"
                        :error-messages="errors.emergencyContactPhone" />
                </v-col>
</v-row>
</v-form>
</v-card>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { VAvatar, VOverlay, VImg } from 'vuetify/components';

const defaultAvatar = 'https://via.placeholder.com/150';

const fileRef = ref(null);
const formRef = ref(null);
const isLoading = ref(false);
const editable = true;

const departments = [
    { id: 'dept_it', name: 'Tecnología de la Información' },
    { id: 'dept_hr', name: 'Recursos Humanos' },
    { id: 'dept_sales', name: 'Ventas' }
];

const roles = [
    { id: 'role_dev', name: 'Desarrollador' },
    { id: 'role_lead', name: 'Líder de Equipo' }
];

const contractTypes = [
    { title: 'Indefinido', value: 'permanent' },
    { title: 'Temporal', value: 'temporary' },
    { title: 'Contratista', value: 'contractor' },
    { title: 'Prácticas', value: 'intern' }
];

const workLocations = [
    { title: 'Oficina', value: 'office' },
    { title: 'Remoto', value: 'remote' },
    { title: 'Híbrido', value: 'hybrid' }
];

const form = reactive({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    avatar: '',
    birthDate: '',
    hireDate: '',
    department: '',
    role: '',
    contractType: '',
    workLocation: '',
    address: {
        street: '',
        city: '',
        zipCode: ''
    },
    emergencyContact: {
        name: '',
        relationship: '',
        phone: ''
    }
});

const errors = reactive({});

function triggerFile() {
    fileRef.value?.click();
}

function handleFile(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            form.avatar = reader.result;
        };
        reader.readAsDataURL(file);
    }
}

function validate() {
    errors.firstName = form.firstName ? '' : 'Nombre requerido';
    errors.lastName = form.lastName ? '' : 'Apellidos requeridos';
    errors.email = form.email.includes('@') ? '' : 'Email inválido';
    errors.phone = form.phone ? '' : 'Teléfono requerido';
    errors.emergencyContactName = form.emergencyContact.name ? '' : 'Nombre de contacto requerido';
    errors.emergencyContactPhone = form.emergencyContact.phone ? '' : 'Teléfono de contacto requerido';
    return Object.values(errors).every(err => !err);
}

function submit() {
    if (!validate()) return;
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
        alert('Cambios guardados.');
    }, 2000);
}

function onCancel() {
    alert('Cancelado.');
}
</script>

<style scoped>
.v-avatar {
    cursor: pointer;
    position: relative;
}
</style> -->