// store/area.js
import axios from 'axios';
import { defineStore } from 'pinia';

export const useAreaStore = defineStore('area', {
    state: () => ({
        areas: null,
        isLoading: false,
        area_id: 0,
        permission: [],
        users: null,
    }),
    actions: {
        updatePermission(id, permissionData) {            
            const permission = this.permission.find(p => p.module_id === permissionData.module_id);
            if (permission) {
                permission.granted = !id;
            }
        },
        getArea() {
            this.isLoading = true;
            return new Promise((resolve, reject) => {
                axios.post('area/get')
                    .then((response) => {
                        this.areas = response.data.area;
                        resolve(response);
                    })
                    .catch((error) => {
                        console.error("Error fetching settings:", error);
                        this.areas = null;
                        reject(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            });
        },
        setAreaId(payload) {
            this.area_id = payload;
        },
        consulInfo(payload) {
            this.isLoading = true;
            return new Promise((resolve, reject) => {
                axios.post('area/consult-info', payload)
                    .then((response) => {
                        this.area = response.data.area;
                        this.permission = response.data.permissions;
                        this.users = response.data.user;
                        resolve(response);
                    })
                    .catch((error) => {
                        console.error("Error fetching settings:", error);
                        this.area = null;
                        reject(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            });
        },
        savePermission(payload){
            return new Promise((resolve, reject) => {
                axios.post('area/store-permission', payload).then((response) => {
                    resolve(response)
                }).catch((error) => {
                    reject(error);
                })
            })
        }
    },
});
