<template>
    <grid-card-item
        color="#E5EBF2"
        icon="mdi-cash-refund"
        text="Corte de caja"
        @click="openDialog"
        :isBigger=false
    />
</template>

<script setup>
import GridCardItem from './GridCardItem.vue';

const openDialog = () => {

}
</script>