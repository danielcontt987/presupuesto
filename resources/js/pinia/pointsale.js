// store/area.js
import axios from 'axios';
import { defineStore } from 'pinia';

export const usePointsaleStore = defineStore('pointsale', {
    state: () => ({
        products: [],
    }),
    actions: {
        addProducts(payload){
            console.log(payload);
            
            this.products.push(payload);
        },

        removeProducts(payload){
            this.products = this.products.filter(product => product.id != payload.id);
        }
    }
});
