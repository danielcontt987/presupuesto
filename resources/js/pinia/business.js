// store/area.js
import axios from 'axios';
import { defineStore } from 'pinia';

export const useBusinessStore = defineStore('business', {
    state: () => ({
        business: null,
    }),
    actions: {
        listBusiness() {
            return new Promise((resolve, reject) => {
                axios.get("business/list").then((response) => {
                    this.business = response.data.business;
                    resolve(response);
                }).catch((error) => {
                    reject(error)
                })
            })
        },
    }
});