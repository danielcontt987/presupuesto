<template>
    <v-card :color="color" :class="padding" flat @click="$emit('click')" class="my-0 rounded-lg">
        <v-card-text class="white--text d-flex justify-center align-center flex-column">
            <v-icon size="50" color="white">
                {{ icon }}
            </v-icon>
            <h4 class="mt-3 text-uppercase colorText">
                {{ text }}
            </h4>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    props: {
        color: {
            type: String,
            required: true,
        },
        icon: {
            type: String,
            required: true,
        },
        text: {
            type: String,
            required: true,
        },
        isBigger: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        padding() {
            if (this.isBigger) return "py-8";
        },
    },
}
</script>

<style scoped>
.v-card {
    transition: 200ms !important;
}
.colorText{
    color: white !important;
}

.v-card:hover {
    transition: 200ms !important;
    cursor: pointer !important;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23) !important;
}
</style>