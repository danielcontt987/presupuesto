import axios from "axios";
import { defineStore } from "pinia";
import { useAlertNormalStore } from "./alert.js";

export const useSettingStore = defineStore("setting", {
    state: () => ({
        business: null,
        isLoading: false,
    }),
    actions: {
         getSetting() {
            this.isLoading = true; // Empieza la carga
            return new Promise((resolve, reject) => {
                axios.post('setting/get')
                    .then((response) => {
                        this.business = response.data;
                        resolve(response);
                    })
                    .catch((error) => {
                        console.error("Error fetching settings:", error);
                        this.business = null; // Asegura que business sea null en caso de error
                        reject(error);
                    })
                    .finally(() => {
                        this.isLoading = false; // Termina la carga
                    });
            });
        },

        updatePart1(payload) {
            return new Promise((resolve, reject) => {
                axios.post("setting/update-part-1", payload)
                    .then((response) => {
                        resolve(response);
                        this.getSetting();
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        }        
    },
});
