<template>
    <v-col cols="12" md="3">
        <v-card flat class="pa-2 border-2 transition-transform cursor-pointer shadow position-relative"
            @click="handleClick">
            <!-- Chip arriba a la derecha -->
            <v-chip label small color="primary" class="position-absolute" style="top: 16px; right: 16px;">
                <v-icon left v-if="mdAndUp" small>mdi-account</v-icon>
                <span class="text-center font-weight-bold">{{ table.capacity }}</span>
            </v-chip>

            <v-card-text>
                <v-row no-gutters justify="center" align="center" class="flex-column">
                    <!-- Avatar centrado -->
                    <v-avatar v-if="table.status == 'available'" :color="colors('available')" :size="60"
                        class="bordered-avatar mb-4 font-weight-bold">
                        <span class="text-white font-bold">{{ table.number }}</span>
                    </v-avatar>
                    <v-avatar v-if="table.status == 'unavailable'" :color="colors('unavailable')" :size="60"
                        class="bordered-avatar mb-4 font-weight-bold">
                        <span class="text-white font-bold">{{ table.number }}</span>
                    </v-avatar>
                    <v-avatar v-if="table.status == 'reserved'" :color="colors('reserved')" :size="60"
                        class="bordered-avatar mb-4 font-weight-bold">
                        <span class="text-white font-bold">{{ table.number }}</span>
                    </v-avatar>

                    <!-- Texto Mesa debajo del avatar -->
                    <h4 class="text-uppercase text-center">{{ table.name }}</h4>
                </v-row>
            </v-card-text>
        </v-card>
    </v-col>
</template>

<script setup>
import { useDisplay } from 'vuetify';
const { mdAndUp } = useDisplay();

const props = defineProps({
    table: Object,
});

const emit = defineEmits(['select']);

const handleClick = () => {
    emit('select', props.table);
};

const colors = (color) => {
    switch (color) {
        case 'available':
            return 'greenLight';
        case 'unavailable':
            return 'fail';
        default:
            return 'grey';
    }
}

</script>

<style scoped>
.position-absolute {
    position: absolute;
}

.gap-3 {
    gap: 12px;
}

.mb-6 {
    margin-bottom: 24px;
}

.pa-8 {
    padding: 32px;
}

.shadow {
    box-shadow: 0px 0px 25px #192a6733;
}

.green-gradient {
    background: linear-gradient(to right, #ecfdf5, #d1fae5);
    border-color: #a7f3d0;
}
</style>
