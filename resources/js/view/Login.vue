<template>
    <v-container
        fluid
        class="d-flex flex-column bg-background fill height" style="height: 100vh; overflow: hidden;"
        :class="mdAndUp ? 'pa-0' : ''"

    >
        <v-row align="center" justify="center">
            <v-col cols="12" md="6">
                <v-card
                    class="elevation-0 pa-3  mx-auto rounded-lg"
                    max-width="500px"
                >
                    <h2
                        class="text-center text-primary font-weight-bold pt-3"
                        style="word-break: break-word"
                    >
                        INICIAR SESIÓN
                    </h2>
                    <p class="text-center pt-3">
                        Ingresa las crendenciales para acceder al sistema
                    </p>
                    <v-card-text class="pt-5">
                        <v-form v-model="isValid">
                            <v-row no-gutters>
                                <v-col cols="12">
                                    <v-text-field
                                        color="primary"
                                        label="Correo electrónico"
                                        variant="outlined"
                                        class="rounded-lg"
                                        v-model="email"
                                        :rules="emailRules"
                                        autocomplete="email"
                                    />
                                </v-col>
                                <v-col cols="12" class="pt-3">
                                    <v-text-field
                                        color="primary"
                                        label="Contraseña"
                                        variant="outlined"
                                        v-model="password"
                                        :rules="passwordRules"
                                        class="rounded-lg"
                                        :append-inner-icon="
                                            show ? 'mdi-eye' : 'mdi-eye-off'
                                        "
                                        :type="show ? 'text' : 'password'"
                                        @click:append-inner="show = !show"
                                        autocomplete="current-password"
                                    >
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" class="pt-5">
                                    <v-btn
                                        color="primary"
                                        flat
                                        size="large"
                                        block
                                        :loading="loading"
                                        :disabled="!isValid"
                                        @click="login"
                                    >
                                        Iniciar sesión
                                    </v-btn>
                                </v-col>
                                <v-col cols="12" class="pt-5">
                                    <v-btn
                                        color="primary"
                                        flat
                                        size="large"
                                        block
                                        variant="outlined"
                                        :loading="loading"
                                        :disabled="!isValid"
                                        @click="login"
                                    >
                                        Olvide mi contraseña
                                    </v-btn>
                                </v-col>
                                <v-col cols="12" class="pt-5">
                                    <v-btn
                                        color="black"
                                        flat
                                        size="large"
                                        block
                                        variant="text"
                                        :loading="loading"
                                        @click="openDialogQr"
                                    >
                                        Ingresar con qr
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="6" v-if="mdAndUp == true" class="overflow-hidden bg-lightprimary">
                <v-img
                    src="https://software.tidingo.com/images/login_picture.jpg"
                    height="100vh"
                    class="elevation-6 bg-lightprimary"
                    style="width: 100%;"
                    cover
                />
            </v-col>
        </v-row>
        <v-dialog v-model="dialogQr" width="450" persistent>
           <card-base-modal outlined>
                <template v-slot:text>
                    <v-card-text class="mt-3 py-2">
                        <v-row class="mx-0">
                            <v-col cols="12" style="padding-left: 0">
                                <v-chip color="background" class="text-primary rounded-lg pa-6 font-weight-bold" label>
                                    Escanner QR
                                </v-chip>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <div id="qr-reader" style="width: 100%;"></div>
                                <div v-if="loadingQr" class="text-center my-4">
                                <v-progress-circular indeterminate color="primary" size="50" />
                                <div>Procesando QR...</div>
                                </div>

                                <p v-if="qrContent">✅ Resultado: <strong>{{ qrContent }}</strong></p>
                                <p v-if="error" class="text-red">❌ Error: {{ error }}</p>
                            </v-col>
                        </v-row>
                        <v-row class="my-0 py-0">
                            <v-col cols="12">
                                <v-btn class="rounded-lg" flat size="large" block color="primary" @click="iniciarScanner">Iniciar</v-btn>
                            </v-col>
                            <v-col cols="12">
                                <v-btn class="rounded-lg" flat size="large" block color="error" @click="detenerScanner">Detener</v-btn>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </template>
                <template v-slot:actions>
                    <v-card-actions class="mt-3 py-2">
                        <v-row>
                            <v-col cols="12">
                                <v-btn class="rounded-lg"  text depressed  flat size="large" block color="error"
                                    @click="closeDialogQr">
                                    Cerrar
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card-actions>
                </template>
            </card-base-modal>
        </v-dialog>
        <AlertError />
    </v-container>
