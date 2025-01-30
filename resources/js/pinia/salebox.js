// store/area.js
import axios from 'axios';
import { defineStore } from 'pinia';

export const useSaleboxStore = defineStore('salebox', {
    state: () => ({
        saleboxes: [],
    }),
    actions: {
        listSaleboxes(payload){            
            return new Promise((resolve, reject) => {
                axios.post("salebox/list", payload).then((response) => {
                    this.saleboxes = response.data.saleboxes;
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },
    }
});