// store/area.js
import axios from 'axios';
import { defineStore } from 'pinia';

export const useCashCutStore = defineStore('cashcut', {
    state: () => ({
        cashcut: null,
        openDialogCashCut: false,
        infoCashCut: null,
        openSaleBox: false,
    }),
    actions: {
        listCashcuts(payload) {
            return new Promise((resolve, reject) => {
                axios.post("cashcut/get", payload).then((response) => {
                    this.infoCashCut = response.data.cashcut;
                    if (response.data.cashcut == null) {
                        this.openDialogCashCut = true;
                    }
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },

        storeCashcuts(payload) {
            return new Promise((resolve, reject) => {
                axios.post("cashcut/store", payload).then((response) => {
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
        dialog(payload) {
            this.openSaleBox = payload;
        },
        dialogCashCut(payload) {
            this.openDialogCashCut = payload;
        }
    }
});