// store/area.js
import axios from 'axios';
import { defineStore } from 'pinia';

export const usePointsaleStore = defineStore('pointsale', {
    state: () => ({
        products: [],
    }),
    actions: {
        addProducts(payload) {
            const existing = this.products.find(p => p.id === payload.id)
            if (existing) {
                existing.quantity += 1
            } else {
                this.products.push({ ...payload, quantity: 1 })
            }
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
        }
    }
});
