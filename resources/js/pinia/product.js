// store/area.js
import axios from 'axios';
import { defineStore } from 'pinia';

export const useProductStore = defineStore('area', {
    state: () => ({
        openModal: false
    }),
    actions: {
        storeProduct(payload){
            return new Promise((resolve, reject) => {
                axios.post("product/store", payload).then((response) => {
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },

        listProducts(){
            return new Promise((resolve, reject) => {
                axios.post("product/list").then((response) => {
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },

        listCategory(){
            return new Promise((resolve, reject) => {
                axios.post("category/list").then((response) => {
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },

        storeCategory(payload){
            return new Promise((resolve, reject) => {
                axios.post("category/store", payload).then((response) => {
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },
        openDialogCategory(payload){
            this.openModal = payload;
        },
        closeopenDialog(payload){
            this.openModal = payload;
        }
    }
});
