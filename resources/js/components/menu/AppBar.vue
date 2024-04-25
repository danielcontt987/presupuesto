<template>
  <v-app-bar color="white">
        <template v-slot:prepend>
            <v-btn icon>
                <v-icon variant="text" class="text-grey"> mdi-menu </v-icon>
            </v-btn>
        </template>
        <v-app-bar-title> Presupuesto </v-app-bar-title>
        <template v-slot:append>
            <router-link to="/login">
                <v-btn
                    variant="outlined"
                    color="primary"
                    class="mr-3 rounded-lg"
                >
                    Iniciar sesión</v-btn
                >
            </router-link>
        </template>
    </v-app-bar>
</template>

<script>
export default {

}
</script>

<style>

</style>