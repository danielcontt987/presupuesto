<template>
    <v-dialog :model-value="modelValue" @update:model-value="$emit('update:modelValue', $event)" width="400"
        transition="dialog-bottom-transition" persistent>
        <v-card flat class="ma-2 rounded-card" style="overflow: hidden !important">
            <v-row>
                <v-date-picker class="ma-2 pa-0 text-center" v-model="tempDateProxy" width="800" :max="endDate || today"
                    :min="startDate > endDate ? startDate : null" color="primary" />
            </v-row>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" class="rounded-lg" x-large text depressed block @click="accept">
                    Aceptar
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    modelValue: Boolean,
    tempDate: String,
    dateType: String,
    startDate: String,
    endDate: String,
    today: String,
});

const emits = defineEmits(["update:modelValue", "update:tempDate", "accept"]);

const tempDateProxy = computed({
    get: () => props.tempDate,
    set: (val) => emits("update:tempDate", val),
});

const accept = () => {
    emits("accept", props.dateType);
    emits("update:modelValue", false);
};
</script>
