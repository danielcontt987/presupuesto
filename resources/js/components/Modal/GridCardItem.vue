<template>
    <v-card flat @click="$emit('card-click')" :class="padding" class="my-0">
        <v-card-text class="white--text d-flex justify-center align-center flex-column">
            <v-avatar color="primary" size="40">
                <v-icon size="30" color="white">
                    {{ icon }}
                </v-icon>
            </v-avatar>
            <h6 class="mt-3 text-uppercase" v-if="!smAndDown">
                {{ text }}
            </h6>
        </v-card-text>
    </v-card>
</template>

<script setup>
import { computed } from 'vue';
import { useDisplay } from 'vuetify';
const { smAndDown } = useDisplay();

const props = defineProps({
    isBigger: Boolean,
    text: String,
    icon: String
})

const padding = computed(() => {
    if (props.isBigger) return "py-8";
})

</script>

<style scoped>
.v-card {
    transition: 200ms !important;
}

.v-card:hover {
    transition: 200ms !important;
    cursor: pointer !important;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23) !important;
}
</style>