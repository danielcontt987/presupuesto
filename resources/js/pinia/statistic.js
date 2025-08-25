import axios from "axios";
import { defineStore } from "pinia";

export const useStatisticStore = defineStore("statistic", {
    state: () => ({
        sales: [],
        saleId: null,
        datailSale: null,
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
        },
        setSaleId(id) {
            this.saleId = id;
        },
        getSalesDetails(id) {
            return new Promise((resolve, reject) => {
                axios.get(`pointsales/get/${id}`).then((response) => {
                    this.datailSale = response.data.sale;
                    resolve(response)
                }).catch((error) => {
                    reject(error)
                })
            })
        }
    }
});
