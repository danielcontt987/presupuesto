import axios from "axios";
import { defineStore } from "pinia";

export const useAreaStore = defineStore("area", {
    state: () => ({
        areas: null,
        isLoading: false,
        area_id: 0,
        permission: [],
        users: null,
    }),
    actions: {
       getArea(){
        this.isLoading = true;
        return new Promise((resolve, reject) => {
            axios.post('area/get')
                .then((response) => {
                    this.areas = response.data.area;
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
       setAreaId(payload){
        this.area_id = payload
       },
       consulInfo(){
        this.isLoading = true;
        return new Promise((resolve, reject) => {
            axios.post('area/consult-info')
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
    
       }
    },
});
