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
                                        :disabled="!isValid"
                                        @click="login"
                                    >
                                        Ingresar al checador
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
        <!-- <Alert /> -->
        <AlertError />
    </v-container>
</template>

<script setup>
import { ref } from "vue";
import { useDisplay } from "vuetify";
import { useAlertNormalStore } from "../pinia/alert.js";
import { useUserStore } from "../pinia/user.js";

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
</script>

<style>
.image-fullscreen {
    width: 100%;
    height: 90vh;
    object-fit: cover;
}
</style>
