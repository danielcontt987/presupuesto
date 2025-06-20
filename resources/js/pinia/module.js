import axios from "axios";
import { defineStore } from "pinia";

export const useModuleStore = defineStore("module", {
    state: () => ({
        show: false,
        modules: [],
        isLoading: false,
        showEdit: false,
        moduleEdit: null,
    }),
    actions: {
        listModule() {
            this.isLoading = true;
            return new Promise((resolve, reject) => {
                axios.post('module/list')
                    .then((response) => {
                        this.modules = response.data;
                        resolve(response);
                    })
                    .catch((error) => {
                        reject(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            });
        },
        storeModule(payload) {
            return new Promise((resolve, reject) => {
                axios.post('module/store', payload)
                    .then((response) => {
                        resolve(response);
                        this.listModule();  // Refresh the module list after storing a new module
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        updateModule(payload) {
            return new Promise((resolve, reject) => {
                axios.post('module/update', payload)
                    .then((response) => {
                        resolve(response);
                        this.listModule();
                    })
                    .catch((error) => {
                        reject(error);
                    });
            });
        },
        showModal(payload) {
            this.show = payload;
        },
        closeModal() {
            this.show = false;
        },
        showModalEdit(payload){
            this.showEdit = payload
        },
        closeModalEdit(payload) {
            this.showEdit = payload;
        },
        editModule(payload) {
            this.moduleEdit = payload;
        },
        clearModuleEdit(){
            this.moduleEdit = null;
        }
    },
});
