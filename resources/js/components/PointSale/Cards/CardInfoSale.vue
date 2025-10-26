<template>
    <v-card color="primary" flat class="white--text py-6 px-4 my-0 rounded-lg" height="100%">
        <v-row align="center" justify="center">
            <v-col cols="4">
                <p>Cantidad de artículos</p>
                <!-- <p>Subtotal</p> -->
                <p>Descuento directo</p>
                <p>Subtotal</p>
                <p>IVA</p>
                <h2 class="font-weight-bold">Total</h2>
            </v-col>
            <v-col cols="8">
                <p class="text-right">{{ productsCount }}</p>
                <!-- <p class="text-right">{{ "$" + subtotal.toFixed(2) }}</p> -->
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p class="text-right">$0.00</p>
                <p class="text-right">$0.00</p>
                <p class="text-right">$0.00</p>
                <h2 class="font-weight-bold text-right">{{ "$" + total.toFixed(2) }}</h2>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
export default {
    props: {
        productsCount: {
            type: Number,
            required: true,
        },

        // subtotal:{
        //     type: Number,
        //     required: true,
        // },

        // iva:{
        //     type: Number,
        //     required: true,
        // },

        total: {
            type: Number,
            required: true,
        },
    },


}
</script>

<style></style>