</template>

<script setup>
import { onBeforeUnmount, ref } from "vue";
import { useDisplay } from "vuetify";
import { useAlertNormalStore } from "../pinia/alert.js";
import { useUserStore } from "../pinia/user.js";
import { Html5Qrcode } from 'html5-qrcode'
import CardBaseModal from "../components/global/CardBaseModal.vue";

const { mdAndUp } = useDisplay();
const userStore = useUserStore();
const alertNormal = useAlertNormalStore();
//Data
const show = ref(false);
const isValid = ref(false);
const email = ref("");
const password = ref("");
const openDialogLogout = ref(false);
const loading = ref(false);
const loadingQr = ref(false);
const dialogQr = ref(false);
const qrContent = ref('')
const qr = ref('')
const error = ref('')
let qrScanner = null
let escaneado = false


const emailRules = [
    (value) => {
        if (value) return true;
        return "Favor de ingresar una correo electrónico";
    },
    (value) => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailRegex.test(value)) {
            return true;
        } else {
            return "Favor de ingresar un correo electrónico válido ej. correo@hotmal.com";
        }
    },
];

const passwordRules = [
    (value) => {
        if (value) return true;
        return "Favor de ingresar una contraseña";
    },
];

const login = () => {
    loading.value = true;
    let params = {
        email: email.value,
        password: password.value,
    };
    userStore
        .login(params)
        .then((res) => {
            loading.value = false;
            window.location.href = "/inicio";
        })
        .catch((err) => {
            alertNormal.show = true;
            (alertNormal.color = "fail"),
                (alertNormal.msg =
                    "Las credenciales no son las correctas favor de verificar el email y la contraseña"),
                (alertNormal.type = 0),
                (alertNormal.icon = "mdi-close-circle-outline");
        }).finally(() =>{
            loading.value = false;
        });
};

const loginQrAuth = (qrContent) => {
    loading.value = true;
    let params = {
        qr: qrContent,
    };
    userStore
        .loginQr(params)
        .then((res) => {
            loading.value = false;
            window.location.href = "/inicio";
        })
        .catch((err) => {
            alertNormal.show = true;
            (alertNormal.color = "fail"),
                (alertNormal.msg =
                    "Las credenciales no son las correctas favor de verificar el email y la contraseña"),
                (alertNormal.type = 0),
                (alertNormal.icon = "mdi-close-circle-outline");
        }).finally(() =>{
            loading.value = false;
        });
};

const openDialogQr = () => {
    dialogQr.value = true;
};

const closeDialogQr = () => {
    dialogQr.value = false;
    qrContent.value = '',
    error.value = ''
    escaneado = false
};

const iniciarScanner = async () => {
  if (qrScanner || escaneado) return

  qrContent.value = ''
  error.value = ''
  escaneado = false

  qrScanner = new Html5Qrcode("qr-reader")

  try {
    await qrScanner.start(
      { facingMode: "environment" },
      { fps: 10, qrbox: { width: 250, height: 250 } },
      async (decodedText) => {
        if (!escaneado) {
          escaneado = true
          loading.value = true

          try {
            // ✅ Aquí haces tu petición con axios
            const res = await axios.post('/user/login-qr', {
              qr: decodedText
            })

            qrContent.value = res.data.mensaje || 'Código verificado con éxito'

            loading.value = false;
            window.location.href = "/inicio";

            closeDialogQr();

          } catch (e) {
            error.value = e.response?.data?.message || 'Error al procesar el QR.'
          } finally {
            loading.value = false
            detenerScanner()
          }
        }
      },
      (scanError) => {
        console.log("Error de escaneo (ignorado):", scanError)
      }
    )
  } catch (err) {
    error.value = 'No se pudo iniciar el escáner.'
    console.error(err)
  }
}


const detenerScanner = () => {
  if (qrScanner) {
    qrScanner.stop().then(() => {
      qrScanner.clear()
      qrScanner = null
    }).catch(err => console.error("Error al detener escáner:", err))
  }
}

onBeforeUnmount(() => {
  detenerScanner()
})
</script>

<style>
.image-fullscreen {
    width: 100%;
    height: 90vh;
    object-fit: cover;
}
</style>
