<template>
    <!-- <v-card :class="['rounded-3xl']" :style="styles.container"
        class="pa-8 border-2 transition-transform cursor-pointer shadow" @click="handleClick" hover>
         Header
        <div class="d-flex justify-space-between mb-6">
            <div class="d-flex align-center" style="margin-top: -70px; margin-left: -20px;">
                <v-chip label size="small" class="bg-primary">
                    <v-icon left size="small">
                        mdi-account
                    </v-icon>
                    <span class="text-center font-weight-bold pl-2">{{
                        table.capacity
                    }}</span>
                </v-chip>
            </div>
            <div class="d-flex align-center gap-3">
                <v-avatar size="50" color="white" class="shadow">
                    <span class="text-h6 text-primary">{{ table.number }}</span>
                </v-avatar>
            </div>
            <div v-if="table.status == 'available'">
                <v-avatar :color="statusIcon.color" style="box-shadow: -1px 1px 5px 5px #8bffc0;">
                    <v-icon color="white">{{ statusIcon.icon }}</v-icon>
                </v-avatar>
            </div>
            <div v-else-if="table.status == 'occupied'">
                <v-avatar :color="statusIcon.color" style="box-shadow: -1px 1px 5px 5px #ff7b87;">
                    <v-icon color="white">{{ statusIcon.icon }}</v-icon>
                </v-avatar>
            </div>
            <div v-else>
                <v-avatar :color="statusIcon.color" style="box-shadow: -1px 1px 5px 5px #fee1b5;">
                    <v-icon color="white">{{ statusIcon.icon }}</v-icon>
                </v-avatar>
            </div>
        </div>

        Content
        <div class="d-flex flex-column gap-4">
            Occupied
            <template v-if="table.status === 'occupied'">
                <v-card v-if="table.customerName" class="d-flex align-center gap-3 pa-3 rounded-xl" color="white"
                    variant="tonal">
                    <v-avatar color="blue-darken-2">
                        <v-icon color="white" size="20">mdi-account-group</v-icon>
                    </v-avatar>
                </v-card>

                <v-card v-if="getTimeSeated()" class="d-flex align-center gap-3 pa-3 rounded-xl" color="white"
                    variant="tonal">
                    <v-avatar color="indigo-darken-2">
                        <v-icon color="white" size="20">mdi-clock</v-icon>
                    </v-avatar>
                </v-card>
            </template>
        </div>
    </v-card> -->

    <v-card
  flat
  class="pa-2 border-2 transition-transform cursor-pointer shadow position-relative"
  @click="handleClick"
>
  <!-- Chip arriba a la derecha -->
  <v-chip
    label
    small
    color="primary"
    class="position-absolute"
    style="top: 16px; right: 16px;"
  >
    <v-icon left v-if="mdAndUp" small>mdi-account</v-icon>
    <span class="text-center font-weight-bold">32</span>
  </v-chip>

  <v-card-text>
    <v-row no-gutters justify="center" align="center" class="flex-column">
      <!-- Avatar centrado -->
      <v-avatar
        color="#00CFB5"
        :size="60"
        class="bordered-avatar mb-4"
      >
        <span class="text-white font-bold">{{ 21 }}</span>
      </v-avatar>

      <!-- Texto Mesa debajo del avatar -->
      <h4 class="text-uppercase text-center">Mesa</h4>
    </v-row>
  </v-card-text>
</v-card>

</template>

<script setup>
import { computed } from 'vue';
import { useDisplay } from 'vuetify';
const {mdAndUp} = useDisplay();

const props = defineProps({
    table: Object,
});

const emit = defineEmits(['select']);

const handleClick = () => {
    emit('select', props.table);
};

// const getStatusStyles = () => {
//     switch (props.table.status) {
//         case 'available':
//             return {
//                 container: 'bg-green-gradient',
//                 glow: ''
//             };
//         case 'occupied':
//             return {
//                 container: 'bg-rose border-red-lighten-3',
//                 glow: ''
//             };
//         case 'reserved':
//             return {
//                 container: 'bg-amber-lighten-5 border-amber-lighten-3',
//                 glow: ''
//             };
//         default:
//             return {
//                 container: 'bg-grey-lighten-4 border-grey-lighten-2',
//                 glow: ''
//             };
//     }
// };

const getStatusStyles = () => {
    switch (props.table.status) {
        case 'available':
            return {
                container: {
                    background: 'linear-gradient(to right, #ecfdf5, #d1fae5)',
                    borderColor: '#a7f3d0'
                },
                glow: ''
            };
        case 'occupied':
            return {
                container: {
                    background: 'linear-gradient(to right, #fee2e2, #fce7f3)',
                    borderColor: '#fecaca'
                },
                glow: ''
            };
        case 'reserved':
            return {
                container: {
                    background: 'linear-gradient(to right, #fef3c7, #ffedd5)',
                    borderColor: '#fcd34d'
                },
                glow: ''
            };
        default:
            return {
                container: {
                    backgroundColor: '#f3f4f6',
                    borderColor: '#e5e7eb'
                },
                glow: ''
            };
    }
};



const styles = computed(() => getStatusStyles());

const statusIcon = computed(() => {
    switch (props.table.status) {
        case 'available':
            return { icon: 'mdi-check-circle', color: 'green-darken-2' };
        case 'occupied':
            return { icon: 'mdi-account-group', color: 'red-darken-2' };
        case 'reserved':
            return { icon: 'mdi-clock-outline', color: 'amber-darken-2' };
        default:
            return { icon: 'mdi-help-circle', color: 'grey' };
    }
});

const getTimeSeated = () => {
    if (props.table.timeSeated) {
        const now = new Date();
        const diff = now.getTime() - new Date(props.table.timeSeated).getTime();
        const minutes = Math.floor(diff / (1000 * 60));
        return `${minutes} min`;
    }
    return null;
};

const getTotalAmount = () => {
    return props.table.orders.reduce((total, order) => total + (order.price * order.quantity), 0);
};
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

.green-gradient{
    background: linear-gradient(to right, #ecfdf5, #d1fae5);
    border-color: #a7f3d0;
}
</style>
