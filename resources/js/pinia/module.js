import axios from "axios";
import { defineStore } from "pinia";

export const useModuleStore = defineStore("module", {
    state: () => ({
       show: false,
    }),
    actions: {
        showModal(payload){
            this.show = payload
        },

        closeModal(payload){
            this.show = payload
        }
    },
});
