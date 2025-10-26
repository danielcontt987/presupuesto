// store/area.js
import axios from 'axios';
import { defineStore } from 'pinia';

export const useSaleboxStore = defineStore('salebox', {
    state: () => ({
        saleboxes: [],
        openDialogBox: false,
    }),
    actions: {
        listSaleboxes(payload) {
            return new Promise((resolve, reject) => {
                axios.post("salebox/list", payload).then((response) => {
                    this.saleboxes = response.data.saleboxes;
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },
        storeBox(payload) {
            return new Promise((resolve, reject) => {
                axios.post("cashcut/store-box", payload).then((response) => {
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },
        dialogBox(payload) {
            this.openDialogBox = payload;
        }
    }
});