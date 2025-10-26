// store/area.js
import axios from 'axios';
import { defineStore } from 'pinia';

export const useCashCutStore = defineStore('cashcut', {
    state: () => ({
        cashcuts: [],
        openDialogCashCut: false,
        infoCashCut: null,
    }),
    actions: {
        listCashcuts(payload) {
            return new Promise((resolve, reject) => {
                axios.post("cashcut/get", payload).then((response) => {
                    this.cashcuts = response.data.cashcuts;
                    this.infoCashCut = response.data.cashcuts;
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
        dialogCashCut(payload) {
            this.openDialogCashCut = payload;
        }
    }
});