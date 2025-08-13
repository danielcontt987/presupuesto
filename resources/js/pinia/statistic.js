import axios from "axios";
import { defineStore } from "pinia";

export const useStatisticStore = defineStore("statistic", {
    state: () => ({
        sales: [],
    }),
    actions: {
        consultSale(params) {
            return new Promise((resolve, reject) => {
                axios.get("pointsales/list", { params }).then((response) => {
                    this.sales = response.data.sales;
                    resolve(response)
                }).catch((error) => {
                    reject(error)
                })
            })
        }
    }
});
