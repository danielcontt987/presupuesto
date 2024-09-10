import axios from "axios";
import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
    state: () => ({
        email: '',
        password: '',
    }),
    actions: {
         login(payload){
            return new Promise ((resolve, reject) => {
                axios.post('user/login', payload).then((response) =>{
                    resolve(response)
                }).catch((error) => {
                    reject(error)
                })
            })
        },

        logout(){
            return new Promise ((resolve, reject) => {
                axios.post('user/logout').then((response) =>{
                    resolve(response)
                }).catch((error) => {
                    reject(error)
                })
            })
        },

        consultUser(){
            return new Promise((resolve, reject) => {
                axios.post("user/consult-user").then((response) =>{
                    resolve(response)
                }).catch((error) => {
                    reject(error)
                })
            })
        }

    }
});
