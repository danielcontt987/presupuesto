<template>
    <v-card class="rounded-lg" flat>
        <v-card-title>
            <v-row>
                <v-col cols="12" md="9">
                    <v-chip color="background" :style="size ? 'width: 100%; text-align: center' : ''"
                        :class="size ? 'd-flex justify-center' : ''"
                        class="text-primary rounded-lg pa-5 font-weight-bold text-uppercase" label>
                        Filtros
                    </v-chip>
                </v-col>
            </v-row>
        </v-card-title>
        <v-card-text class="mt-3">
            <v-row>
                <v-col cols="12" md="5">
                    <v-text-field variant="outlined" v-model="startDateProxy" label="Fecha de inicio"
                        prepend-inner="mdi-calendar" @click.append="$emit('show-date-picker', 'start')" clearable />
                </v-col>
                <v-col cols="12" md="5">
                    <v-text-field variant="outlined" v-model="endDateProxy" label="Fecha de final"
                        @click.append="$emit('show-date-picker', 'end')" clearable />
                </v-col>
                <v-col cols="12" md="2">
                    <v-btn @click="$emit('filter')" size="x-large" block color="primary" flat>
                        Filtrar
                    </v-btn>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-text-field variant="outlined" v-model="searchProxy" label="Buscar" clearable />
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script setup>
import { computed } from "vue";
import { useDisplay } from "vuetify";

const props = defineProps({
    startDate: String,
    endDate: String,
    search: String,
});

const emits = defineEmits(["update:startDate", "update:endDate", "update:search", "filter", "show-date-picker"]);

const display = useDisplay();
const size = computed(() => !display.mdAndUp.value);

const startDateProxy = computed({
    get: () => props.startDate,
    set: (val) => emits("update:startDate", val),
});
const endDateProxy = computed({
    get: () => props.endDate,
    set: (val) => emits("update:endDate", val),
});
const searchProxy = computed({
    get: () => props.search,
    set: (val) => emits("update:search", val),
});
</script>
<template>
    <v-card class="rounded-lg" flat>
        <v-card-title>
            <v-row>
                <v-col cols="12" md="9">
                    <v-chip color="background" :style="size ? 'width: 100%; text-align: center' : ''"
                        :class="size ? 'd-flex justify-center' : ''"
                        class="text-primary rounded-lg pa-5 font-weight-bold text-uppercase" label>
                        Filtros
                    </v-chip>
                </v-col>
            </v-row>
        </v-card-title>
        <v-card-text class="mt-3">
            <v-row>
                <v-col cols="12" md="5">
                    <v-text-field variant="outlined" v-model="startDateProxy" label="Fecha de inicio"
                        prepend-inner="mdi-calendar" @click.append="$emit('show-date-picker', 'start')" clearable />
                </v-col>
                <v-col cols="12" md="5">
                    <v-text-field variant="outlined" v-model="endDateProxy" label="Fecha de final"
                        @click.append="$emit('show-date-picker', 'end')" clearable />
                </v-col>
                <v-col cols="12" md="2">
                    <v-btn @click="$emit('filter')" size="x-large" block color="primary" flat>
                        Filtrar
                    </v-btn>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-text-field variant="outlined" v-model="searchProxy" label="Buscar" clearable />
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script setup>
import { computed } from "vue";
import { useDisplay } from "vuetify";

const props = defineProps({
  startDate: String,
  endDate: String,
  search: String,
});

const emits = defineEmits(["update:startDate", "update:endDate", "update:search", "filter", "show-date-picker"]);

const display = useDisplay();
const size = computed(() => !display.mdAndUp.value);

const startDateProxy = computed({
  get: () => props.startDate,
  set: (val) => emits("update:startDate", val),
});
const endDateProxy = computed({
  get: () => props.endDate,
  set: (val) => emits("update:endDate", val),
});
const searchProxy = computed({
  get: () => props.search,
  set: (val) => emits("update:search", val),
});
</script>
<template>
    <v-card class="rounded-lg" flat>
        <v-card-title>
            <v-row>
                <v-col cols="12" md="9">
                    <v-chip color="background" :style="size ? 'width: 100%; text-align: center' : ''"
                        :class="size ? 'd-flex justify-center' : ''"
                        class="text-primary rounded-lg pa-5 font-weight-bold text-uppercase" label>
                        Filtros
                    </v-chip>
                </v-col>
            </v-row>
        </v-card-title>
        <v-card-text class="mt-3">
            <v-row>
                <v-col cols="12" md="5">
                    <v-text-field variant="outlined" v-model="startDateProxy" label="Fecha de inicio"
                        prepend-inner="mdi-calendar" @click.append="$emit('show-date-picker', 'start')" clearable />
                </v-col>
                <v-col cols="12" md="5">
                    <v-text-field variant="outlined" v-model="endDateProxy" label="Fecha de final"
                        @click.append="$emit('show-date-picker', 'end')" clearable />
                </v-col>
                <v-col cols="12" md="2">
                    <v-btn @click="$emit('filter')" size="x-large" block color="primary" flat>
                        Filtrar
                    </v-btn>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-text-field variant="outlined" v-model="searchProxy" label="Buscar" clearable />
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script setup>
import { computed } from "vue";
import { useDisplay } from "vuetify";

const props = defineProps({
  startDate: String,
  endDate: String,
  search: String,
});

const emits = defineEmits(["update:startDate", "update:endDate", "update:search", "filter", "show-date-picker"]);

const display = useDisplay();
const size = computed(() => !display.mdAndUp.value);

const startDateProxy = computed({
  get: () => props.startDate,
  set: (val) => emits("update:startDate", val),
});
const endDateProxy = computed({
  get: () => props.endDate,
  set: (val) => emits("update:endDate", val),
});
const searchProxy = computed({
  get: () => props.search,
  set: (val) => emits("update:search", val),
});
</script>
