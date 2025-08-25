<template>
    <v-card flat>
        <v-card-text>
            <v-row>
                <v-col cols="3" lg="2" class="d-flex justify-center align-center" v-if="showAvatar">
                    <v-avatar size="56" color="white" class="shadow">
                        <v-icon :color="color" size="32" block>{{ icon }}</v-icon>
                    </v-avatar>
                </v-col>
                <v-col cols="9" lg="10">
                    <h4 class="text-uppercase font-weight-bold caption">
                        {{ title }}
                    </h4>
                    <h4 class="text-uppercase font-weight-bold caption" v-if="title2 && text !== 0">
                        {{ title2 }}
                    </h4>
                    <h4 class="text-uppercase font-weight-bold caption" v-if="title3 && text !== 0">
                        {{ title3 }}
                    </h4>
                    <h2 class="primary--text font-weight-bold mt-3" :class="'text-' + color" v-if="isCurrency">
                        {{ formatCurrency(text) }}
                    </h2>
                    <h3 class="font-weight-bold mt-3" :class="'text-' + color" v-else>
                        {{ text }}
                    </h3>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script setup>

const props = defineProps({
    icon: String,
    title: { type: String, required: true },
    title2: { type: String, default: '' },
    title3: { type: String, default: '' },
    text: { type: [String, Number], default: 0 },
    color: { type: String, default: 'primary', required: true },
    isCurrency: { type: Boolean, default: false },
    showAvatar: { type: Boolean, default: true },
})

const formatCurrency = (value) => {
    if (isNaN(value)) return value
    return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(value)
}
</script>

<style scoped>
.shadow {
    box-shadow: 0px 0px 16px #192a6733;
}
</style>
