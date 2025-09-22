// store/area.js
import axios from 'axios';
import { defineStore } from 'pinia';

export const useCashCutStore = defineStore('cashcut', {
    state: () => ({
        cashcuts: [],
        openDialogCashCut: false,
    }),
    actions: {
        listCashcuts(payload) {
            return new Promise((resolve, reject) => {
                axios.post("cashcut/get", payload).then((response) => {
                    this.cashcuts = response.data.cashcuts;
                    if (!!this.cashcuts) {
                        this.openDialogCashCut = false;
                    } else {
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
            return new Promise(() => {
                axios.post("cashcut/store-box", payload).then((response) => {
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        }
    }
});