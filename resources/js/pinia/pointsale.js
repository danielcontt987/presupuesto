// store/area.js
import axios from 'axios';
import { defineStore } from 'pinia';

export const usePointsaleStore = defineStore('pointsale', {
    state: () => ({
        products: [],
        openDialogSell: false,
    }),
    actions: {
        addProducts(payload) {
            this.products.push(payload);
        },

        removeProducts(payload) {
            this.products = this.products.filter(product => product.id != payload.id);
        },

        storeSale(payload) {
            return new Promise((resolve, reject) => {
                axios.post("sale/store", payload).then((response) => {
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },

        clearSale() {
            this.products = [];
        },

        openDialogSeller(payload) {
            this.openDialogSell = payload;
        },
    }
});
